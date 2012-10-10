<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_temp_jasa extends MY_Model
{
	public $dir = "temp";
    public $table = "EP_VENDOR_TEMP_JASA";
    public $elements_conf = array(
        //'KODE_JASA', auto fill on insert
        'NAMA_JASA'  => array('type' => 'dropdown', 'options' => array('B' => 'BESAR', 'M' => 'MENENGAH', 'K' => 'KECIL')),
        'TIPE' => array('type' => 'dropdown', 'options' => array('AGENT' => 'AGENT', 'DISTRIBUTOR' => 'DISTRIBUTOR')),
    );
    public $validation = array(
        //'KODE_JASA' => array('required' => true),
        'NAMA_JASA' => array('required' => true),
        'TIPE' => array('required' => true),
    );
    public $columns_conf = array(
        'KODE_JASA',
        'NAMA_JASA',
        'TIPE',
    );
    public $sql_select = "(select * from EP_VENDOR_TEMP_JASA)";

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
