<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_jamsostek extends MY_Model
{
    public $table = "EP_VENDOR";
    public $elements_conf = array(
        'NPP',
    );
    public $validation = array(
        'NPP' => array('required' => true),
    );
    public $columns_conf = array(
        'NPP',
    );
    //public $sql_select = "(select * from EP_VENDOR)";
    

    function __construct()
    {
        parent::__construct();
        $this->init();
        
        // set default value here
        $CI =& get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
    }
}
?>
