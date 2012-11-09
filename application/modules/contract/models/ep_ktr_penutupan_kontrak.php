<?php

class ep_ktr_penutupan_kontrak extends MY_Model
{
    public $table = 'EP_KTR_PENUTUPAN_KONTRAK';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KEPUTUSAN_MASALAH',
        'KEPUTUSAN_WAN',
        'ALASAN_PENUTUPAN',
        'PERNYATAAN_MASALAH',
        'PERNYATAAN_WAN',
        'EVAL_TENDER',
        'EVAL_PENYELESAIAN',
        'EVAL_PENGIRIMAN',
        'EVAL_KINERJA',
        'EVAL_PERNYATAAN',
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