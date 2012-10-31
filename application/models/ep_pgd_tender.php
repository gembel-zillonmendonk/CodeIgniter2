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
class Ep_pgd_tender extends MY_Model
{
    public $table = "EP_PGD_TENDER";
    public $elements_conf = array(
        'KODE_TENDER',
        'KODE_KANTOR',
//        'KODE_PERENCANAAN',
        'KODE_TENDER_SEBELUM',
        'KODE_TENDER_SESUDAH',
//        'NAMA_PEMOHON',
//        'KODE_JAB_PEMOHON',
//        'NAMA_PERENCANA',
//        'KODE_JAB_PERENCANA',
        'NAMA_PELAKSANA',
//        'KODE_JAB_PELAKSANA',
//        'TGL_PEMBUATAN',
        'JUDUL_PEKERJAAN',
        'LINGKUP_PEKERJAAN',
//        'WAKTU_PENGIRIMAN',
//        'UNIT_PENGIRIMAN',
//        'NAMA_PEMBELI',
//        'KODE_JAB_PEMBELI',
        'MATA_UANG',
        'TIPE_KONTRAK',
//        'NAMA_JAB_PESERTA',
//        'KODE_JAB_PESERTA',
//        'PEMBUATAN_KONTRAK',
//        'STATUS',
    );

    //public $form_view = 'pengadaan/form_penawaran';

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>
