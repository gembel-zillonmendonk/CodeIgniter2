<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_temp_direksi extends MY_Model
{
    public $dir = "temp";
    public $table = "EP_VENDOR_TEMP_DEWAN_DIREKSI";
    public $elements_conf = array(
        'NAMA',
        'JABATAN',
        'NO_TELP',
        'EMAIL',
        'NO_KTP',
        'NO_NPWP',
    );
    public $validation = array(
        'NAMA' => array('required' => true),
        'JABATAN' => array('required' => true),
    );
    public $columns_conf = array(
        'NAMA',
        'JABATAN',
        'NO_TELP',
        'EMAIL',
        'NO_KTP',
        'NO_NPWP',
    );
    public $sql_select = "(select * from EP_VENDOR_TEMP_DEWAN_DIREKSI where TIPE = 'DIREKSI')";

    function __construct()
    {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
        $this->attributes['TIPE'] = 'DIREKSI';
    }

}
?>
