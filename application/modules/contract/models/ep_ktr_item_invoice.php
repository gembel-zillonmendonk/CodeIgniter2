<?php

class ep_ktr_item_invoice extends MY_Model
{
    public $table = 'EP_KTR_ITEM_INVOICE';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_VENDOR',
        'NO_INVOICE',
        'KODE_BASTP',
        'NO_BASTP',
        'NILAI_BASTP',
        'MATA_UANG_BASTP',
        'PENALTI_BASTP',
        'PPH23_BASTP',
        'PPN_BASTP',
        'DP_BASTP',
        'SUBTOTAL_BASTP',
        'KETERANGAN_BASTP',
        'KOMENTAR_BASTP',
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