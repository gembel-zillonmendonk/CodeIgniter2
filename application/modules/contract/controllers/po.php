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
class po extends MY_Controller
{
    public $rules;
    public $where;

    public function createDraft(){
        
        if($this->_is_ajax_request())
            $this->load->view('po/draft');
        else
            $this->layout->view('po/draft');
    }
}
?>
