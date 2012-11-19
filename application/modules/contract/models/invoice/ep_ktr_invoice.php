<?php

class ep_ktr_invoice extends MY_Model
{
    public $table = 'EP_KTR_INVOICE';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_VENDOR',
        'KODE_INVOICE',
        'TGL_INVOICE',
        'NAMA_VENDOR',
        'NO_KONTRAK',
        'AKUN_BANK',
//        'TGL_BUAT',
//        'STATUS',
//        'POSISI_PERSETUJUAN',
//        'TGL_DISETUJUI',
//        'TGL_REKAM',
//        'PETUGAS_REKAM',
//        'TGL_UBAH',
//        'PETUGAS_UBAH',
    );
    public $dir = 'invoice';
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>