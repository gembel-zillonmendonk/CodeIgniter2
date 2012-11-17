<?php

class ep_ktr_item_perkembangan extends MY_Model
{
    public $table = 'EP_KTR_ITEM_PERKEMBANGAN';
    public $elements_conf = array(
        'KODE_ITEM_PERKEMBANGAN',
        'KODE_PERKEMBANGAN',
        'KODE_PO_ITEM',
        'QTY_PERKEMBANGAN',
        'QTY_DISETUJUI',
        'TGL_REKAM',
        'PETUGAS_REKAM',
        'TGL_UBAH',
        'PETUGAS_UBAH',
    );

    public $dir = 'contract';
    
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>