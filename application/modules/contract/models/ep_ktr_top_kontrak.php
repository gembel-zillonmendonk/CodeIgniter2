<?php

class ep_ktr_top_kontrak extends MY_Model
{
    public $table = 'EP_KTR_TOP_KONTRAK';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'TERMIN',
        'KETERANGAN',
        'PERSENTASI',
        'TGL_BAYAR',
        'PERSENTASI_PERKEMBANGAN',
        'STATUS_PERKEMBANGAN',
        'NO_BASTP',
        'TGL_BASTP',
        'JUDUL_BASTP',
        'LAMPIRAN_BASTP',
        'TGL_BUAT_BASTP',
        'STATUS_BASTP',
        'POSISI_PERSETUJUAN',
        'DP_PERSENTASI',
        'KETERANGAN_BASTP',
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