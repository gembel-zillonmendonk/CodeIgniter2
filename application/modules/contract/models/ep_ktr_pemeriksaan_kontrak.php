<?php

class ep_ktr_pemeriksaan_kontrak extends MY_Model
{
    public $table = 'EP_KTR_PEMERIKSAAN_KONTRAK';
    public $elements_conf = array(
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_PARAM ',
        'NAMA_PARAM ',
        'HASIL ',
        'TGL_REKAM ',
        'PETUGAS_REKAM ',
        'TGL_UBAH ',
        'PETUGAS_UBAH ',
    );

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>