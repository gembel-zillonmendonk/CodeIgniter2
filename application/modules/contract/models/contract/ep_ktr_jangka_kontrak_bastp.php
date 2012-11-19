<?php

class ep_ktr_jangka_kontrak_bastp extends MY_Model {

    public $table = 'EP_KTR_JANGKA_KONTRAK';
    public $elements_conf = array(
        'KODE_JANGKA',
        'KODE_KONTRAK',
        'KODE_KANTOR',
//        'PERSENTASI',
//        'TGL_TARGET',
//        'PERSENTASI_PERKEMBANGAN',
//        'STATUS_PERKEMBANGAN',
        'NO_BASTP',
        'TGL_BASTP',
        'JUDUL_BASTP',
        'LAMPIRAN_BASTP',
//        'TGL_BUAT_BASTP',
//        'STATUS_BASTP',
//        'POSISI_PERSETUJUAN',
//        'DP_PERSENTASI',
//        'KETERANGAN',
        'KETERANGAN_BASTP',
//        'TGL_REKAM',
//        'PETUGAS_REKAM',
//        'TGL_UBAH',
//        'PETUGAS_UBAH',
    );
    public $columns_conf = array(
        'KODE_KONTRAK',
//        'KODE_KANTOR',
        'PERSENTASI',
        'TGL_TARGET',
//        'PERSENTASI_PERKEMBANGAN',
//        'STATUS_PERKEMBANGAN',
//        'NO_BASTP',
//        'TGL_BASTP',
//        'JUDUL_BASTP',
//        'LAMPIRAN_BASTP',
//        'TGL_BUAT_BASTP',
//        'STATUS_BASTP',
//        'POSISI_PERSETUJUAN',
//        'DP_PERSENTASI',
        'KETERANGAN',
//        'KETERANGAN_BASTP',
//        'TGL_REKAM',
//        'PETUGAS_REKAM',
//        'TGL_UBAH',
//        'PETUGAS_UBAH',
    );
    public $dir = 'contract';

    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>