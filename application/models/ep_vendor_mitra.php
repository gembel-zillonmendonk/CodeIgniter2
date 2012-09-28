<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_mitra extends MY_Model
{
    public $table = "EP_VENDOR";
    public $elements_conf = array(
        'TIPE_VENDOR'=> array('label' => 'MITRA KERJA', 'type' => 'dropdown', 'allow_null' => false, 'options' => array('LOKAL' => 'LOKAL', 'NASIONAL' => 'NASIONAL')),
    );
    public $validation = array(
        'TIPE_VENDOR' => array('required' => true),
    );
    public $columns_conf = array(
        'TIPE_VENDOR',
    );
    public $sql_select = "(select * from EP_VENDOR)";

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
