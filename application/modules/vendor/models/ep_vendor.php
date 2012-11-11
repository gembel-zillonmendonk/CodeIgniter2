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
    public $columns_conf = array(
        'NAMA_VENDOR'=>array('hidden'=>false, 'width'=>20), 
        'KODE_LOGIN'=>array('hidden'=>false, 'width'=>10),
        'ACT'=>array('hidden'=>false, 'width'=>10), 
        'xxx'=>array('hidden'=>false, 'width'=>10), 
        'NAMA_STATUS_REG'=>array('hidden'=>false, 'width'=>20)
        );
    public $sql_select = "(
        select KODE_VENDOR, KODE_VENDOR as \"xxx\", NAMA_VENDOR, KODE_LOGIN, NAMA_STATUS_REG, '' as \"ACT\"
        from EP_VENDOR a
        left join EP_VENDOR_STATUS_REGISTRASI b on a.KODE_STATUS_REG = b.KODE_STATUS_REG 
        )";
    
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
        
        $this->js_grid_completed = 'var ids = jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'getDataIDs\');
		for(var i=0;i < ids.length;i++){
                    var cl = ids[i];
                    
                    be = "<button onclick=\"jQuery(\'#grid_'.strtolower(get_class($this)).'\').editRow(\'"+cl+"\');\" type=\"button\" id=\"btnProses\" class=\"ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" role=\"button\" aria-disabled=\"false\"><span class=\"ui-button-text\">PROSES</span></button>";
                    jQuery(\'#grid_'.strtolower(get_class($this)).'\').jqGrid(\'setRowData\',ids[i],{ACT:be});
		}';
        
        
    }

}

?>
