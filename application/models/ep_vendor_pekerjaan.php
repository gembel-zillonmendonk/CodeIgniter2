<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_peralatan extends MY_Model
{
    public $table = "EP_VENDOR_PERALATAN";
    public $elements_conf = array(
        'KATEGORI' => array('type' => 'dropdown', 'options' => array('PERMESINAN' => 'PERMESINAN', 'LAINNYA' => 'LAINNYA')),
        'NAMA_PERALATAN',
        'SPESIFIKASI',
        'JUMLAH',
        'TAHUN_PEMBUATAN',
    );
    public $validation = array(
        'KATEGORI' => array('required' => true),
        'NAMA_PERALATAN' => array('required' => true),
        'JUMLAH' => array('required' => true),
    );
    public $columns_conf = array(
        'KATEGORI',
        'NAMA_PERALATAN',
        'SPESIFIKASI',
        'JUMLAH',
        'TAHUN_PEMBUATAN',
    );
    public $sql_select = "(select * from EP_VENDOR_PERALATAN)";

    function __construct()
    {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
    }

    function _default_scope()
    {
        $CI = & get_instance();
        return ' KODE_VENDOR = '.$CI->session->userdata('user_id');
    }
}
?>
