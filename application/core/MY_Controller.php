<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

    public function __construct() {
        parent::__construct();
        // check login session
        $user_id = $this->session->userdata('user_id');
        if (!$user_id)
            redirect('account/login');

        //$this->output->enable_profiler(TRUE);
        // cek kelengkapan data & status registrasi vendor
        $query = $this->db->query("select KODE_STATUS_REG from EP_VENDOR where KODE_VENDOR = $user_id");
        $row = $query->row_array();
        // exclude crud controller from restricted access
//        $allow = $this->uri->segment(1) == 'vendor' ? true : false;
//        if(!$row['KODE_STATUS_REG'] && !$allow)
//            redirect('account/complete_registration');

//        list($path, $_model) = Modules::find(strtolower('ep_vendor'), 'vendor', 'models/');
//        class_exists('CI_Model', FALSE) OR load_class('Model', 'core');
//
//        Modules::load_file($_model, $path);
//
//        $model = ucfirst($_model);
//        $model = new $model();
//        
//        print_r($model);
    }

    public function _load_model($model, $type = 'grid', $return = true) {

        $model = str_replace(".", "/", strtolower($model));
        $this->load->model($model, 'crud_model', true);
        /*
          $path = APPPATH . 'modules/' . $model . '/models/' . str_replace(".", "/", strtolower($model)) . '.php';

          if (file_exists($path))
          {
          $this->load->model($model, 'crud_model', true);
          }
          else
          {
          $this->load->model('Model', 'crud_model', true, $model);
          }
         */
        $model = $this->crud_model;
        unset($this->crud_model);

        if ($return)
            return $model;
        else
            $this->model = $model;
    }

    public function _is_ajax_request() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

    public function _grid_data($model) {
        $return = null;
        try {
            $gopts = array(
                'page' => (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1),
                'rows' => (isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15),
            );

            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
            $filter = null;
            if (isset($_REQUEST['filters'])) {
                //$this->load->library('jqGrid', null, 'jq');
                $filter = $model->buildSearch($_REQUEST['filters']);
            }

            $filter = strlen($filter) > 0 ? $filter : null;

            if ($filter)
                $filter = strlen($model->_default_scope()) > 0 ? $filter . ' AND ' . $model->_default_scope() : $filter;
            else
                $filter = strlen($model->_default_scope()) > 0 ? $model->_default_scope() : $filter;
            //$query = $this->db->get('USERS', 10, $page);



            $src = $model->table;
            preg_match("/select/", $model->sql_select, $matches);
            if (count($matches) > 0) {
                $src = $model->sql_select;
                $read_only = true;
            }

            $this->db->start_cache();
            $this->db->from($src, true);
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
            $return = array(
                "records" => $count,
                "page" => $page,
                "total" => $total_pages,
                "rows" => $query->result_array,
            );

            $this->db->flush_cache();
        } catch (exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        return $return;
    }

    public function _form_data($model) {

        $query = null;
        try {
            $keys = $model->primary_keys;
            // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key)
                $where[$key] = $_REQUEST[$key];


            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            //$model->attributes = $query; // set model attributes
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        return $query;
    }

    public $model;

    public function modal_form($model = null) {
        // check and load model
        $model = $this->_load_model($model);

        if ($this->_is_ajax_request() && isset($_REQUEST[$model->table])) {
            $model->attributes = isset($model->attributes) ? array_merge($model->attributes, $_REQUEST[$model->table]) : $_REQUEST[$model->table];
            $model->save();
            exit();
        }

        // edit request 
        $keys = $model->primary_keys;
        if (count(array_intersect(array_keys($_REQUEST), $keys)) === count($keys)) {
            $model->attributes = $this->_form_data($model);
            $model->is_new_record = false;
        }

        $form = new MY_Form($model);
        $form->view = 'crud/modal_form';
        $form->action = $form->module . '/modal_form/' . (isset($model->dir) ? strtolower($model->dir . '.' . get_class($model)) : get_class($model));
        $form->clear_form = true;
        // load partial view
        $el_buttons = $this->load->view('crud/_el_buttons', array('form' => $form,), true);
        $el_fields = $this->load->view('crud/_el_fields', array('form' => $form,), true);

        // load view
        $this->load->view($form->view, array(
            'form' => $form,
            'el_buttons' => $el_buttons,
            'el_fields' => $el_fields,
        ));
    }

    public function view_modal_form($model = null) {
        // check and load model
        $model = $this->_load_model($model);

        // edit request 
        $keys = $model->primary_keys;
        if (count(array_intersect(array_keys($_REQUEST), $keys)) === count($keys)) {
            $model->attributes = $this->_form_data($model);
        }

        $form = new MY_Form($model);
        $form->view = 'crud/modal_form';
        $form->action = $form->module . '/modal_form/' . (isset($model->dir) ? strtolower($model->dir . '.' . get_class($model)) : get_class($model));

        // load partial view
        $el_fields = $this->load->view('crud/_el_fields', array('form' => $form,), true);

        // load view
        $this->load->view($form->view, array(
            'form' => $form,
            'el_fields' => $el_fields,
        ));
    }

    public function form($model = null) {
        // check and load model
        $model = $this->_load_model($model);

//        $this->load->library('MY_Form', array('model' => $model), 'form');
//        $form = $this->form;
        // form submited do insert / update
        if ($this->_is_ajax_request() && isset($_REQUEST[$model->table])) {
            $model->attributes = isset($model->attributes) ? array_merge($model->attributes, $_REQUEST[$model->table]) : $_REQUEST[$model->table];
            $model->save();
            exit();
        }

        // edit request 
        $keys = $model->primary_keys;
        if (
                (count($_REQUEST) > 0 && count(array_intersect(array_keys($_REQUEST), $keys)) === count($keys)) // get PKey from $_REQUEST
                ||
                (count($model->attributes) > 0 && count(array_intersect(array_keys($model->attributes), $keys)) === count($keys)) // get PKey from model
        ) { // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key)
                $where[$key] = isset($model->attributes[$key]) ? $model->attributes[$key] : $_REQUEST[$key];

            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            $model->attributes = $query; // set model attributes
            $model->is_new_record = false;
        }


//        $name = strtolower($model->table);
//        $id = 'form_' . strtolower($model->table);

        $form = new MY_Form($model);

        // load partial view
        $el_buttons = $this->load->view('crud/_el_buttons', array('form' => $form,), true);
        $el_fields = $this->load->view('crud/_el_fields', array('form' => $form,), true);

        if ($this->_is_ajax_request()) {
            // load view
            $this->load->view($form->view, array(
                'form' => $form,
                'el_buttons' => $el_buttons,
                'el_fields' => $el_fields,
            ));
        } else {
            // load layout view
            $this->layout->view($form->view, array(
                'form' => $form,
                'el_buttons' => $el_buttons,
                'el_fields' => $el_fields,
            ));
        }
    }

    public function view_form($model = null) {
        // check and load model
        $model = $this->_load_model($model);

        // edit request 
        $keys = $model->primary_keys;
        if (
                (count($_REQUEST) > 0 && count(array_intersect(array_keys($_REQUEST), $keys)) === count($keys)) // get PKey from $_REQUEST
                ||
                (count($model->attributes) > 0 && count(array_intersect(array_keys($model->attributes), $keys)) === count($keys)) // get PKey from model
        ) { // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key)
                $where[$key] = isset($model->attributes[$key]) ? $model->attributes[$key] : $_REQUEST[$key];

            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            $model->attributes = $query; // set model attributes
        }

        $form = new MY_Form($model);

        // load partial view
        $el_fields = $this->load->view('crud/_el_fields', array('form' => $form, 'read_only' => true,), true);

        if ($this->_is_ajax_request()) {
            // load view
            $this->load->view($form->view, array(
                'form' => $form,
                'el_fields' => $el_fields,
            ));
        } else {
            // load layout view
            $this->layout->view($form->view, array(
                'form' => $form,
                'el_fields' => $el_fields,
            ));
        }
    }

    public function grid($model = null) {
        // check and load model
        $model = $this->_load_model($model);
        $query = $this->_grid_data($model);
        if ($this->_is_ajax_request()) {
            if (isset($_REQUEST['oper'])) {
                echo json_encode($query);

                exit();
            } else {

                $this->load->view($model->grid_view, array(
                    'grid' => new MY_Grid($model),
                ));
            }
        } else {
            $this->layout->view($model->grid_view, array(
                'grid' => new MY_Grid($model),
            ));
        }
    }

    public function view_grid($model = null) {
        // check and load model
        $model = $this->_load_model($model);
        $query = $this->_grid_data($model);
        if ($this->_is_ajax_request()) {
            if (isset($_REQUEST['oper'])) {
                echo json_encode($query);

                exit();
            } else {

                $this->load->view($model->grid_view, array(
                    'grid' => new MY_Grid($model),
                    'read_only' => true,
                ));
            }
        } else {
            $this->layout->view($model->grid_view, array(
                'grid' => new MY_Grid($model),
                'read_only' => true,
            ));
        }
    }

    public function grid_form($model = null) {
        // check and load model
        $model = $this->_load_model($model);
        $model->grid_view = 'Crud/grid_form';
        $query = $this->_grid_data($model);
        if ($this->_is_ajax_request()) {
            if (isset($_REQUEST['oper'])) {
                echo json_encode($query);
                exit();
            } else {
                $this->load->view($model->grid_view, array(
                    'grid' => new MY_Grid($model),
                ));
            }
        } else {
            $this->layout->view($model->grid_view, array(
                'grid' => new MY_Grid($model),
            ));
        }
    }

    public function view_grid_form($model = null) {
        // check and load model
        $model = $this->_load_model($model);
        $model->grid_view = 'Crud/grid_form';
        $query = $this->_grid_data($model);
        if ($this->_is_ajax_request()) {
            if (isset($_REQUEST['oper'])) {
                echo json_encode($query);

                exit();
            } else {
                $this->load->view($model->grid_view, array(
                    'grid' => new MY_Grid($model),
                    'read_only' => true,
                ));
            }
        } else {
            $this->layout->view($model->grid_view, array(
                'grid' => new MY_Grid($model),
                'read_only' => true,
            ));
        }
    }

}

?>