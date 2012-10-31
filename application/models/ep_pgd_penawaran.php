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
class Ep_pgd_penawaran extends MY_Model {
    
    public $table = "EP_PGD_PENAWARAN";
    
    public $elements_conf = array(
        'NO_PENAWARAN', 
        'TIPE', 
        'BID_BOND',
        'LOCAL_CONTENT',
        'WAKTU_PENGIRIMAN',
        'UNIT',
        'BERLAKU_HINGGA',
        'LAMPIRAN',
        'KETERANGAN');
    
    public $validation = array(
        'NO_PENAWARAN' => array('required' => true),
        'TIPE' => array('required' => true),
        'BID_BOND' => array('required' => true),
        'LOCAL_CONTENT' => array('required' => true),
        'WAKTU_PENGIRIMAN' => array('required' => true),
        'UNIT' => array('required' => true),
        'BERLAKU_HINGGA' => array('required' => true),        
    );
    
    //public $form_view = 'pengadaan/form_penawaran';
    
    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>
