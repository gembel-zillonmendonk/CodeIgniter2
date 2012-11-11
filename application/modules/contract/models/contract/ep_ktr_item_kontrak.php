<?php

class ep_ktr_item_kontrak extends MY_Model {

    public $table = 'EP_KTR_ITEM_KONTRAK';
    public $elements_conf = array(
        'KODE_ITEM_KONTRAK',
        'TIT_ID',
        'KODE_KONTRAK',
        'KODE_ITEM',
        'KETERANGAN',
        'HARGA',
        'JUMLAH',
        'MIN_QTY',
        'MAX_QTY',
        'SATUAN',
        'SUB_TOTAL',
        'KETERANGAN_LENGKAP',
//        'TGL_REKAM',
//        'PETUGAS_REKAM',
//        'TGL_UBAH',
//        'PETUGAS_UBAH',
    );
    public $columns_conf = array(
        'KODE_ITEM_KONTRAK',
        'TIT_ID',
        'KODE_KONTRAK',
        'KODE_ITEM',
        'KETERANGAN',
        'HARGA',
        'JUMLAH',
        'MIN_QTY',
        'MAX_QTY',
        'SATUAN',
        'SUB_TOTAL',
        'KETERANGAN_LENGKAP',
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