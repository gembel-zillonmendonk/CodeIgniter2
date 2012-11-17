<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_barang extends MY_Model
{
    public $table = "EP_VENDOR_BARANG";
    public $elements_conf = array(
        //'NAMA_BARANG' => array('type' => 'dropdown', 'options' => array('B' => 'BESAR', 'M' => 'MENENGAH', 'K' => 'KECIL')),
        //'KODE_BARANG', auto fill on insert/update
        'KODE_BARANG' => array('label'=>'NAMA BARANG', 'type' => 'dropdown', 'options' => null),
        'KETERANGAN',
        'MEREK',
        'SUMBER' => array('type' => 'dropdown', 'options' => array('LOKAL' => 'LOKAL', 'NASIONAL' => 'NASIONAL')),
        'TIPE' => array('type' => 'dropdown', 'options' => array('AGENT' => 'AGENT', 'DISTRIBUTOR' => 'DISTRIBUTOR')),
    );
    public $validation = array(
        //'NAMA_BARANG' => array('required' => true),
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

        // dropdown from table relation
        $this->elements_conf['KODE_BARANG']['options'] = array('B' => 'BESAR', 'M' => 'MENENGAH', 'K' => 'KECIL');
        
        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
    }

    function _default_scope()
    {
        $CI = & get_instance();
        return ' KODE_VENDOR = '.$CI->session->userdata('user_id');
    }
    
    function _before_save() {
        parent::_before_save();
        $this->attributes['NAMA_BARANG'] = 'xxxx'; // fetch nama_barang depent on kode_barang
    }
}
?>
