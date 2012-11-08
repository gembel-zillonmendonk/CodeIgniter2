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
        $query = $this->db->query("select wkf_id, id as node_id, role_id, user_id, app_id, parameters, type from wkf_node where wkf_id = $wkf_id and is_start = 1");
        $node = $query->row_array();

        // build params
        $node['PARAMETERS'] = $this->getParamfromRequest($node['PARAMETERS']);

        $type = $node['TYPE'];
        unset($node['TYPE']);
        $node['START_DATE'] = date("Y-m-d");
        $node['PARAMETERS'] = json_encode($node['PARAMETERS']);

        $this->db->insert("wkf_instance", $node);

        $query = $this->db->query("select max(ID) as \"idx\" from wkf_instance");
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
        $this->triggerCheckNodeType($node['TYPE'], $instance_id);
    }

    function triggerCheckNodeType($type, $instance_id) {
        if ($type == 'system') {
            $this->triggerNodeSystem($instance_id);
        } else {
            $this->triggerHumanSystem($instance_id);
        }
    }

    function triggerNodeSystem($instance_id) {
        //load instance
        $row = $this->getInstance($instance_id);
        $node = $this->getNodeById($row['NODE_ID']);
        // build params
        
        $row['PARAMETERS'] = $this->getParamfromRequest($node['PARAMETERS']);

        //this save instance parameter

        $this->runNodeConstraint($row['NODE_ID'], $row['PARAMETERS']);
        $this->runAutoTransition($instance_id, $row['NODE_ID'], $row['PARAMETERS']);
    }

    function triggerHumanSystem($instance_id) {
        //load instance
        $row = $this->getInstance($instance_id);
        $node = $this->getNodeById($row['NODE_ID']);

        // assign user
        // build params and write to db
        $row['PARAMETERS'] = $this->getParamfromRequest($node['PARAMETERS']);
        $this->updateInstance(array('parameters' => json_encode($row['PARAMETERS'])), array('id' => $instance_id));

        $this->runNodeConstraint($row['NODE_ID'], $row['PARAMETERS']);
    }

    function runNodeConstraint($node_id, $parameters = array()) {
        $constraints = $this->getNodeConstraints($node_id);
        foreach ($constraints as $value) {
            // replace variable in context with parameters
            $cmd = $v['CONTEXT'];
            foreach ($parameters as $key => $val) {
                $cmd = str_replace($key, $val, $cmd);
            }

            if ($value['TYPE'] == 'sql')
                $this->db->query($cmd);
            else
                eval($cmd);
        }
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
        if(!$result)
            $this->executeNode($instance_id, $default_transition['ID'], $default_transition['NAME'], 'system user session');
        
        return $result;
    }

    /*
     * return list of array transitions from given node
     */

    function getNodeById($id) {
        $query = $this->db->query("select * from wkf_node where id = $id");
        return $query->row_array();
    }

    function getTransitionById($id) {
        $query = $this->db->query("select * from wkf_transition where id = $id");
        return $query->row_array();
    }

    function getTransition($node_id) {
        $query = $this->db->query("select * from wkf_transition where node_from = $node_id");
        return $query->result_array();
    }

    function getNodeConstraints($node_id) {
        $query = $this->db->query("select * from wkf_node_constraint where node_id = $node_id");
        return $query->result_array();
    }

    function getInstance($id = 'null') {
        $query = $this->db->query("select * from wkf_instance where id = coalesce($id, id)");
        return $query->row_array();
    }

    function getHistory($instance_id = 'null') {
        $query = $this->db->query("select * from wkf_instance_history where instance_id = $instance_id");
        return $query->result_array();
    }

    function getActiveInstances($id = 'null') {
        $query = $this->db->query("select * from wkf_instance where id = coalesce($id, id) and end_date is null");
        return $query->result_array();
    }

    function getEndInstances($id = 'null') {
        $query = $this->db->query("select * from wkf_instance where id = coalesce($id, id) and end_date is not null");
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
            
            return $data;
        }

        return false;
    }

    function insertHistory($data) {
        $this->db->insert("wkf_instance_history", $data);
    }

    function updateInstance($data, $where = array()) {
        $this->db->update("wkf_instance", $data, $where);
    }

}

?>