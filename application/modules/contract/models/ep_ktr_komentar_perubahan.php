<?php

class ep_ktr_komentar_perubahan extends MY_Model
{
    public $table = 'EP_KTR_KOMENTAR_PERUBAHAN';
    public $elements_conf = array(
        'KODE_KOMENTAR',
        'KODE_PERUBAHAN',
        'KODE_JABATAN',
        'NAMA_JABATAN',
        'NAMA_KOMENTAR',
        'TGL_KOMENTAR',
        'STATUS_KOMENTAR',
        'TANGGAPAN_KOMENTAR',
        'LAMPIRAN',
        'KOMENTAR',
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