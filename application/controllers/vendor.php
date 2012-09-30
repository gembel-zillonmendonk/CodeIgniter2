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
class vendor extends CI_Controller
{
    public function createOrEdit()
    {
        $this->session->set_userdata('user_id', '512');
        
        //$this->session->set_userdata('user_id', '7827400');
        
        $this->layout->view('vendor/createOrEdit');
    }
}
?>
