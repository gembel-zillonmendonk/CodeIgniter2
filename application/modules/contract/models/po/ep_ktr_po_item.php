<?php

class ep_ktr_po_item extends MY_Model {

    public $table = 'EP_KTR_PO_ITEM';
    public $elements_conf = array(
        'KODE_PO_ITEM',
        'KODE_PO',
        'KODE_KONTRAK_ITEM',
        'KODE_ITEM',
        'KETERANGAN',
        'HARGA',
        'QTY',
        'SATUAN',
        'SUB_TOTAL',
        'KETERANGAN_LENGKAP',
        'TGL_REKAM',
        'PETUGAS_REKAM',
        'TGL_UBAH',
        'PETUGAS_UBAH',
    );
    public $dir = 'po';

    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>