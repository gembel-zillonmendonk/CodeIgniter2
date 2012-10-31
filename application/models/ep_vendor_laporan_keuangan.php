<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_laporan_keuangan extends MY_Model
{
    public $table = "EP_VENDOR_LAPORAN_KEUANGAN";
    public $elements_conf = array(
        'TAHUN',
        'TIPE'=>array('type'=>'dropdown', 'options'=>array('AUDIT'=>'AUDIT', 'NON AUDIT'=>'NON AUDIT')),
        'MATA_UANG',
        'NILAI_ASSET',
        'HUTANG',
        'PENDAPATAN',
        'LABA_BERSIH',
        'KELAS',
    );
    public $validation = array(
        'MATA_UANG' => array('required' => true),
        'TAHUN' => array('required' => true),
        'TIPE' => array('required' => true),
        'NILAI_ASSET' => array('required' => true),
        'HUTANG' => array('required' => true),
        'PENDAPATAN' => array('required' => true),
        'LABA_BERSIH' => array('required' => true),
        'KELAS' => array('required' => true),
    );
    public $columns_conf = array(
        'MATA_UANG',
        'TAHUN',
        'TIPE',
        'NILAI_ASSET',
        'HUTANG',
        'PENDAPATAN',
        'LABA_BERSIH',
        'KELAS',
    );
    public $sql_select = "(select * from EP_VENDOR_LAPORAN_KEUANGAN)";

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
