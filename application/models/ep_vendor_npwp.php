<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_npwp extends MY_Model
{
    public $table = "EP_VENDOR";
    public $elements_conf = array(
        'NO_NPWP' => array('type' => 'text', 'allow_null' => false),
        'ALAMAT_NPWP' => array('type' => 'text', 'allow_null' => false),
        'KOTA_NPWP' => array('type' => 'text', 'allow_null' => false),
        'PROPINSI_NPWP' => array('type' => 'text', 'allow_null' => false),
        'KODE_POS_NPWP' => array('type' => 'number', 'allow_null' => false),
        'PKP_NPWP' => array('type' => 'dropdown', 'allow_null' => false, 'options' => array('YA' => 'YA', 'Tidak' => 'Tidak')),
        'NO_PKP_NPWP' => array('type' => 'text', 'allow_null' => false),
    );
    public $columns_conf = array(
        'NO_NPWP',
        'ALAMAT_NPWP',
        'KOTA_NPWP',
        'PROPINSI_NPWP',
        'KODE_POS_NPWP',
        'PKP_NPWP',
        'NO_PKP_NPWP',);
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
