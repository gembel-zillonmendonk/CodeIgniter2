<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WorkflowTest extends MX_Controller {

    public function index() {
        $this->load->library('workflow');

        $active = $this->workflow->getActiveInstances();
        $finish = $this->workflow->getEndInstances();
        $this->layout->view('workflow_list', array(
            'active' => $active,
            'finish' => $finish,
        ));
    }

    public function viewGraph() {

        require_once 'Image/GraphViz.php';
        $gv = new Image_GraphViz();
        $gv->addEdge(array('wake up' => 'visit bathroom'));
        $gv->addEdge(array('visit bathroom' => 'make coffee'));
        //$gv->image();
        
        require_once 'Image/GraphViz.php';

        $graph = new Image_GraphViz(false, null, 'G', false);

        $graph->addEdge(array('run' => 'intr'));
        $graph->addEdge(array('intr' => 'runbl'));
        $graph->addEdge(array('runbl' => 'run'));
        $graph->addEdge(array('run' => 'kernel'));
        $graph->addEdge(array('kernel' => 'zombie'));
        $graph->addEdge(array('kernel' => 'sleep'));
        $graph->addEdge(array('kernel' => 'runmem'));
        $graph->addEdge(array('sleep' => 'swap'));
        $graph->addEdge(array('swap' => 'runswap'));
        $graph->addEdge(array('runswap' => 'new'));
        $graph->addEdge(array('runswap' => 'runmem'));
        $graph->addEdge(array('new' => 'runmem'));
        $graph->addEdge(array('sleep' => 'runmem'));

        echo $graph->parse();
        echo $graph->image('png');

//        $this->load->library('GraphViz');
//        
//        $this->GraphViz->addEdge(array('wake up' => 'visit bathroom'));
//        $this->GraphViz->addEdge(array('visit bathroom' => 'make coffee'));
//        $this->GraphViz->image();
    }

    public function view() {
        $this->load->library('workflow');

        $rows = $this->workflow->getHistory($_REQUEST['instance_id']);
        $this->layout->view('workflow_view', array(
            'rows' => $rows,
        ));
    }

    public function run() {
        $this->load->library('workflow');

        $instance_id = isset($_REQUEST['instance_id']) ? $_REQUEST['instance_id'] : null;
        if (!isset($instance_id)) {
            $wkf_id = 1;
            $this->workflow->start($wkf_id);
            redirect('/workflowTest/index');
        }

        if ($_POST) {
            $transition_id = $_REQUEST['transition_id'];
            $notes = isset($_REQUEST['notes']) ? $_REQUEST['notes'] : null;
            $user = isset($_REQUEST['user']) ? $_REQUEST['user'] : null;
            $this->workflow->executeNode($instance_id, $transition_id, $notes, $user);

            redirect('/workflowTest/index');
        }

        // load workflow instance
        $instance = $this->workflow->getInstance($instance_id);
        // load workflow instance
        $history = $this->workflow->getHistory($instance_id);
        // load workflow variable
        $variables = $this->workflow->getParamfromDB($instance_id);
        
        // get available transition
        $transitions = $this->workflow->getTransition($instance['NODE_ID']);

        // get available constraints & replace @@parameter for execution
        $constraints = $this->workflow->getConstraintForExecution($instance_id, $instance['NODE_ID'], 'onload', $variables);
        
        // build parameters if exists
        $parameters = array();
        foreach ($transitions as $v) {
            $node = $this->workflow->getNodeById($v['NODE_TO']);
            $parameters = $parameters + (array) json_decode($node['PARAMETERS'], true);
        }

        $this->layout->view('workflow_run', array(
            'instance' => $instance,
            'history' => $history,
            'transitions' => $transitions,
            'parameters' => $parameters,
            'constraints' => $constraints,
        ));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */