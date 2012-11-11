<?php

class ep_ktr_po_perkembangan extends MY_Model
{
    public $table = 'EP_KTR_PO_PERKEMBANGAN';
    public $elements_conf = array(
        'KODE_PERKEMBANGAN',
        'KODE_PO',
        'TGL_PERKEMBANGAN',
        'TGL_BUAT',
        'PEMBUAT',
        'NAMA_PEMBUAT',
        'STATUS',
        'PERSENTASI_PERKEMBANGAN',
        'POSISI_PERSETUJUAN',
        'KETERANGAN',
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