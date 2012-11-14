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
class Ep_vendor_dokumen extends MY_Model {

    
    public $table = "EP_VENDOR_DOKUMEN";
    
    public $elements_conf = array('KODE_VENDOR', 'KODE_DOKUMEN_REF', 'STATUS','NOTE','KETERANGAN');
    public $columns_conf = array(
        'NAMA_VENDOR'=>array('hidden'=>false, 'width'=>20), 
        'KODE_LOGIN'=>array('hidden'=>false, 'width'=>10),
        'ACT'=>array('hidden'=>false, 'width'=>10), 
        'xxx'=>array('hidden'=>false, 'width'=>10), 
        'NAMA_STATUS_REG'=>array('hidden'=>false, 'width'=>20)
        );
    public $form_view = 'vendor/form_dokumen';
    public $checklist_doc = array();
    
    function __construct() {
        parent::__construct();
        $this->init();
        
        $sql = 'select a.*, B.KODE_VENDOR, B.KETERANGAN, B.NOTE, coalesce(B.STATUS, \'0\') as "STATUS"
                from EP_VENDOR_DOKUMEN_REF a
                left join EP_VENDOR_DOKUMEN b on A.KODE_DOKUMEN_REF = B.KODE_DOKUMEN_REF';
        $query = $this->db->query($sql);
        $this->checklist_doc = $query->result_array();
    }

}

?>
