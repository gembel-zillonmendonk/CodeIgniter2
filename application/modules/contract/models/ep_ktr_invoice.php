<?php

class ep_ktr_invoice extends MY_Model
{
    public $table = 'EP_KTR_INVOICE';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_VENDOR',
        'NO_INVOICE',
        'TGL_INVOICE',
        'NAMA_VENDOR',
        'NO_KONTRAK',
        'AKUN_BANK',
        'TGL_BUAT',
        'STATUS',
        'POSISI_PERSETUJUAN',
        'TGL_DISETUJUI',
        'TGL_REKAM',
        'PETUGAS_REKAM',
        'TGL_UBAH',
        'PETUGAS_UBAH',
    );

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>