<?php

class ep_ktr_jangka_perubahan extends MY_Model
{
    public $table = 'EP_KTR_JANGKA_PERUBAHAN';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_PERUBAHAN',
        'KODE_JANGKA_KONTRAK',
        'PERSENTASI',
        'TGL_TARGET',
        'KETERANGAN',
        'TGL_REKAM',
        'PETUGAS_REKAM',
        'TGL_UBAH',
        'PETUGAS_UBAH',
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