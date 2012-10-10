<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_temp_domisili extends MY_Model
{
    public $dir = "temp";
    public $table = "EP_VENDOR_TEMP";
    public $elements_conf = array(
        'NO_DOMISILI',
        'TGL_DOMISILI',
        'KADALUARSA_DOMISILI',
        'ALAMAT' => array('type' => 'textarea', 'rows' => 4),
        'KOTA',
        'PROPINSI',
        'KODE_POS',
        'NEGARA',
    );
    public $validation = array(
        'NO_DOMISILI' => array('required' => true),
        'TGL_DOMISILI' => array('required' => true),
        'KADALUARSA_DOMISILI' => array('required' => true),
        'ALAMAT' => array('required' => true),
        'KOTA' => array('required' => true),
        'PROPINSI' => array('required' => true),
        'KODE_POS' => array('required' => true),
        'NEGARA' => array('required' => true),
    );
    public $columns_conf = array(
        'NO_DOMISILI',
        'TGL_DOMISILI',
        'KADALUARSA_DOMISILI',
        'ALAMAT',
        'KOTA',
        'PROPINSI',
        'KODE_POS',
        'NEGARA',);
    
    public $sql_select = "(select * from EP_VENDOR_TEMP)";

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
