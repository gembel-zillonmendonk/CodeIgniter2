<?php

class ep_ktr_item_perubahan extends MY_Model
{
    public $table = 'EP_KTR_ITEM_PERUBAHAN';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_PERUBAHAN',
        'KODE_ITEM_KONTRAK',
        'KODE_ITEM',
        'KETERANGAN',
        'HARGA',
        'JUMLAH',
        'MIN_QTY',
        'MAX_QTY',
        'SATUAN',
        'SUB_TOTAL',
        'KETERANGAN_LENGKAP',
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