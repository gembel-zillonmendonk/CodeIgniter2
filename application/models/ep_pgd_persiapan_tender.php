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
class Ep_pgd_persiapan_tender extends MY_Model {
    
    public $table = "EP_PGD_PERSIAPAN_TENDER";
    
    public $elements_conf = array(
//        'KODE_TENDER',
//        'KODE_KANTOR',
        'METODE_TENDER',
        'METODE_SUBMISSION',
        'METODE_EVALUASI',
        'TGL_PEMBUKAAN_REG',
        'TGL_PENUTUPAN_REG',
//        'TGL_PRE_LELANG',
//        'LOKASI_PRE_LELANG',
//        'TGL_PENUTUPAN_PEN',
//        'TGL_LELANG_TEKNIS',
//        'TGL_LELANG_KOMODITI',
//        'KODE_KANTOR_PEMINTA',
        'CATATAN_KE_VENDOR',
//        'URUTAN',
//        'TGL_PEMBUKAAN_KUA',
//        'TGL_PENUTUPAN_KUA',
//        'KODE_EVALUASI',
//        'KETERANGAN_EVALUASI',
//        'KODE_PANITIA',
//        'NAMA_PANITIA',
//        'KODE_PRE_KUALIFIKASI',
//        'NAMA_PRE_KUALIFIKASI',
        'TGL_PEMBUKAAN_LELANG',
        'TGL_AANWIJZING2',
        'LOKASI_AANWIJZING2',
//        'JUSTIFIKASI',
    );
    
    //public $form_view = 'pengadaan/form_penawaran';
    
    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>
