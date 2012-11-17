<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wkf extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->library('workflow');

        $active = $this->workflow->getActiveInstances();
        $finish = $this->workflow->getEndInstances();
        $this->layout->view('list', array(
            'active' => $active,
            'finish' => $finish,
        ));
    }

    public function start() {
        $this->load->library('workflow');
        $kode_wkf = isset($_REQUEST['kode_wkf']) ? $_REQUEST['kode_wkf'] : 1;
        $kode_transisi = isset($_REQUEST['kode_transisi']) ? $_REQUEST['kode_transisi'] : false;
        $catatan = isset($_REQUEST['catatan']) ? $_REQUEST['catatan'] : false;

        if ($_POST) {

            $kode_proses = $this->workflow->start($kode_wkf, $kode_transisi, $catatan);

            $referer_url = isset($_REQUEST['referer_url']) ? $_REQUEST['referer_url'] : $_SERVER['HTTP_REFERER'];

            redirect($referer_url);
        }

        // get start node
        $query = $this->db->query("select kode_wkf, kode_aktifitas, kode_posisi, kode_user, kode_aplikasi, parameter, tipe from EP_WKF_AKTIFITAS where kode_wkf = $kode_wkf and is_mulai = 1");
        $node = $query->row_array();

        // get available transition
        $transitions = $this->workflow->getTransition($node['KODE_AKTIFITAS']);

        // build parameters if exists
        $parameters = array();
        foreach ($transitions as $v) {
            $node = $this->workflow->getNodeById($v['AKTIFITAS_ASAL']);
            $parameters = $parameters + (array) json_decode($node['PARAMETER'], true);
        }

        $this->layout->view('start', array(
            'kode_wkf' => $kode_wkf,
            'transitions' => $transitions,
            'parameters' => $parameters,
        ));
    }

    public function run() {
        $this->load->library('workflow');

        $kode_proses = isset($_REQUEST['kode_proses']) ? $_REQUEST['kode_proses'] : null;
        if (!isset($kode_proses)) {
            $wkf_id = isset($_REQUEST['kode_wkf']) ? $_REQUEST['kode_wkf'] : 1;
            $kode_proses = $this->workflow->start($wkf_id);
            //redirect('/wkf/index');
        }

        if ($_POST) {
            $kode_transisi = $_REQUEST['kode_transisi'];
            $catatan = isset($_REQUEST['catatan']) ? $_REQUEST['catatan'] : null;
            $user = isset($_REQUEST['user']) ? $_REQUEST['user'] : ($this->session->userdata("user_id"));
            $this->workflow->executeNode($kode_proses, $kode_transisi, $catatan, $user);

            $referer_url = isset($_REQUEST['referer_url']) ? $_REQUEST['referer_url'] : $_SERVER['HTTP_REFERER'];
            
            redirect($referer_url);
            //redirect('/wkf/index');
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

        $this->layout->view('run', array(
            'instance' => $instance,
            'history' => $history,
            'transitions' => $transitions,
            'parameters' => $parameters,
            'constraints' => $constraints,
        ));
    }

    public function graph() {

        $this->load->library('workflowGraphViz');

        $node = array(
            array('from' => 'Start', 'to' => 'Persetujuan Registrasi'),
            array('from' => 'Persetujuan Registrasi', 'to' => 'Approve'),
            array('from' => 'Persetujuan Registrasi', 'to' => 'Reject'),
            array('from' => 'Persetujuan Registrasi', 'to' => 'Perbaikan data'),
        );

        $sql = "select b.nama_aktifitas as \"from\", c.nama_aktifitas as \"to\", c.tipe as \"tipe\" 
				from ep_wkf_transisi a
                inner join ep_wkf_aktifitas b on a.aktifitas_asal = b.kode_aktifitas
                inner join ep_wkf_aktifitas c on a.aktifitas_tujuan = c.kode_aktifitas
                where kode_wkf='" . $_REQUEST['kode_wkf'] . "'";

        $query = $this->db->query($sql);
        $node = $query->result_array();

        $config = array(
            'Start' => array('shape' => 'doublecircle'),
            'Finish' => array('shape' => 'doublecircle', 'style' => 'filled'),
            'node' => array('shape' => 'circle'),
        );

        $data = array('node' => $node, 'config' => $config);
        $this->workflowgraphviz->image($data);
    }

    public function _is_ajax_request() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */