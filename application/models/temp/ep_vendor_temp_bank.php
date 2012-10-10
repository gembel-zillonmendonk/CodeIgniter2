<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_temp_bank extends MY_Model
{
    public $dir = "temp";
    public $table = "EP_VENDOR_TEMP_BANK";
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
    public $sql_select = "(select * from EP_VENDOR_TEMP_BANK)";

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
