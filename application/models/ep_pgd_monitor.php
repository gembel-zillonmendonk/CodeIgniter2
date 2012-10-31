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
class Ep_pgd_monitor extends MY_Model {
    
    public $table = "EP_PGD_TENDER";
    public $columns_conf = array('KODE_VENDOR', 'JUDUL_PEKERJAAN', 'TGL_PEMBUATAN', 'KODE_PERENCANAAN', 'KODE_TENDER_SEBELUM', 'KODE_TENDER_SESUDAH');
    public $sql_select = "(
        select KODE_VENDOR, KODE_TENDER, KODE_KANTOR, JUDUL_PEKERJAAN, TGL_PEMBUATAN, (1) as \"ad\" 
        from EP_PGD_TENDER_VENDOR a
        inner join EP_PGD_TENDER b on a.KODE_TENDER = b.KODE_TENDER
        inner join EP_PGD_TENDER_VENDOR c on b.KODE_TENDER = c.KODE_TENDER and a.KODE_VENDOR = c.KODE_VENDOR
        )";
    
    public $grid_view = 'pengadaan/monitor';
    
    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>
