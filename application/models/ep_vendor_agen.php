<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_agen extends MY_Model
{
    public $table = "EP_VENDOR_AGEN";
    public $elements_conf = array(
        'KODE_VENDOR',
        'TIPE',
        'PENERBIT',
        'TGL_BUAT',
        'TGL_BERAKHIR',
        'NO');
    public $columns_conf = array(
        'KODE_VENDOR',
        'TIPE',
        'PENERBIT',
        'TGL_BUAT',
        'TGL_BERAKHIR',
        'NO',
        'TGL_REKAM',
        'PETUGAS_REKAM',
        'TGL_UBAH',
        'PETUGAS_UBAH');
    public $sql_select = "(select * from EP_VENDOR_AGEN)";

    /*
      public $columns = array(
      'KODE_VENDOR'=>array('name'=>'KODE VENDOR', 'raw_name'=>'KODE_VENDOR', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      'NAMA_VENDOR'=>array('name'=>'NAMA VENDOR', 'raw_name'=>'NAMA_VENDOR', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      'KODE_LOGIN'=>array('name'=>'KODE LOGIN', 'raw_name'=>'KODE_LOGIN', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      );
     */

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>
