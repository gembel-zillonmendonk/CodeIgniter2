<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crud
 *
 * @author farid
 */
class Ep_pgd_item_tender extends MY_Model
{
    public $table = "EP_PGD_ITEM_TENDER";
    public $columns_conf = array(
        'KETERANGAN',
        'JUMLAH',
        'UNIT',
        'HARGA',
    );

    public $sql_select = "(
        select KODE_TENDER, KODE_KANTOR, KODE_BARANG_JASA, KODE_SUB_BARANG_JASA, KETERANGAN, JUMLAH
        from EP_PGD_ITEM_TENDER
    )";
    //public $form_view = 'pengadaan/form_penawaran';

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>
