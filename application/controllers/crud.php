<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud extends CI_Controller {

    public $model;

    public function __construct() {
        //print_r($_REQUEST);
        //$this->model = '(select * from EP_NOMORURUT)';
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

    public function modal_form($model = null) {
        // check and load model
        $model = $this->_load_model($model);
        
        // form submited do insert / update
        
        if ($this->_is_ajax_request() && isset($_REQUEST['jqform']) && $_REQUEST['jqform'] == 'save') {
            $attributes = $_REQUEST[$model->table];
            print_r($model->save($attributes));
            exit();
        }
        
        // edit request 
        $keys = $model->primary_keys;
        if(array_intersect(array_keys($_REQUEST), $keys) === $keys) { // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key) $where[$key] = $_REQUEST[$key];
            
            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            $model->attributes = $query; // set model attributes
        }
        
        $name = strtolower($model->table);
        $id = 'form_' . strtolower($model->table);
        
        $this->load->view('Crud/modal_form', array(
            'name' => $name,
            'id' => $id,
            'model' => $model,
        ));
    }
    
    public function form($model = null) {
        // check and load model
        $model = $this->_load_model($model);
        
        // form submited do insert / update
        if ($this->_is_ajax_request()) {
            $attributes = $_REQUEST[$model->table];
            print_r($model->save($attributes));
            exit();
        }

        // edit request 
        
        $keys = $model->primary_keys;
        if(count($_REQUEST) > 0 && array_intersect(array_keys($_REQUEST), $keys) === $keys) { // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key) $where[$key] = $_REQUEST[$key];
            
            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            $model->attributes = $query; // set model attributes
        }
        $name = strtolower($model->table);
        $id = 'form_' . strtolower($model->table);
        
        $this->layout->view('Crud/form', array(
            'name' => $name,
            'id' => $id,
            'model' => $model,
        ));
    }

    public function grid($model = null) {
        // check and load model
        $model = $this->_load_model($model);

        $gopts = array(
            'page'=>(isset($_REQUEST['page']) ? $_REQUEST['page'] : 1),
            'rows'=>(isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15),
        );
        
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
        $filter = null;
        if (isset($_REQUEST['filters'])) {
            //$this->load->library('jqGrid', null, 'jq');
            $filter = $model->buildSearch($_REQUEST['filters']);
        }

        $filter = strlen($filter) > 0 ? $filter : null;
        //$query = $this->db->get('USERS', 10, $page);


        $this->db->start_cache();
        $this->db->from($model->sql_select);
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

        if ($this->_is_ajax_request()) {
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

        /*
        preg_match("/select/", $model->sql_select, $matches);
        if (count($matches) > 0) {
            $this->model = false;
            $read_only = true;
        }
        */
        $this->layout->view('Crud/grid', array(
            'query' => $query,
            'rows' => $rows,
            'page' => $page,
            'read_only' => $read_only,
            'model' => $model,
        ));
        //$this->load->view('Crud/grid', array('query' => $query, 'rows'=>$rows, 'page'=>$page));
    }

    public function create() {
        
    }

    public function update() {
        
    }

    public function delete() {
        
    }

    private function _load_model($model, $return = true) {
        
        if (file_exists(APPPATH . 'models/' . strtolower($model) . '.php')) {
            $this->load->model(strtolower($model), 'crud_model', true);
        } else {
            $this->load->model('model', 'crud_model', true, $model);
        }
        
        $model = $this->crud_model;
        unset($this->crud_model);
        
        if($return)
            return $model;                
        else
            $this->model = $model;        
    }
    
    private function _is_ajax_request() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */