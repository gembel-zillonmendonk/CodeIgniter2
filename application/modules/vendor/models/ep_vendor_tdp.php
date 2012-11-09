<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_tdp extends MY_Model
{
    public $table = "EP_VENDOR";
    public $elements_conf = array(
        'TDP_ISSUED_BY',
        'NO_TDP' => array('type' => 'number'),
        'DARI_TGL_TDP',
        'SAMPAI_TGL_TDP',
    );
    public $validation = array(
        'TDP_ISSUED_BY' => array('required' => true),
        'NO_TDP' => array('required' => true),
        'DARI_TGL_TDP' => array('required' => true),
        'SAMPAI_TGL_TDP' => array('required' => true),
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
        
        // set default value here
        $CI =& get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
    }

    protected function _before_save()
    {
        parent::_before_save();        
        
//        $this->db->set("\"DARI_TGL_TDP\"", "TO_DATE('".$this->attributes['DARI_TGL_TDP']."','YYYY-MM-DD')", FALSE);
//        $this->db->set("\"SAMPAI_TGL_TDP\"", "TO_DATE('".$this->attributes['SAMPAI_TGL_TDP']."','YYYY-MM-DD')", FALSE);
//        unset($this->attributes['DARI_TGL_TDP'], $this->attributes['SAMPAI_TGL_TDP']);
    }
    
    protected function _before_update()
    {
        parent::_before_update();        
    }
}
?>
