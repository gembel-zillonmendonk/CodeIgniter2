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

    function start($wkf_id) {
        $query = $this->db->query("select wkf_id, id as node_id, role_id, user_id, app_id, parameters, type from EP_WKF_AKTIFITAS where wkf_id = $wkf_id and is_start = 1");
        $node = $query->row_array();

        // build params
        $node['PARAMETERS'] = $this->getParamfromRequest($node['PARAMETERS']);

        $type = $node['TYPE'];
        unset($node['TYPE']);
        $node['START_DATE'] = date("Y-m-d");
        $node['PARAMETERS'] = json_encode($node['PARAMETERS']);

        $this->db->insert("EP_WKF_PROSES", $node);

        $query = $this->db->query("select max(ID) as \"idx\" from EP_WKF_PROSES");
        $row = $query->row_array();
        $this->triggerCheckNodeType($type, $row['idx']);
        return true;
    }

    function executeNode($instance_id, $transition_id, $notes = null, $user = null) {

        // load transition object
        $transition = $this->getTransitionById($transition_id);

        // load node object
        $node = $this->getNodeById($transition['NODE_TO']);

        // append history
        $history = array();
        $history['instance_id'] = $instance_id;
        $history['notes'] = ($notes ? $notes : $transition['NAME']);
        $history['transition_id'] = $transition['ID'];
        $history['create_date'] = date("Y-m-d");
        $history['create_by'] = ($user ? $user : 'system user session');

        // update instance
        $instance = array();
        $instance['node_id'] = $node['ID'];

        $params = $this->getParamfromRequest($node['PARAMETERS']);
        $instance['parameters'] = json_encode($params);

        if ($node['IS_FINISH'])
            $instance['end_date'] = date("Y-m-d");

        $this->insertHistory($history);
        $this->updateInstance($instance, array('id' => $instance_id));
        $this->insertOrUpdateParams($params, $instance_id, '');
        $this->triggerCheckNodeType($node['TYPE'], $instance_id);
    }

    function triggerCheckNodeType($type, $instance_id) {
        if ($type == 'system') {
            $this->triggerSystemNode($instance_id);
        } else {
            $this->triggerHumanNode($instance_id);
        }
    }

    function triggerSystemNode($instance_id) {
        //load instance
        $row = $this->getInstance($instance_id);
        $node = $this->getNodeById($row['NODE_ID']);
        // build params

        $row['PARAMETERS'] = $this->getParamfromRequest($node['PARAMETERS']);

        //this save instance parameter

        $this->runNodeConstraint($row['NODE_ID'], $row['PARAMETERS']);
        $this->runAutoTransition($instance_id, $row['NODE_ID'], $row['PARAMETERS']);
    }

    function triggerHumanNode($instance_id) {
        //load instance
        $row = $this->getInstance($instance_id);
        $node = $this->getNodeById($row['NODE_ID']);

        // assign user
        // build params and write to db
        $row['PARAMETERS'] = $this->getParamfromRequest($node['PARAMETERS']);
        $this->updateInstance(array('parameters' => json_encode($row['PARAMETERS'])), array('id' => $instance_id));
        $this->insertOrUpdateParams($row['PARAMETERS'], $instance_id, '');
        $this->runNodeConstraint($row['NODE_ID'], $row['PARAMETERS']);
    }

    function runNodeConstraint($node_id, $variables = null) {

        if (!$variables)
            return;

        // get available constraints & replace @@parameter for execution
        $constraints = $this->getNodeConstraints($node_id, array('event' => 'onexecute'));
        
        $json_constraints = json_encode($constraints);
        foreach ($variables as $k => $v) {
            $json_constraints = str_replace('@@' . $k . '@@', $v, $json_constraints);
        }
//        echo $node_id;
//die($json_constraints);
        foreach (json_decode($json_constraints, true) as $v) {
            switch ($v['TYPE']) {
                case 'php' :
                    eval($v['CONTEXT']);
                    break;
                case 'sql' :
                    $this->db->query($v['CONTEXT']);
                    break;
            }
        }

//        $constraints = $this->getNodeConstraints($node_id, array('event' => 'onExecute'));
//        foreach ($constraints as $v) {
//            // replace variable in context with parameters
//            $cmd = $v['CONTEXT'];
//            foreach ($parameters as $key => $val) {
//                $cmd = str_replace('@@' . $key . '@@', $val, $cmd);
//            }
//
//            switch ($v['TYPE']) {
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
    function runAutoTransition($instance_id, $node_id, $parameters = array()) {

        if (count($parameters) < 1)
            return;

        $var = '';
        foreach ($parameters as $k => $v) {
            $var .= '$' . $k . ' = "' . $v . '"; ';
        }

        $transistions = $this->getTransition($node_id);
        $default_transition = null;
        $result = false;
        foreach ($transistions as $value) {
            if ($value['CONDITION'] == 'default') {
                $default_transition = $value;
                continue;
            }

            $condition = $value['CONDITION'];
            $condition = 'if(' . $condition . ') return true; else return false;';
            $result = eval($var . $condition);

            if ($result) {
                $this->executeNode($instance_id, $value['ID'], $value['NAME'], 'system user session');
                break;
            }
        }

        // default transition if no matching value found
        if (!$result)
            $this->executeNode($instance_id, $default_transition['ID'], $default_transition['NAME'], 'system user session');

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

    function getTransition($node_id) {
        $query = $this->db->query("select * from EP_WKF_TRANSISI where node_from = $node_id");
        return $query->result_array();
    }

    function getNodeConstraints($node_id, $where = array()) {
        $where = $where + array('node_id' => $node_id);
        //$query = $this->db->query("select * from EP_WKF_AKTIFITAS_CONST where node_id = $node_id");

        $query = $this->db->get_where("EP_WKF_AKTIFITAS_CONST", $where);
        return $query->result_array();
    }

    function getInstance($id = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES where id = coalesce($id, id)");
        return $query->row_array();
    }

    function getHistory($instance_id = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES_HIS where instance_id = $instance_id");
        return $query->result_array();
    }

    function getActiveInstances($id = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES where id = coalesce($id, id) and end_date is null");
        return $query->result_array();
    }

    function getEndInstances($id = 'null') {
        $query = $this->db->query("select * from EP_WKF_PROSES where id = coalesce($id, id) and end_date is not null");
        return $query->result_array();
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

    function getParamfromDB($instance_id) {
        $query = $this->db->query("select * from EP_WKF_PROSES_VARS where instance_id = coalesce($instance_id, instance_id)");
        return $query->result_array();
    }

    function getConstraintForExecution($instance_id, $node_id, $event, $variables = array()) {

        if (!count($variables))
            $this->getParamfromDB($instance_id);

        // get available constraints & replace @@parameter for execution
        $constraints = $this->getNodeConstraints($node_id, array('event' => $event));

        $json_constraints = json_encode($constraints);
        foreach ($variables as $v) {
            $json_constraints = str_replace('@@' . $v['KEY'] . '@@', $v['VALUE'], $json_constraints);
        }

        return json_decode($json_constraints, true);
    }

    function insertHistory($data) {
        $this->db->insert("EP_WKF_PROSES_HIS", $data);
    }

    function insertOrUpdateParams($params = null, $instance_id, $instance_process_id = '') {
        if ($params) {

            foreach ($params as $k => $v) {
                if (strlen($v) > 0) {
                    $var = array(
                        'key' => $k,
                        'value' => $v,
                        'instance_id' => $instance_id,
                        'instance_process_id' => $instance_process_id,
                        'type' => 'text',
                    );

                    $query = $this->db->query("select * from EP_WKF_PROSES_VARS where key='$k' and instance_id=" . $instance_id);
                    $row = $query->row_array();
                    if (count($row) > 0)
                        $this->db->update('EP_WKF_PROSES_VARS', $var, "key='$k' and instance_id=" . $instance_id);
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