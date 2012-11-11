<?php

class ep_ktr_dok_invoice extends MY_Model {

    public $table = 'EP_KTR_DOK_INVOICE';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_VENDOR',
        'NO_INVOICE',
        'KATEGORI',
        'KETERANGAN',
        'NAMA_FILE',
        'STATUS',
        'TGL_REKAM',
        'PETUGAS_REKAM',
        'TGL_UBAH',
        'PETUGAS_UBAH',
    );
    public $dir = 'invoice';

    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>