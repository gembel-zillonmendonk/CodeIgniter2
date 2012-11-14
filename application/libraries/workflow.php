<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Workflow {

    var $obj;
    var $db;

    function __construct() {
        $this->obj = & get_instance();
        $this->db = $this->obj->db;
        log_message('debug', 'Workflow class loaded');
    }

    function start($kode_wkf) {
        $query = $this->db->query("select kode_wkf, id as kode_aktifitas, kode_posisi, kode_user, kode_aplikasi, parameter, tipe from EP_WKF_AKTIFITAS where kode_wkf = $kode_wkf and is_mulai = 1");
        $node = $query->row_array();

        // build params
        $node['PARAMETER'] = $this->getParamfromRequest($node['PARAMETER']);

        $tipe = $node['TIPE'];
        unset($node['TIPE']);
        $node['START_DATE'] = date("Y-m-d");
        $node['PARAMETER'] = json_encode($node['PARAMETER']);

        $this->db->insert("EP_WKF_PROSES", $node);

        $query = $this->db->query("select max(KODE_PROSES) as \"idx\" from EP_WKF_PROSES");
        $row = $query->row_array();
        $this->triggerCheckNodeType($tipe, $row['idx']);
        return true;
    }

    function executeNode($kode_proses, $transition_id, $notes = null, $user = null) {

        // load transition object
        $transition = $this->getTransitionById($transition_id);

        // load node object
        $node = $this->getNodeById($transition['AKTIFITAS_ASAL']);

        // append history
        $history = array();
        $history['kode_proses'] = $kode_proses;
        $history['notes'] = ($notes ? $notes : $transition['NAMA']);
        $history['transition_id'] = $transition['ID'];
        $history['create_date'] = date("Y-m-d");
        $history['create_by'] = ($user ? $user : 'system user session');

        // update instance
        $instance = array();
        $instance['kode_aktifitas'] = $node['ID'];

        $params = $this->getParamfromRequest($node['PARAMETER']);
        $instance['parameter'] = json_encode($params);

        if ($node['IS_FINISH'])
            $instance['end_date'] = date("Y-m-d");

        $this->insertHistory($history);
        $this->updateInstance($instance, array('id' => $kode_proses));
        $this->insertOrUpdateParams($params, $kode_proses, '');
        $this->triggerCheckNodeType($node['TIPE'], $kode_proses);
    }

    function triggerCheckNodeType($tipe, $kode_proses) {
        if ($tipe == 'system') {
            $this->triggerSystemNode($kode_proses);
        } else {
            $this->triggerHumanNode($kode_proses);
        }
    }

    function triggerSystemNode($kode_proses) {
        //load instance
        $row = $this->getInstance($kode_proses);
        $node = $this->getNodeById($row['NODE_ID']);
        // build params

        $row['PARAMETER'] = $this->getParamfromRequest($node['PARAMETER']);

        //this save instance parameter

        $this->runNodeConstraint($row['NODE_ID'], $row['PARAMETER']);
        $this->runAutoTransition($kode_proses, $row['NODE_ID'], $row['PARAMETER']);
    }

    function triggerHumanNode($kode_proses) {
        //load instance
        $row = $this->getInstance($kode_proses);
        $node = $this->getNodeById($row['NODE_ID']);

        // assign user
        // build params and write to db
        $row['PARAMETER'] = $this->getParamfromRequest($node['PARAMETER']);
        $this->updateInstance(array('parameter' => json_encode($row['PARAMETER'])), array('id' => $kode_proses));
        $this->insertOrUpdateParams($row['PARAMETER'], $kode_proses, '');
        $this->runNodeConstraint($row['NODE_ID'], $row['PARAMETER']);
    }

    function runNodeConstraint($kode_aktifitas, $variables = null) {

        if (!$variables)
            return;

        // get available constraints & replace @@parameter for execution
        $constraints = $this->getNodeConstraints($kode_aktifitas, array('kegiatan' => 'onexecute'));
        
        $json_constraints = json_encode($constraints);
        foreach ($variables as $k => $v) {
            $json_constraints = str_replace('@@' . $k . '@@', $v, $json_constraints);
        }
//        echo $kode_aktifitas;
//die($json_constraints);
        foreach (json_decode($json_constraints, true) as $v) {
            switch ($v['TIPE']) {
                case 'php' :
                    eval($v['CONTEXT']);
                    break;
                case 'sql' :
                    $this->db->query($v['CONTEXT']);
                    break;
            }
        }

//        $constraints = $this->getNodeConstraints($kode_aktifitas, array('kegiatan' => 'onExecute'));
//        foreach ($constraints as $v) {
//            // replace variable in context with parameter
//            $cmd = $v['CONTEXT'];
//            foreach ($parameter as $key => $val) {
//                $cmd = str_replace('@@' . $key . '@@', $val, $cmd);
//            }
//
//            switch ($v['TIPE']) {
//                case 'php' :
//                    eval($cmd);
//                    break;
//                case 'sql' :
//                    $this->db->query($cmd);
//                    break;
//            }
//        }
    }

    // execute by node system
    function runAutoTransition($kode_proses, $kode_aktifitas, $parameter = array()) {

        if (count($parameter) < 1)
            return;

        $var = '';
        foreach ($parameter as $k => $v) {
            $var .= '$' . $k . ' = "' . $v . '"; ';
        }

        $transistions = $this->getTransition($kode_aktifitas);
        $default_transition = null;
        $result = false;
        foreach ($transistions as $transistion) {
            if ($transistion['KONDISI'] == 'default') {
                $default_transition = $transistion;
                continue;
            }

            $condition = $transistion['KONDISI'];
            $condition = 'if(' . $condition . ') return true; else return false;';
            $result = eval($var . $condition);

            if ($result) {
                $this->executeNode($kode_proses, $transistion['KODE_TRANSISI'], $transistion['NAMA_TRANSISI'], 'system user session');
                break;
            }
        }

        // default transition if no matching value found
        if (!$result)
            $this->executeNode($kode_proses, $default_transition['ID_TRANSISI'], $default_transition['NAMA_TRANSISI'], 'system user session');

        return $result;
    }

    /*
     * return list of array transitions from given node
     */

    function getNodeById($id) {
        $query = $this->db->query("select * from EP_WKF_AKTIFITAS where id = $id");
        return $query->row_array();
    }

    function getTransitionById($id) {
        $query = $this->db->query("select * from EP_WKF_TRANSISI where id = $id");
        return $query->row_array();
    }

    function getTransition($kode_aktifitas) {
        $query = $this->db->query("select * from EP_WKF_TRANSISI where aktifitas_asal = $kode_aktifitas");
        return $query->result_array();
    }

    function getNodeConstraints($kode_aktifitas, $where = array()) {
        $where = $where + array('kode_aktifitas' => $kode_aktifitas);
        //$query = $this->db->query("select * from EP_WKF_AKTIFITAS_CONST where kode_aktifitas = $kode_aktifitas");

        $query = $this->db->get_where("EP_WKF_AKTIFITAS_CONST", $where);
        return $query->result_array();
    }

    function getInstance($kode_proses = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES where kode_proses = coalesce($kode_proses, kode_proses)");
        return $query->row_array();
    }

    function getHistory($kode_proses = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES_HIS where kode_proses = $kode_proses");
        return $query->result_array();
    }

    function getActiveInstances($kode_proses = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES where kode_proses = coalesce($kode_proses, kode_proses) and end_date is null");
        return $query->result_array();
    }

    function getEndInstances($kode_proses = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES where kode_proses = coalesce($kode_proses, kode_proses) and end_date is not null");
        return $query->result_array();
    }

    function buildGraph($kode_proses) {
        
    }
    
    function getParamfromRequest($params) {

        if (!is_array($params))
            $params = json_decode($params, true);

        if (count($params) > 0) {
            $data = array();
            foreach ($params as $k => $v) {
                if (isset($_REQUEST[$k]))
                    $data[$k] = $_REQUEST[$k];
            }

            return (count($data) > 0 ? $data : false);
        }

        return false;
    }

    function getParamfromDB($kode_proses) {
        $query = $this->db->query("select * from EP_WKF_PROSES_VARS where kode_proses = coalesce($kode_proses, kode_proses)");
        return $query->result_array();
    }

    function getConstraintForExecution($kode_proses, $kode_aktifitas, $kegiatan, $variables = array()) {

        if (!count($variables))
            $this->getParamfromDB($kode_proses);

        // get available constraints & replace @@parameter for execution
        $constraints = $this->getNodeConstraints($kode_aktifitas, array('kegiatan' => $kegiatan));

        $json_constraints = json_encode($constraints);
        foreach ($variables as $v) {
            $json_constraints = str_replace('@@' . $v['KEY'] . '@@', $v['VALUE'], $json_constraints);
        }

        return json_decode($json_constraints, true);
    }

    function insertHistory($data) {
        $this->db->insert("EP_WKF_PROSES_HIS", $data);
    }

    function insertOrUpdateParams($params = null, $kode_proses, $kode_proses_his = '') {
        if ($params) {

            foreach ($params as $k => $v) {
                if (strlen($v) > 0) {
                    $var = array(
                        'key' => $k,
                        'value' => $v,
                        'kode_proses' => $kode_proses,
                        'kode_proses_his' => $kode_proses_his,
                        'tipe' => 'text',
                    );

                    $query = $this->db->query("select * from EP_WKF_PROSES_VARS where key='$k' and kode_proses=" . $kode_proses);
                    $row = $query->row_array();
                    if (count($row) > 0)
                        $this->db->update('EP_WKF_PROSES_VARS', $var, "key='$k' and kode_proses=" . $kode_proses);
                    else
                        $this->db->insert('EP_WKF_PROSES_VARS', $var);
                }
            }
        }
    }

    function updateInstance($data, $where = array()) {
        $this->db->update("EP_WKF_PROSES", $data, $where);
    }

}

?>