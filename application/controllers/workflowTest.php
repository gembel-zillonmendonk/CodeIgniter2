<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WorkflowTest extends CI_Controller
{
    public function index()
    {
        $this->load->library('workflow');

        $active = $this->workflow->getActiveInstances();
        $finish = $this->workflow->getEndInstances();
        $this->load->view('workflow_list', array(
            'active' => $active, 
            'finish' => $finish, 
            ));
    }

    public function view()
    {
        $this->load->library('workflow');

        $rows = $this->workflow->getHistory($_REQUEST['instance_id']);
        $this->load->view('workflow_view', array(
            'rows' => $rows, 
            ));
    }
    
    public function run()
    {
        $this->load->library('workflow');

        $instance_id = isset($_REQUEST['instance_id']) ? $_REQUEST['instance_id'] : null;
        if (!isset($instance_id))
        {
            $wkf_id = 1;
            $this->workflow->start($wkf_id);
            redirect('/workflowTest/index');
        }

        if ($_POST)
        {
            $transition_id = $_REQUEST['transition_id'];
            $notes = isset($_REQUEST['notes']) ? $_REQUEST['notes'] : null;
            $user = isset($_REQUEST['user']) ? $_REQUEST['user'] : null;
            $this->workflow->executeNode($instance_id, $transition_id, $notes, $user);
//            $node_from = $_REQUEST['node_from'];
//            $transition_id = $_REQUEST['transition_id'];
//
//            // load transition object
//            $transition = $this->workflow->getTransitionById($transition_id);
//
//            // append history
//            $history = array();
//            $history['instance_id'] = $instance_id;
//            $history['notes'] = $transition['NAME'];
//            $history['transition_id'] = $transition['ID'];
//            $history['create_date'] = date("Y-m-d");
//            $history['create_by'] = 'system user session';
//
//            $this->workflow->insertHistory($history);
//
//            // load node object
//            $node = $this->workflow->getNodeById($transition['NODE_TO']);
//
//            // update instance
//            $instance = array();
//            $instance['node_id'] = $transition['NODE_TO'];
//
//            $params = $this->workflow->getParamfromRequest($node['PARAMETERS']);
//            $instance['parameters'] = json_encode($params);
//
//            if ($node['IS_FINISH'])
//                $instance['end_date'] = date("Y-m-d");
//
//            $this->workflow->updateInstance($instance, array('id' => $instance_id));
            
            redirect('/workflowTest/index');
        }
        
        // load workflow instance
        $instance = $this->workflow->getInstance($instance_id);
        // load workflow instance
        $history = $this->workflow->getHistory($instance_id);

        // get available transition
        $transitions = $this->workflow->getTransition($instance['NODE_ID']);
        
        // build parameters if exists
        $parameters = array();
        foreach ($transitions as $v) {
            $node = $this->workflow->getNodeById($v['NODE_TO']);
            $parameters = $parameters + (array)json_decode($node['PARAMETERS'],true);
        }
        
        $this->load->view('workflow_run', array(
            'instance' => $instance,
            'history' => $history,
            'transitions' => $transitions,
            'parameters' => $parameters,
        ));
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */