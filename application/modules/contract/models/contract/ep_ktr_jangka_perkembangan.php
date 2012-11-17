<?php

class ep_ktr_jangka_perkembangan extends MY_Model
{
    public $table = 'EP_KTR_JANGKA_PERKEMBANGAN';
    public $elements_conf = array(
        'KODE_PERKEMBANGAN',
        'KODE_KONTRAK',
        'KODE_KANTOR',
        'KODE_JANGKA',
        'TGL_PERKEMBANGAN',
        'PERSENTASI',
//        'STATUS',
        'KETERANGAN',
//        'TGL_REKAM',
//        'PETUGAS_REKAM',
//        'TGL_UBAH',
//        'PETUGAS_UBAH',
    );

    public $dir = 'contract';
    
    function __construct()
    {
        parent::__construct();
        $this->init();
        
        foreach ($this->elements_conf as $key => $value) {
            if(isset($_REQUEST[$value]))
                $this->attributes[$value] = $_REQUEST[$value];
        }
    }

}
?>