<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud extends MY_Controller
{
    public $model;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->layout->view('index');
    }

    public function modal_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

        if ($this->_is_ajax_request() && isset($_REQUEST[$model->table]))
        {
            $model->attributes = isset($model->attributes) ? array_merge($model->attributes, $_REQUEST[$model->table]) : $_REQUEST[$model->table];
            $model->save();
            exit();
        }

        // edit request 
        $keys = $model->primary_keys;
        if (array_intersect(array_keys($_REQUEST), $keys) === $keys)
        {
            $model->attributes = $this->_form_data($model);
            $model->is_new_record = false;
        }

        $form = new MY_Form($model);
        $form->view = 'crud/modal_form';
        $form->action = 'crud/modal_form/' . get_class($model);
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

    public function view_modal_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

        // edit request 
        $keys = $model->primary_keys;
        if (array_intersect(array_keys($_REQUEST), $keys) === $keys)
        {
            $model->attributes = $this->_form_data($model);
        }

        $form = new MY_Form($model);
        $form->view = 'crud/modal_form';
        $form->action = 'crud/modal_form/' . get_class($model);

        // load partial view
        $el_fields = $this->load->view('crud/_el_fields', array('form' => $form,), true);

        // load view
        $this->load->view($form->view, array(
            'form' => $form,
            'el_fields' => $el_fields,
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
            $model->is_new_record = false;
        }


//        $name = strtolower($model->table);
//        $id = 'form_' . strtolower($model->table);

        $form = new MY_Form($model);

        // load partial view
        $el_buttons = $this->load->view('crud/_el_buttons', array('form' => $form,), true);
        $el_fields = $this->load->view('crud/_el_fields', array('form' => $form,), true);

        if ($this->_is_ajax_request())
        {
            // load view
            $this->load->view($form->view, array(
                'form' => $form,
                'el_buttons' => $el_buttons,
                'el_fields' => $el_fields,
            ));
        }
        else
        {
            // load layout view
            $this->layout->view($form->view, array(
                'form' => $form,
                'el_buttons' => $el_buttons,
                'el_fields' => $el_fields,
            ));
        }
    }

    public function view_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);

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

        // load partial view
        $el_fields = $this->load->view('crud/_el_fields', array('form' => $form,'read_only' => true,), true);

        if ($this->_is_ajax_request())
        {
            // load view
            $this->load->view($form->view, array(
                'form' => $form,
                'el_fields' => $el_fields,
            ));
        }
        else
        {
            // load layout view
            $this->layout->view($form->view, array(
                'form' => $form,
                'el_fields' => $el_fields,
            ));
        }
    }

    public function grid($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);
        $query = $this->_grid_data($model);
        if ($this->_is_ajax_request())
        {
            if (isset($_REQUEST['oper']))
            {
                echo json_encode($query);

                exit();
            }
            else
            {

                $this->load->view($model->grid_view, array(
                    'grid' => new MY_Grid($model),
                ));
            }
        }
        else
        {
            $this->layout->view($model->grid_view, array(
                'grid' => new MY_Grid($model),
            ));
        }
    }
    
    public function view_grid($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);
        $query = $this->_grid_data($model);
        if ($this->_is_ajax_request())
        {
            if (isset($_REQUEST['oper']))
            {
                echo json_encode($query);

                exit();
            }
            else
            {

                $this->load->view($model->grid_view, array(
                    'grid' => new MY_Grid($model),
                    'read_only' => true,
                ));
            }
        }
        else
        {
            $this->layout->view($model->grid_view, array(
                'grid' => new MY_Grid($model),
                'read_only' => true,
            ));
        }
    }

    public function grid_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);
        $model->grid_view = 'Crud/grid_form';
        $query = $this->_grid_data($model);
        if ($this->_is_ajax_request())
        {
            if (isset($_REQUEST['oper']))
            {
                echo json_encode($query);
                exit();
            }
            else
            {
                $this->load->view($model->grid_view, array(
                    'grid' => new MY_Grid($model),
                ));
            }
        }
        else
        {
            $this->layout->view($model->grid_view, array(
                'grid' => new MY_Grid($model),
            ));
        }
    }

    public function view_grid_form($model = null)
    {
        // check and load model
        $model = $this->_load_model($model);
        $model->grid_view = 'Crud/grid_form';
        $query = $this->_grid_data($model);
        if ($this->_is_ajax_request())
        {
            if (isset($_REQUEST['oper']))
            {
                echo json_encode($query);

                exit();
            }
            else
            {
                $this->load->view($model->grid_view, array(
                    'grid' => new MY_Grid($model),
                    'read_only' => true,
                ));
            }
        }
        else
        {
            $this->layout->view($model->grid_view, array(
                'grid' => new MY_Grid($model),
                'read_only' => true,
            ));
        }
    }

}
/* End of file welcome.php
/* Location: ./application/controllers/welcome.php */