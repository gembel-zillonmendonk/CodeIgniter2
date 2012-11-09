<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_importir extends MY_Model
{
    public $table = "EP_VENDOR_AGEN";
    public $elements_conf = array(
        'NO',
        'PENERBIT',
        'TGL_BUAT',
        'TGL_BERAKHIR',
    );
    public $validation = array(
        'PENERBIT' => array('required' => true),
        'NO' => array('required' => true),
        'TGL_BUAT' => array('required' => true),
        'TGL_BERAKHIR' => array('required' => true),
    );
    public $columns_conf = array(
        'NO',
        'PENERBIT',
        'TGL_BUAT',
        'TGL_BERAKHIR',
    );
    
    public $sql_select = "(select * from EP_VENDOR_AGEN where TIPE = 'IMPORTIR')";

    function __construct()
    {
        parent::__construct();
        $this->init();
        
        // set default value here
        $CI =& get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
        $this->attributes['TIPE'] = 'IMPORTIR';
    }

    function _default_scope()
    {
        $CI = & get_instance();
        return ' KODE_VENDOR = '.$CI->session->userdata('user_id');
    }
}
?>
