<?php

class ep_ktr_perubahan extends MY_Model
{
    public $table = 'EP_KTR_PERUBAHAN';
    public $elements_conf = array(
        'KODE_PERUBAHAN',
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'TGL_MULAI',
        'TGL_AKHIR',
        'MATA_UANG',
        'NILAI_KONTRAK',
        'STATUS',
        'POSISI_PERSETUJUAN',
        'TGL_PERUBAHAN',
        'KONTRAK_TIPE',
        'KONTRAK_TIPE_2',
        'NO_KONTRAK',
        'PERIODE_BAYAR_SEWA',
        'UNIT_BAYAR_SEWA',
        'TERMIN_BAYAR_SEWA',
        'KET_PERUBAHAN',
        'ALASAN_PERUBAHAN',
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