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
class Ep_vendor_dokumen_pendukung extends MY_Model {

    
    public $table = "EP_VENDOR_DOKUMEN_PENDUKUNG";
    
    public $elements_conf = array('KODE_VENDOR', 'KETERANGAN_DOKUMEN', 'URL_DOKUMEN','NAMA_FILE');
    public $columns_conf = array(
        'KETERANGAN_DOKUMEN'=>array('hidden'=>false, 'width'=>20), 
        'URL_DOKUMEN'=>array('hidden'=>false, 'width'=>10),
        'NAMA_FILE'=>array('hidden'=>false, 'width'=>10), 
        );
    

    function __construct() {
        parent::__construct();
        $this->init();
        
    }

}

?>
