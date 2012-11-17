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

    function start($kode_wkf, $kode_transisi, $notes = null, $user = null) {
//        $query = $this->db->query("select kode_wkf, kode_aktifitas, kode_posisi, kode_user, kode_aplikasi, parameter, tipe 
//                                    from EP_WKF_AKTIFITAS 
//                                    where kode_wkf = $kode_wkf and is_mulai = 1");
//        $node = $query->row_array();
//
//        // build params
//        $node['PARAMETER'] = $this->getParamfromRequest($node['PARAMETER']);
//
//        $tipe = $node['TIPE'];
//        unset($node['TIPE']);
//        $node['TANGGAL_MULAI'] = date("Y-m-d");
//        $node['PARAMETER'] = json_encode($node['PARAMETER']);
//
//        $this->db->insert("EP_WKF_PROSES", $node);
//
//        $query = $this->db->query("select max(KODE_PROSES) as \"kode_proses\" from EP_WKF_PROSES");
//        $row = $query->row_array();
//        $this->triggerCheckNodeType($tipe, $row['kode_proses']);
//        return $row['kode_proses'];

        // load transition object
        $transition = $this->getTransitionById($kode_transisi);

        // load node object
        $node = $this->getNodeById($transition['AKTIFITAS_TUJUAN']);

        // build params
        $parameters = $this->getParamfromRequest($node['PARAMETER']);

        $tipe = $node['TIPE'];

        // create new instance process
        $process = array();
        $process['TANGGAL_MULAI'] = date("Y-m-d H:i:s");
        $process['PARAMETER'] = json_encode($parameters);
        $process['KODE_WKF'] = $kode_wkf;
        $process['KODE_AKTIFITAS'] = $node['KODE_AKTIFITAS'];
        $process['KODE_POSISI'] = $node['KODE_POSISI'];
        $process['KODE_USER'] = $node['KODE_USER'];
        $process['KODE_APLIKASI'] = $node['KODE_APLIKASI'];
        $this->db->insert("EP_WKF_PROSES", $process);
        
        $query = $this->db->query("select max(KODE_PROSES) as \"kode_proses\" from EP_WKF_PROSES");
        $row = $query->row_array();
        $kode_proses = $row['kode_proses'];
        
        // append history
        $history = array();
        $history['kode_proses'] = $kode_proses;
        $history['catatan'] = ($notes ? $notes : (isset($_REQUEST['catatan']) ? $_REQUEST['catatan'] : $transition['NAMA_TRANSISI']));
        $history['kode_transisi'] = $transition['KODE_TRANSISI'];
        $history['tgl_rekam'] = date("Y-m-d H:i:s");
        $history['petugas_rekam'] = ($user ? $user : 'system user session');

        $this->insertHistory($history);
        $this->triggerCheckNodeType($tipe, $kode_proses);
        
        return $kode_proses;
    }

    function executeNode($kode_proses, $kode_transisi, $notes = null, $user = null) {

        // load transition object
        $transition = $this->getTransitionById($kode_transisi);

        // load node object
        $node = $this->getNodeById($transition['AKTIFITAS_TUJUAN']);

        // append history
        $history = array();
        $history['kode_proses'] = $kode_proses;
        $history['catatan'] = ($notes ? $notes : (isset($_REQUEST['catatan']) ? $_REQUEST['catatan'] : $transition['NAMA_TRANSISI']));
        $history['kode_transisi'] = $transition['KODE_TRANSISI'];
        $history['tgl_rekam'] = date("Y-m-d H:i:s");
        $history['petugas_rekam'] = ($user ? $user : 'system user session');

        // update instance
        $instance = array();
        $instance['kode_aktifitas'] = $node['KODE_AKTIFITAS'];

        $params = $this->getParamfromRequest($node['PARAMETER']);
        $instance['parameter'] = json_encode($params);

        if ($node['IS_AKHIR'])
            $instance['tanggal_selesai'] = date("Y-m-d H:i:s");

        $this->runTransitionConstraint($kode_transisi, $params);
        $this->insertHistory($history);
        $this->updateInstance($instance, array('kode_proses' => $kode_proses));
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
        $node = $this->getNodeById($row['KODE_AKTIFITAS']);
        // build params

        $row['PARAMETER'] = $this->getParamfromRequest($node['PARAMETER']);

        //this save instance parameter
        $this->insertOrUpdateParams($row['PARAMETER'], $kode_proses, '');
        $this->runNodeConstraint($row['KODE_AKTIFITAS'], $row['PARAMETER']);
        $this->runAutoTransition($kode_proses, $row['KODE_AKTIFITAS'], $row['PARAMETER']);
    }

    function triggerHumanNode($kode_proses) {
        //load instance
        $row = $this->getInstance($kode_proses);
        $node = $this->getNodeById($row['KODE_AKTIFITAS']);

        // assign user
        // build params and write to db
        $row['PARAMETER'] = $this->getParamfromRequest($node['PARAMETER']);
        $this->updateInstance(array('parameter' => json_encode($row['PARAMETER'])), array('kode_proses' => $kode_proses));
        $this->insertOrUpdateParams($row['PARAMETER'], $kode_proses, '');
        $this->runNodeConstraint($row['KODE_AKTIFITAS'], $row['PARAMETER']);
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
                    eval($v['KONTEKS']);
                    break;
                case 'sql' :
                    $this->db->query($v['KONTEKS']);
                    break;
            }
        }
    }

    function runTransitionConstraint($kode_transisi, $variables = null) {

        if (!$variables)
            return;

        // get available constraints & replace @@parameter for execution
        $constraints = $this->getTransitionConstraints($kode_transisi);
        
        $json_constraints = json_encode($constraints);
        foreach ($variables as $k => $v) {
            $json_constraints = str_replace('@@' . $k . '@@', $v, $json_constraints);
        }
//        echo $kode_aktifitas;
//die($json_constraints);
        foreach (json_decode($json_constraints, true) as $v) {
            switch ($v['TIPE']) {
                case 'php' :
                    eval($v['KONTEKS']);
                    break;
                case 'sql' :
                    $this->db->query($v['KONTEKS']);
                    break;
            }
        }
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
//        print_r($transistions);
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
            $this->executeNode($kode_proses, $default_transition['KODE_TRANSISI'], $default_transition['NAMA_TRANSISI'], 'system user session');

        return $result;
    }

    /*
     * return list of array transitions from given node
     */

    function getNodeById($id) {
        $query = $this->db->query("select * from EP_WKF_AKTIFITAS where kode_aktifitas = $id");
        return $query->row_array();
    }

    function getTransitionById($id) {
        $query = $this->db->query("select * from EP_WKF_TRANSISI where kode_transisi = $id");
        return $query->row_array();
    }

    function getTransition($kode_aktifitas) {
        $query = $this->db->query("select * from EP_WKF_TRANSISI where aktifitas_asal = $kode_aktifitas");
        return $query->result_array();
    }

    function getNodeConstraints($kode_aktifitas, $where = array()) {
        $where = $where + array('kode_aktifitas' => $kode_aktifitas, 'aktif' => 1);
        //$query = $this->db->query("select * from EP_WKF_AKTIFITAS_CONST where kode_aktifitas = $kode_aktifitas");

        $query = $this->db->get_where("EP_WKF_AKTIFITAS_CONST", $where);
        return $query->result_array();
    }

    function getTransitionConstraints($kode_transisi, $where = array()) {
        $where = $where + array('kode_transisi' => $kode_transisi);
        //$query = $this->db->query("select * from EP_WKF_AKTIFITAS_CONST where kode_aktifitas = $kode_aktifitas");

        $query = $this->db->get_where("EP_WKF_TRANSISI_CONST", $where);
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
        $query = $this->db->query("select a.*, b.url_params from EP_WKF_PROSES a
                    inner join (
                        select rtrim(xmlagg(xmlelement(e, '&' || key || '=' || value )).extract('//text()').extract('//text()') ,',') url_params, kode_proses 
                        from EP_WKF_PROSES_VARS
                        group by KODE_PROSES
                    ) b on A.KODE_PROSES = B.KODE_PROSES 
                    where a.kode_proses = coalesce($kode_proses, a.kode_proses) and a.tanggal_selesai is null");
        return $query->result_array();
    }

    function getEndInstances($kode_proses = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES where kode_proses = coalesce($kode_proses, kode_proses) and tanggal_selesai is not null");
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
                else
                    show_error ("required parameter not found : " . $k);
            }

            return (count($data) > 0 ? $data : false);
        }

        return false;
    }

    function getParamfromDB($kode_proses) {
        //die("select * from EP_WKF_PROSES_VARS where kode_proses = coalesce($kode_proses, kode_proses)");
        $query = $this->db->query("select * from EP_WKF_PROSES_VARS where kode_proses = coalesce($kode_proses, kode_proses)");
        return $query->result_array();
    }

    function getConstraintForExecution($kode_proses, $kode_aktifitas, $kegiatan, $variables = array()) {

        if (!count($variables))
            $variables = $this->getParamfromDB($kode_proses);

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