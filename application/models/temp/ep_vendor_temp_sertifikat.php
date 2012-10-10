<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_temp_sertifikat extends MY_Model
{
	public $dir = "temp";
    public $table = "EP_VENDOR_TEMP_SERTIFIKAT";
    public $elements_conf = array(
        'TIPE' => array('type' => 'dropdown', 'options' => array('MUTU' => 'MUTU', 'LAINNYA' => 'LAINNYA')),
        'TIPE_LAIN',
        'NAMA',
        'NO_SERTIFIKAT',
        'PENERBIT',
        'BERLAKU_DARI',
        'BERLAKU_HINGGA',
    );
    public $validation = array(
        'TIPE' => array('required' => true),
        'NAMA' => array('required' => true),
        'NO_SERTIFIKAT' => array('required' => true),
        'PENERBIT' => array('required' => true),
        'BERLAKU_DARI' => array('required' => true),
        'BERLAKU_HINGGA' => array('required' => true),
    );
    public $columns_conf = array(
        'TIPE',
        'NAMA',
        'NO_SERTIFIKAT',
        'PENERBIT',
        'BERLAKU_DARI',
        'BERLAKU_HINGGA',
    );
    public $sql_select = "(select * from EP_VENDOR_TEMP_SERTIFIKAT)";

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
