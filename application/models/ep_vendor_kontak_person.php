<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_kontak_person extends MY_Model
{
    public $table = "EP_VENDOR";
    public $elements_conf = array(
        'NAMA_KONTAK',
        'JABATAN_KONTAK',
        'NO_TELP_KONTAK',
        'EMAIL_KONTAK',
    );
    public $validation = array(
        'NAMA_KONTAK' => array('required' => true),
        'JABATAN_KONTAK' => array('required' => true),
        'NO_TELP_KONTAK' => array('required' => true),
        'EMAIL_KONTAK' => array('required' => true),
    );
    public $columns_conf = array(
        'NAMA_KONTAK',
        'JABATAN_KONTAK',
        'NO_TELP_KONTAK',
        'EMAIL_KONTAK',
    );
    public $sql_select = "(select * from EP_VENDOR)";

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
