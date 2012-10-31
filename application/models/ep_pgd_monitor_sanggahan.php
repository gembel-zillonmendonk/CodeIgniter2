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
class Ep_pgd_monitor_sanggahan extends MY_Model {
    
    public $table = "EP_PGD_SANGGAHAN";
    public $columns_conf = array(
        'KODE_TENDER', 
        'KODE_VENDOR', 
        'KODE_SANGGAHAN', 
        'JUDUL_PEKERJAAN', 
        'JUDUL', 
        'ALASAN',
        'STATUS',
        'DISETUJUI_OLEH',
        'TANGGAL_DIBUAT',
        'TANGGAL_DITUTUP',
        );
    public $sql_select = "(
        select * from vw_ext_prc_tender_claim
        )";
    
    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>
