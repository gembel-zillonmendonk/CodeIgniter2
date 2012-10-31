<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package        CodeIgniter
 * @author        Dariusz Debowczyk
 * @copyright    Copyright (c) 2006, D.Debowczyk
 * @license        http://www.codeignitor.com/user_guide/license.html 
 * @link        http://www.codeigniter.com
 * @since        Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Session class using native PHP session features and hardened against session fixation.
 * 
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Sessions
 * @author        Dariusz Debowczyk
 * @link        http://www.codeigniter.com/user_guide/libraries/sessions.html
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // check login session
        $user_id = $this->session->userdata('user_id');
        if(!$user_id)
            redirect('account/login');
        
        $query = $this->db->query("select KODE_STATUS_REG from EP_VENDOR where KODE_VENDOR = $user_id");
        $row = $query->row_array();
        // exclude crud controller from restricted access
        $allow = $this->uri->segment(1) == 'crud' ? true : false;
        if(!$row['KODE_STATUS_REG'] && !$allow)
            redirect('vendor/registration');
    }
    
    public function _load_model($model, $type = 'grid', $return = true)
    {
        $model = str_replace(".", "/", strtolower($model));
        $path = APPPATH . 'models/' . str_replace(".", "/", strtolower($model)) . '.php';
        if (file_exists($path))
        {
            $this->load->model($model, 'crud_model', true);
        }
        else
        {
            $this->load->model('Model', 'crud_model', true, $model);
        }

        $model = $this->crud_model;
        unset($this->crud_model);

        if ($return)
            return $model;
        else
            $this->model = $model;
    }

    public function _is_ajax_request()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

    public function _grid_data($model)
    {
        $return = null;
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
            
            if($filter)
                $filter = strlen($model->_default_scope()) > 0 ? $filter . ' AND ' . $model->_default_scope() : $filter;
            else
                $filter = strlen($model->_default_scope()) > 0 ? $model->_default_scope() : $filter;
            //$query = $this->db->get('USERS', 10, $page);



            $src = $model->table;
            preg_match("/select/", $model->sql_select, $matches);
            if (count($matches) > 0)
            {
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
        }
        catch (exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        return $return;
    }

    public function _form_data($model)
    {

        $query = null;
        try
        {
            $keys = $model->primary_keys;
            // check wheater primary key was supplied or not
            $where = array();
            foreach ($keys as $key)
                $where[$key] = $_REQUEST[$key];


            $query = $this->db->get_where($model->table, $where)->row_array(); // get single row
            //$model->attributes = $query; // set model attributes
        }
        catch (Exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        return $query;
    }

}
?>