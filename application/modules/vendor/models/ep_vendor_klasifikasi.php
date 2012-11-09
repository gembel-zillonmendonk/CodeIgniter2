<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_klasifikasi extends MY_Model
{
    public $table = "EP_VENDOR";
    public $elements_conf = array(
        'GOLONGAN_KEUANGAN'=> array('type' => 'dropdown', 'options' => array('B' => 'BESAR', 'M' => 'MENENGAH', 'K' => 'KECIL')),        
    );
    public $validation = array(
        'GOLONGAN_KEUANGAN' => array('required' => true),
    );
    public $columns_conf = array(
        'GOLONGAN_KEUANGAN',
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
