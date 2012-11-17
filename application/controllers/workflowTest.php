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
        
        $this->load->library('workflowGraphViz');
        
        $node = array(
            array('from'=>'Start','to'=>'Persetujuan Registrasi'),
            array('from'=>'Persetujuan Registrasi','to'=>'Approve'),
            array('from'=>'Persetujuan Registrasi','to'=>'Reject'),
            array('from'=>'Persetujuan Registrasi','to'=>'Perbaikan data'),
        );
        
        $sql = "select b.nama_aktifitas as \"from\", c.nama_aktifitas as \"to\" 
				from ep_wkf_transisi a
                inner join ep_wkf_aktifitas b on a.aktifitas_asal = b.kode_aktifitas
                inner join ep_wkf_aktifitas c on a.aktifitas_tujuan = c.kode_aktifitas
                where kode_wkf='".$_REQUEST['kode_wkf']."'";
        
        $query = $this->db->query($sql);
        $node = $query->result_array();
        
//        digraph G { 
//    Start    [shape=doublecircle];
//    Finish    [shape=doublecircle,style=filled];
//    node    [shape=circle];
//    "Start" -> "Persetujuan Registrasi";
//    "Persetujuan Registrasi" -> "Approve";
//    "Persetujuan Registrasi" -> "Reject";
//    "Persetujuan Registrasi" -> "Kembalikan ke vendor";
//    "Kembalikan ke vendor" -> "Perbaikan Data";
//    "Perbaikan Data" -> "Persetujuan Registrasi";
//    "Approve" -> "Finish";
//    "Reject" -> "Finish";
//}

                
        $config = array(
            'Start'=>array('shape'=>'doublecircle'),
            'Finish'=>array('shape'=>'doublecircle', 'style'=>'filled'),
            'node'=>array('shape'=>'circle'),
            );
        
        $data = array('node' => $node, 'config' => $config);
        $this->workflowgraphviz->image($data);
    }

    public function view() {
        $this->load->library('workflow');

        $rows = $this->workflow->getHistory($_REQUEST['kode_proses']);
        $this->layout->view('workflow_view', array(
            'rows' => $rows,
        ));
    }

    public function start() {
        $this->load->library('workflow');
        $kode_wkf = isset($_REQUEST['kode_wkf']) ? $_REQUEST['kode_wkf'] : 1;
    }
    
    public function run() {
        $this->load->library('workflow');

        $kode_proses = isset($_REQUEST['kode_proses']) ? $_REQUEST['kode_proses'] : null;
        if (!isset($kode_proses)) {
            $wkf_id = isset($_REQUEST['kode_wkf']) ? $_REQUEST['kode_wkf'] : 1;
            $this->workflow->start($wkf_id);
            redirect('/workflowTest/index');
        }

        if ($_POST) {
            $kode_transisi = $_REQUEST['kode_transisi'];
            $catatan = isset($_REQUEST['catatan']) ? $_REQUEST['catatan'] : null;
            $user = isset($_REQUEST['user']) ? $_REQUEST['user'] : null;
            $this->workflow->executeNode($kode_proses, $kode_transisi, $catatan, $user);

            redirect('/workflowTest/index');
        }

        // load workflow instance
        $instance = $this->workflow->getInstance($kode_proses);
        // load workflow instance
        $history = $this->workflow->getHistory($kode_proses);
        // load workflow variable
        $variables = $this->workflow->getParamfromDB($kode_proses);
        
        // get available transition
        $transitions = $this->workflow->getTransition($instance['KODE_AKTIFITAS']);

        // get available constraints & replace @@parameter for execution
        $constraints = $this->workflow->getConstraintForExecution($kode_proses, $instance['KODE_AKTIFITAS'], 'onload', $variables);
        
        // build parameters if exists
        $parameters = array();
        foreach ($transitions as $v) {
            $node = $this->workflow->getNodeById($v['AKTIFITAS_ASAL']);
            $parameters = $parameters + (array) json_decode($node['PARAMETER'], true);
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