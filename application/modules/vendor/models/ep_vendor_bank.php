<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_bank extends MY_Model
{
    public $table = "EP_VENDOR_BANK";
    public $elements_conf = array(
        'NO_REKENING'=>array('label'=>'NOMOR REKENING'),
        'NAMA_REKENING',
        'NAMA_BANK',
        'CABANG',
        'MATA_UANG',
        'ALAMAT',
    );
    public $validation = array(
        'NO_REKENING' => array('required' => true),
        'NAMA_REKENING' => array('required' => true),
        'NAMA_BANK' => array('required' => true),
        'CABANG' => array('required' => true),
        'MATA_UANG' => array('required' => true),
    );
    public $columns_conf = array(
        'NO_REKENING',
        'NAMA_REKENING',
        'NAMA_BANK',
        'CABANG',
        'MATA_UANG',
        'ALAMAT',
    );
    public $sql_select = "(select * from EP_VENDOR_BANK)";

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
