<?php

class ep_ktr_top_perkembangan extends MY_Model
{
    public $table = 'EP_KTR_TOP_PERKEMBANGAN';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_TOP',
        'TGL_PERKEMBANGAN',
        'PERSENTASI',
        'STATUS',
        'KETERANGAN',
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