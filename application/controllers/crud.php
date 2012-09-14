<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud extends CI_Controller {

    public $model;

    public function __construct() {
        //print_r($_REQUEST);
        $this->model = '(select * from EP_NOMORURUT)';
        parent::__construct();

        //$this->load->model('model', 'crud_model', true, $this->model);
        //$this->x->table = $this->model;
        //$this->x->init();
    }

    /**
     * Index Page for this controller.
     */
    public function index() {
        $this->layout->view('index');
        //$this->load->view('welcome_message');
    }

    public function form($model = null, $id = null) {
        
        $this->model = isset($model) ? $model : $this->model;
        $this->load->model('model', 'crud_model', true, $this->model);
        
        $name = 'newForm';
        $id = 'newForm';
        
        if ($this->is_ajax_request()) {
            echo "sss";
            exit();
        }
        
        $this->layout->view('Crud/form', array(
            'name' => $name,
            'id' => $id,
            'model' => $this->crud_model,
        ));
    }

    public function grid($model = null) {
        $this->model = isset($model) ? $model : $this->model;

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
        $filter = null;
        if (isset($_REQUEST['filters'])) {
            $this->load->library('jqGrid', null, 'jq');
            $filter = $this->jq->buildSearch($_REQUEST['filters']);
        }

        $filter = strlen($filter) > 0 ? $filter : null;
        //$query = $this->db->get('USERS', 10, $page);


        $this->db->start_cache();
        $this->db->from($this->model);
        if ($filter !== null)
            $this->db->where($filter);
        $this->db->stop_cache();

        $count = $this->db->count_all_results();
        $count > 0 ? $total_pages = ceil($count / $rows) : $total_pages = 0;
        if ($page > $total_pages)
            $page = $total_pages;

        // build data
        $this->db->limit($rows, $page);
        $query = $this->db->get();

        $this->db->flush_cache();

        if ($this->is_ajax_request()) {
            echo json_encode(array(
                "records" => $count,
                "page" => $page,
                "total" => $total_pages,
                "rows" => $query->result_array));
            exit();
        }


        // load layout
        //$this->load->library('My_DBTableModel', $params, 'model');

        $read_only = false;

        preg_match("/select/", $this->model, $matches);
        if (count($matches) > 0) {
            $this->model = false;
            $read_only = true;
        }
        $this->layout->view('Crud/grid', array(
            'query' => $query,
            'rows' => $rows,
            'page' => $page,
            'read_only' => $read_only,
            'model' => $this->model,
        ));
        //$this->load->view('Crud/grid', array('query' => $query, 'rows'=>$rows, 'page'=>$page));
    }

    public function create() {
        
    }

    public function update() {
        
    }

    public function delete() {
        
    }

    private function is_ajax_request() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */