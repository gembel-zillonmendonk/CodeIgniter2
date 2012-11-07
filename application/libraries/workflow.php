<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Workflow {

    var $obj;
    var $layout;

    function __construct() {
        $this->obj = & get_instance();
        $this->layout = $layout;

        log_message('debug', 'Workflow class loaded');
    }

    function start($wkf_id) {
        $db = $this->obj->db;
        $query = $db->query("select wkf_id, node_id, start_date, role_id, user_id, app_id, parameters, type from wkf_node where wkf_id = $wkf_id and is_start = 1");
        $row = $query->row_array();

        // build params
        $row['parameters'] = $this->getParamfromRequest($row['parameters']);

        if ($row['type'] == 'system') {
            $this->startNodeSystem($row['wkf_id'], $row['node_id'], $row['role_id'], $row['user_id'], $row['app_id'], $row['parameters']);
            return true;
        }

        unset($row['type']);
        $row['start_date'] = date("Y-m-d");
        $row['parameters'] = json_encode($row['parameters']);
        
        $db->insert("wkf_instance", $row);
        return true;
    }

    function executeNode($instance_id, $wkf_Id, $node_from, $node_to, $role, $user, $app, $params) {
        
    }

    function startNodeSystem($wkf_Id, $node_id, $role, $user, $app, $params = array()) {
        //load list of constraint
        $db = $this->obj->db;
        $query = $db->query("select * from wkf_node_constraint where node_id = $wkf_id");
        $rows = $query->rows_array();
        foreach ($rows as $k => $v) {

            // replace variable in context with parameters
            $cmd = $v['context'];
            foreach ($params as $key => $val) {
                $cmd = str_replace($key, $val, $cmd);
            }

            switch ($v['type']) {
                case 'php' :
                    eval($cmd);
                    break;
                case 'sql' :
                    $db->query($cmd);
                    break;
                default :
                    break;
            }
        }
    }

    function executeNodeSystem($instance_id, $wkf_Id, $node_from, $node_to, $role, $user, $app, $params = array()) {
        //load list of constraint
        $db = $this->obj->db;
        $query = $db->query("select * from wkf_instance where instance_id = $instance_id");
        $row = $query->row_array();
        
        // build params
        $row['parameters'] = $this->getParamfromRequest($row['parameters']);
        $this->startNodeSystem($row['wkf_id'], $row['node_id'], $row['role_id'], $row['user_id'], $row['app_id'], $row['parameters']);
        
    }

    /*
     * return list of array transitions from given node
     */

    function getTransition($node_id) {
        
    }

    function getInstance($wkf_id) {
        
    }

    function getParamfromRequest($params) {
        if (!is_array($params))
            $params = json_decode($params);

        if (count($params) > 0) {
            $data = array();
            foreach ($params as $k => $v) {
                if (isset($_REQUEST[$k]))
                    $data[$k] = $v;
            }
            return $data;
        }

        return false;
    }

}

?>