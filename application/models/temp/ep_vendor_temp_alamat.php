<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_temp_alamat extends MY_Model
{
    public $dir = "temp";
    public $table = "EP_VENDOR_TEMP_ALAMAT";
    public $elements_conf = array(
        'ALAMAT',
        'KOTA',
        'NEGARA',
        'KODE_POS',
        'TIPE',
        'NO_TELP1',
        'NO_TELP2',
        'FAX',
        'WEBSITE',
    );
    public $validation = array(
        'ALAMAT' => array('required' => true),
        'KOTA' => array('required' => true),
        'NEGARA' => array('required' => true),
        'KODE_POS' => array('required' => true),
        'TIPE' => array('required' => true),
        'NO_TELP1' => array('required' => true),
    );
    public $columns_conf = array(
        'ALAMAT',
        'KOTA',
        'NEGARA',
        'KODE_POS',
        'TIPE',
        'NO_TELP1',
        'FAX',
    );
    public $sql_select = "(select * from EP_VENDOR_TEMP_ALAMAT)";

    function __construct()
    {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
    }
}
?>
