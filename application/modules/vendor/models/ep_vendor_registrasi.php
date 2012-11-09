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
class Ep_vendor_registrasi extends MY_Model {

    
    public $table = "EP_VENDOR";
    //public $table = "EP_NOMORURUT";
    
    public $elements_conf = array('KODE_VENDOR', 'KODE_LOGIN','PASSWORD','ALAMAT_EMAIL','AWALAN','AWALAN_LAIN','NAMA_VENDOR','AKHIRAN','AKHIRAN_LAIN');
    public $validation = array(
        'KODE_LOGIN' => array('required' => true),
        'PASSWORD' => array('required' => true),
        'AWALAN' => array('required' => true),
        'AWALAN_LAIN' => array('required' => true),
        'NAMA_VENDOR' => array('required' => true),
        'AKHIRAN' => array('required' => true),
        'AKHIRAN_LAIN' => array('required' => true),
        'ALAMAT_EMAIL' => array('required' => true),
    );
    public $sql_select = "(
        select KODE_VENDOR, NAMA_VENDOR, KODE_LOGIN, NAMA_STATUS_REG, '' as \"ACT\"
        from EP_VENDOR a
        left join EP_VENDOR_STATUS_REGISTRASI b on a.KODE_STATUS_REG = b.KODE_STATUS_REG 
        )";
    
    function __construct() {
        parent::__construct();
        $this->init();
        
        
    }
    
    protected function _before_insert()
    {
        print_r($this->attributes);
        die('x');
        // set default value here
        $query = $this->db->query("select max(NOMORURUT) + 1 as idx from ep_nomorurut where kode_nomorurut = 'VENDOR'");
        $row = $query->row();
        $this->attributes['KODE_VENDOR'] = $row->IDX;
        $this->attributes['TGL_REKAM'] = date("Y-m-d");
    }
    
    protected function _after_insert()
    {
        $this->db->query("update ep_nomorurut set NOMORURUT = NOMORURUT + 1 where kode_nomorurut = 'VENDOR'");
    }

}

?>
