<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vendor
 *
 * @author farid
 */
class Pengadaan extends MY_Controller
{
    public $rules;
    public $where;

    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('user_id', '512');
    }
    
    public function createOrEdit()
    {
        $this->layout->view('pengadaan/createOrEdit');
    }
    
    public function daftar()
    {
        $this->layout->view('pengadaan/daftar');
    }

    public function grid()
    {
        // check and load model
        $model = $this->_load_model('ep_pgd_monitor');
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
}
?>
