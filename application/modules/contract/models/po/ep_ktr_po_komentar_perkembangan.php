<?php

class ep_ktr_po_komentar_perkembangan extends MY_Model
{
    public $table = 'EP_KTR_PO_KOMENTAR_PERKEMBANGAN';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'NO_PO',
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