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
class contract extends MY_Controller
{
    public $rules;
    public $where;

    public function createDraft(){
        
        if($this->_is_ajax_request())
            $this->load->view('contract/contract/draft');
        else
            $this->layout->view('contract/contract/draft');
    }
    
    public function updateProgress(){
        
        if($this->_is_ajax_request())
            $this->load->view('contract/contract/updateProgress');
        else
            $this->layout->view('contract/contract/updateProgress');
    }
    
    public function updateBASTP(){
        
        if($this->_is_ajax_request())
            $this->load->view('contract/contract/updateBASTP');
        else
            $this->layout->view('contract/contract/updateBASTP');
    }
}
?>
