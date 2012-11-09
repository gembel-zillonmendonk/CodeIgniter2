<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crud
 *
 * @author farid
 */
class Ep_vendor extends MY_Model {

    
    public $table = "EP_VENDOR";
    //public $table = "EP_NOMORURUT";
    
    public $elements_conf = array('KODE_VENDOR', 'NAMA_VENDOR', 'KODE_LOGIN','ALAMAT_EMAIL');
    public $columns_conf = array('NAMA_VENDOR', 'KODE_LOGIN');
    public $sql_select = "(select KODE_VENDOR, NAMA_VENDOR, KODE_LOGIN, (1) as \"ad\" from EPROC.EP_VENDOR)";
    
    /*
      public $columns = array(
      'KODE_VENDOR'=>array('name'=>'KODE VENDOR', 'raw_name'=>'KODE_VENDOR', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      'NAMA_VENDOR'=>array('name'=>'NAMA VENDOR', 'raw_name'=>'NAMA_VENDOR', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      'KODE_LOGIN'=>array('name'=>'KODE LOGIN', 'raw_name'=>'KODE_LOGIN', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      );
     */

    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>
