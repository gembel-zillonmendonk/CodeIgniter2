<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_tdp extends MY_Model
{
    public $table = "EP_VENDOR";
    public $elements_conf = array(
        'TDP_ISSUED_BY' => array('type' => 'text', 'value' => 'xxx'),
        'NO_TDP' => array('type' => 'number'),
        'DARI_TGL_TDP' => array('type' => 'date'),
        'SAMPAIO_TGL_TDP' => array('type' => 'date'),
    );
    public $validation = array(
        'TDP_ISSUED_BY' => array('required' => true),
        'NO_TDP' => array('required' => true),
        'DARI_TGL_TDP' => array('required' => true),
        'SAMPAIO_TGL_TDP' => array('required' => true),
    );
    public $columns_conf = array(
        'TDP_ISSUED_BY',
        'NO_TDP',
        'DARI_TGL_TDP',
        'SAMPAI_TGL_TDP',
    );
    //public $sql_select = "(select * from EP_VENDOR)";
    

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

}
?>
