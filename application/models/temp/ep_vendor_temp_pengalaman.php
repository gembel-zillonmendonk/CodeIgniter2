<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_temp_pengalaman extends MY_Model 
{
	public $dir = "temp";
    public $table = "EP_VENDOR_TEMP_PENGALAMAN";
    public $elements_conf = array(
        'NAMA',
        'NAMA_PROYEK',
        'MATA_UANG',
        'NILAI',
        'TGL_MULAI',
        'TGL_BERAKHIR',
        'KONTAK',
        'NO_KONTAK',
        'NO_KONTRAK',
        'KETERANGAN',
    );
    public $validation = array(
        'NAMA' => array('required' => true),
        'NAMA_PROYEK' => array('required' => true),
        //'MATA_UANG' => array('required' => true),
        // 'NILAI' => array('required' => true),
        'TGL_MULAI' => array('required' => true),
        'TGL_BERAKHIR' => array('required' => true),
        'KONTAK' => array('required' => true),
        //'NO_KONTAK' => array('required' => true),
        //'KETERANGAN' => array('required' => true),
    );
    public $columns_conf = array(
        'NAMA',
        'NAMA_PROYEK',
        'MATA_UANG',
        'NILAI',
        'TGL_MULAI',
        'TGL_BERAKHIR',
        'KONTAK',
        'NO_KONTAK',
        'NO_KONTRAK',
        'KETERANGAN',
    );
    public $sql_select = "(select * from EP_VENDOR_TEMP_PENGALAMAN)";

    function __construct() {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
    }

}

?>
