<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_tenaga_pendukung extends MY_Model
{
    public $table = "EP_VENDOR_TENAGA_KERJA";
    public $elements_conf = array(
        'NAMA',
        'PENDIDIKAN_TERAKHIR',
        'KEAHLIAN',
        'TAHUN_BERAKHIR'=>array('label'=>'PENGALAMAN'),
        'STATUS_PEGAWAI'=>array('type'=>'dropdown', 'options'=>array('PERMANEN'=>'PERMANEN', 'KONTRAK'=>'KONTRAK')),
        'TIPE_PEGAWAI'=>array('label'=>'KEWARGANEGARAAN'),
    );
    public $validation = array(
        'NAMA' => array('required' => true),
        'PENDIDIKAN_TERAKHIR' => array('required' => true),
        'KEAHLIAN' => array('required' => true),
        'TAHUN_BERAKHIR' => array('required' => true),
        'STATUS_PEGAWAI' => array('required' => true),
        'TIPE_PEGAWAI' => array('required' => true),
    );
    public $columns_conf = array(
        'NAMA',
        'PENDIDIKAN_TERAKHIR',
        'KEAHLIAN',
        'TAHUN_BERAKHIR',
        'STATUS_PEGAWAI',
        'TIPE_PEGAWAI',
    );
    public $sql_select = "(select * from EP_VENDOR_TENAGA_KERJA where TIPE = 'PENDUKUNG')";

    function __construct()
    {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
        $this->attributes['TIPE'] = 'PENDUKUNG';
    }

    function _default_scope()
    {
        $CI = & get_instance();
        return ' KODE_VENDOR = '.$CI->session->userdata('user_id');
    }
}
?>
