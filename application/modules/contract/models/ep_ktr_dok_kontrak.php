<?php

class ep_ktr_dok_kontrak extends MY_Model
{
    public $table = 'EP_KTR_DOK_KONTRAK';
    public $elements_conf = array(
        'KODE_DOK',
        'KODE_KONTRAK',
        'KATEGORI',
        'KETERANGAN',
        'NAMA_FILE',
        'STATUS',
        'STATUS_PUBLISH',
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