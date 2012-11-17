<?php

class ep_ktr_dok_kontrak extends MY_Model {

    public $table = 'EP_KTR_DOK_KONTRAK';
    public $elements_conf = array(
        'KODE_DOKUMEN',
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_KATEGORI',
        'KETERANGAN',
        'NAMA_FILE',
        'STATUS',
        'STATUS_PUBLISH',
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