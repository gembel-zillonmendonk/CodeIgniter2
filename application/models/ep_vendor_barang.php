<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_barang extends MY_Model
{
    public $table = "EP_VENDOR_BARANG";
    public $elements_conf = array(
        'NAMA_BARANG' => array('type' => 'dropdown', 'options' => array('B' => 'BESAR', 'M' => 'MENENGAH', 'K' => 'KECIL')),
        //'KODE_BARANG', auto fill on insert/update
        'KETERANGAN',
        'MEREK',
        'SUMBER' => array('type' => 'dropdown', 'options' => array('LOKAL' => 'LOKAL', 'NASIONAL' => 'NASIONAL')),
        'TIPE' => array('type' => 'dropdown', 'options' => array('AGENT' => 'AGENT', 'DISTRIBUTOR' => 'DISTRIBUTOR')),
    );
    public $validation = array(
        'NAMA_BARANG' => array('required' => true),
        'KETERANGAN' => array('required' => true),
        'MEREK' => array('required' => true),
        'SUMBER' => array('required' => true),
        'TIPE' => array('required' => true),
    );
    public $columns_conf = array(
        'NAMA_BARANG',
        'KODE_BARANG',
        'KETERANGAN',
        'MEREK',
        'SUMBER',
        'TIPE',
    );
    public $sql_select = "(select * from EP_VENDOR_BARANG)";

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