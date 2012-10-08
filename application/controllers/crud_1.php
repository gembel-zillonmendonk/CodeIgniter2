<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud extends CI_Controller
{
    public $model;

    public function __construct()
    {
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
    public function index()
    {
        $this->layout->view('index');
        //$this->load->view('welcome_message');
    }

    public function modal_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

        // form submited do insert / update
//        echo "<pre>";
//        print_r($_SERVER);
//        print_r($_REQUEST[$model->table]);
//        die();
        if ($this->_is_ajax_request() && isset($_REQUEST[$model->table]))
        {
            $model->attributes = array_merge($model->attributes, $_REQUEST[$model->table]);
            $model->save();
            exit();
        }

        // edit request 
        $keys = $model->primary_keys;

        if (array_intersect(array_keys($_REQUEST), $keys) === $keys)
        {
            // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key)
                $where[$key] = $_REQUEST[$key];


            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            $model->attributes = $query; // set model attributes
        }



//        $name = strtolower($model->table);
//        $id = 'form_' . strtolower($model->table);
//
//        $this->load->view('Crud/modal_form', array(
//            'name' => $name,
//            'id' => $id,
//            'model' => $model,
//        ));


        $form = new MY_Form($model);
        $form->view = 'crud/modal_form';
        $form->action = 'crud/modal_form/' . get_class($model);
        $this->load->view($form->view, array(
//            'name' => $name,
//            'id' => $id,
//            'model' => $model,
            'form' => $form,
        ));
    }
    
    public function view_modal_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

        // form submited do insert / update
        if ($this->_is_ajax_request() && isset($_REQUEST[$model->table]))
        {
            $model->attributes = array_merge($model->attributes, $_REQUEST[$model->table]);
            $model->save();
            exit();
        }

        // edit request 
        $keys = $model->primary_keys;

        if (array_intersect(array_keys($_REQUEST), $keys) === $keys)
        {
            // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key)
                $where[$key] = $_REQUEST[$key];


            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            $model->attributes = $query; // set model attributes
        }

        $form = new MY_Form($model);
        $form->view = 'crud/modal_form';
        $form->action = 'crud/modal_form/' . get_class($model);
        $this->load->view($form->view, array(
            'form' => $form,
            'read_only' => true,
        ));
    }

    public function form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

//        $this->load->library('MY_Form', array('model' => $model), 'form');
//        $form = $this->form;
        // form submited do insert / update
        if ($this->_is_ajax_request() && isset($_REQUEST[$model->table]))
        {
            $model->attributes = array_merge($model->attributes, $_REQUEST[$model->table]);
            $model->save();
            exit();
        }

        // edit request 
        $keys = $model->primary_keys;
        if (
                (count($_REQUEST) > 0 && array_intersect(array_keys($_REQUEST), $keys) === $keys) // get PKey from $_REQUEST
                ||
                (count($model->attributes) > 0 && array_intersect(array_keys($model->attributes), $keys) === $keys) // get PKey from model
        )
        { // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key)
                $where[$key] = isset($model->attributes[$key]) ? $model->attributes[$key] : $_REQUEST[$key];

            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            $model->attributes = $query; // set model attributes
        }


//        $name = strtolower($model->table);
//        $id = 'form_' . strtolower($model->table);

        $form = new MY_Form($model);
        if ($this->_is_ajax_request())
        {
            $this->load->view($form->view, array(
//            'name' => $name,
//            'id' => $id,
//            'model' => $model,
                'form' => $form,
            ));
        }
        else
        {

            $this->layout->view($form->view, array(
//            'name' => $name,
//            'id' => $id,
//            'model' => $model,
                'form' => $form,
            ));
        }
    }

    public function view_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

        // form submited do insert / update
        if ($this->_is_ajax_request() && isset($_REQUEST[$model->table]))
        {
            $model->attributes = array_merge($model->attributes, $_REQUEST[$model->table]);
            $model->save();
            exit();
        }

        // edit request 
        $keys = $model->primary_keys;
        if (
                (count($_REQUEST) > 0 && array_intersect(array_keys($_REQUEST), $keys) === $keys) // get PKey from $_REQUEST
                ||
                (count($model->attributes) > 0 && array_intersect(array_keys($model->attributes), $keys) === $keys) // get PKey from model
        )
        { // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key)
                $where[$key] = isset($model->attributes[$key]) ? $model->attributes[$key] : $_REQUEST[$key];

            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            $model->attributes = $query; // set model attributes
        }

        $form = new MY_Form($model);
        if ($this->_is_ajax_request())
        {
            $this->load->view($form->view, array(
                'form' => $form,
                'read_only' => true,
            ));
        }
        else
        {

            $this->layout->view($form->view, array(
                'form' => $form,
                'read_only' => true,
            ));
        }
    }
    
    public function grid($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

        $gopts = array(
            'page' => (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1),
            'rows' => (isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15),
        );

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
        $filter = null;
        if (isset($_REQUEST['filters']))
        {
            //$this->load->library('jqGrid', null, 'jq');
            $filter = $model->buildSearch($_REQUEST['filters']);
        }

        $filter = strlen($filter) > 0 ? $filter : null;
        //$query = $this->db->get('USERS', 10, $page);



        $src = $model->table;
        preg_match("/select/", $model->sql_select, $matches);
        if (count($matches) > 0)
        {
            $src = $model->sql_select;
            $read_only = true;
        }

        $this->db->start_cache();
        $this->db->from($src);
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

        $grid = new MY_Grid($model);
        if ($this->_is_ajax_request())
        {
            if (isset($_REQUEST['oper']))
            {
                echo json_encode(array(
                    "records" => $count,
                    "page" => $page,
                    "total" => $total_pages,
                    "rows" => $query->result_array));

                exit();
            }
            else
            {

                $this->load->view('Crud/grid', array(
//                    'query' => $query,
//                    'rows' => $rows,
//                    'page' => $page,
//                    'read_only' => $read_only,
                    //'model' => $model,
                    'grid' => $grid,
                ));
            }
        }
        else
        {
            $this->layout->view('Crud/grid', array(
//            'query' => $query,
//            'rows' => $rows,
//            'page' => $page,
//            'read_only' => $read_only,
                //'model' => $model,
                'grid' => $grid,
            ));
        }

        /*
          preg_match("/select/", $model->sql_select, $matches);
          if (count($matches) > 0) {
          $this->model = false;
          $read_only = true;
          }
         */

        //$this->load->view('Crud/grid', array('query' => $query, 'rows'=>$rows, 'page'=>$page));
    }

    public function grid_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

        $gopts = array(
            'page' => (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1),
            'rows' => (isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15),
        );

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
        $filter = null;
        if (isset($_REQUEST['filters']))
        {
            //$this->load->library('jqGrid', null, 'jq');
            $filter = $model->buildSearch($_REQUEST['filters']);
        }

        $filter = strlen($filter) > 0 ? $filter : null;
        //$query = $this->db->get('USERS', 10, $page);



        $src = $model->table;
        preg_match("/select/", $model->sql_select, $matches);
        if (count($matches) > 0)
        {
            $src = $model->sql_select;
            $read_only = true;
        }

        $this->db->start_cache();
        $this->db->from($src);
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

        $grid = new MY_Grid($model);
        if ($this->_is_ajax_request())
        {
            if (isset($_REQUEST['oper']))
            {
                echo json_encode(array(
                    "records" => $count,
                    "page" => $page,
                    "total" => $total_pages,
                    "rows" => $query->result_array));

                exit();
            }
            else
            {

                $this->load->view('Crud/grid_form', array(
//                    'query' => $query,
//                    'rows' => $rows,
//                    'page' => $page,
//                    'read_only' => $read_only,
                    //'model' => $model,
                    'grid' => $grid,
                ));
            }
        }
        else
        {
            $this->layout->view('Crud/grid_form', array(
//            'query' => $query,
//            'rows' => $rows,
//            'page' => $page,
//            'read_only' => $read_only,
                //'model' => $model,
                'grid' => $grid,
            ));
        }

        /*
          preg_match("/select/", $model->sql_select, $matches);
          if (count($matches) > 0) {
          $this->model = false;
          $read_only = true;
          }
         */

        //$this->load->view('Crud/grid', array('query' => $query, 'rows'=>$rows, 'page'=>$page));
    }

    public function view_grid_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);
        $query = $this->_grid_data($model);
        $grid = new MY_Grid($model);
        if ($this->_is_ajax_request())
        {
            if (isset($_REQUEST['oper']))
            {
                echo json_encode(array(
                    "records" => $count,
                    "page" => $page,
                    "total" => $total_pages,
                    "rows" => $query->result_array));

                exit();
            }
            else
            {
                $this->load->view('Crud/grid_form', array(
                    'grid' => $grid,
                    'read_only' => true,
                ));
            }
        }
        else
        {
            $this->layout->view('Crud/grid_form', array(
                'grid' => $grid,
                'read_only' => true,
            ));
        }
    }

    private function _load_model($model, $type = 'grid', $return = true)
    {

        if (file_exists(APPPATH . 'models/' . strtolower($model) . '.php'))
        {
            $this->load->model(strtolower($model), 'crud_model', true);
        }
        else
        {
            /*
              if($type == 'grid')
              {
              $this->load->model('My_Grid', 'crud_model', true, $model);
              }
              else
              {
              $this->load->model('My_Form', 'crud_model', true, $model);
              }
             */
            $this->load->model('Model', 'crud_model', true, $model);
        }

        /*
          if($type == 'grid' && !($this->crud_model instanceof My_Grid))
          show_error ("load wrong model class for action");

          if($type == 'form' && !($this->crud_model instanceof My_Form))
          show_error ("load wrong model class for action");
         */
        $model = $this->crud_model;
        unset($this->crud_model);

        if ($return)
            return $model;
        else
            $this->model = $model;
    }

    private function _is_ajax_request()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

    private function _grid_data($model)
    {
        $query = null;
        try
        {
            $gopts = array(
                'page' => (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1),
                'rows' => (isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15),
            );

            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
            $filter = null;
            if (isset($_REQUEST['filters']))
            {
                //$this->load->library('jqGrid', null, 'jq');
                $filter = $model->buildSearch($_REQUEST['filters']);
            }

            $filter = strlen($filter) > 0 ? $filter : null;
            //$query = $this->db->get('USERS', 10, $page);



            $src = $model->table;
            preg_match("/select/", $model->sql_select, $matches);
            if (count($matches) > 0)
            {
                $src = $model->sql_select;
                $read_only = true;
            }

            $this->db->start_cache();
            $this->db->from($src);
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
        }
        catch (exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
        
        return $query;
    }

}
/* End of file welcome.php
/* Location: ./application/controllers/welcome.php */