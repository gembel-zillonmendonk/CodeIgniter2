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
class Ep_pgd_dokumen extends MY_Model
{
    public $table = "EP_PGD_DOKUMEN";
    public $columns_conf = array(
        'KETERANGAN',
        'NAMA_FILE',
    );

    public $sql_select = "(select * from EP_PGD_DOKUMEN )";
    //public $form_view = 'pengadaan/form_penawaran';

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>
