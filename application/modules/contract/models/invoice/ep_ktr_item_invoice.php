<?php

class ep_ktr_item_invoice extends MY_Model {

    public $table = 'EP_KTR_ITEM_INVOICE';
    public $elements_conf = array(
        'KODE_ITEM',
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_VENDOR',
        'KODE_INVOICE',
//        'KODE_BASTP',
        'NO_BASTP',
        'NILAI_BASTP',
        'MATA_UANG_BASTP',
//        'PENALTI_BASTP',
//        'PPH23_BASTP',
//        'PPN_BASTP',
//        'DP_BASTP',
        'SUBTOTAL_BASTP',
        'KETERANGAN_BASTP',
//        'KOMENTAR_BASTP',
//        'TGL_REKAM',
//        'PETUGAS_REKAM',
//        'TGL_UBAH',
//        'PETUGAS_UBAH',
    );
    public $columns_conf = array(
//        'KODE_KONTRAK',
//        'KODE_KANTOR',
//        'KODE_VENDOR',
//        'NO_INVOICE',
//        'KODE_BASTP',
        'NO_BASTP',
        'NILAI_BASTP',
        'MATA_UANG_BASTP',
//        'PENALTI_BASTP',
//        'PPH23_BASTP',
//        'PPN_BASTP',
//        'DP_BASTP',
        'SUBTOTAL_BASTP',
        'KETERANGAN_BASTP',
//        'KOMENTAR_BASTP',
//        'TGL_REKAM',
//        'PETUGAS_REKAM',
//        'TGL_UBAH',
//        'PETUGAS_UBAH',
    );
    public $dir = 'invoice';

    function __construct() {
        parent::__construct();
        $this->init();
        if (isset($_REQUEST['KODE_KONTRAK'])
                && isset($_REQUEST['KODE_KANTOR'])
                && isset($_REQUEST['KODE_VENDOR'])
                && isset($_REQUEST['KODE_INVOICE'])) {
            $this->attributes['KODE_KONTRAK'] = $_REQUEST['KODE_KONTRAK'];
            $this->attributes['KODE_KANTOR'] = $_REQUEST['KODE_KANTOR'];
            $this->attributes['KODE_VENDOR'] = $_REQUEST['KODE_VENDOR'];
            $this->attributes['KODE_INVOICE'] = $_REQUEST['KODE_INVOICE'];
        }
    }

    function _default_scope() {
        if (isset($_REQUEST['KODE_KONTRAK'])
                && isset($_REQUEST['KODE_KANTOR'])
                && isset($_REQUEST['KODE_VENDOR'])
                && isset($_REQUEST['KODE_INVOICE']))
            return ' KODE_KONTRAK = ' . $_REQUEST['KODE_KONTRAK']
                    . ' AND KODE_KANTOR = ' . $_REQUEST['KODE_KANTOR']
                    . ' AND KODE_VENDOR = ' . $_REQUEST['KODE_VENDOR']
                    . ' AND KODE_INVOICE = ' . $_REQUEST['KODE_INVOICE'];
    }

}

?>