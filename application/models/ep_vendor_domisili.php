<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_domisili extends MY_Model
{
    public $table = "EP_VENDOR";
    public $elements_conf = array(
        'NO_DOMISILI',
        'TGL_DOMISILI',
        'KADALUARSA_DOMISILI',
        'ALAMAT',
        'KOTA',
        'PROPINSI',
        'KODE_POS',
        'NEGARA',
    );
    public $columns_conf = array(
        'NO_DOMISILI',
        'TGL_DOMISILI',
        'KADALUARSA_DOMISILI',
        'ALAMAT',
        'KOTA',
        'PROPINSI',
        'KODE_POS',
        'NEGARA',);
    public $sql_select = "(select * from EP_VENDOR)";

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
