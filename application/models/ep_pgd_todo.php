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
class Ep_pgd_todo extends MY_Model {
    
    public $table = "EP_PGD_TENDER";
    public $columns_conf = array('KODE_TENDER', 'JUDUL_PEKERJAAN', 'TGL_PEMBUKAAN_REG', 'TGL_PENUTUPAN_REG', 'BID_DATE', 'CURRENT_STATUS');
    public $sql_select = "(
        select *
        from vw_ext_todo )";
    
    public $grid_view = 'pengadaan/todo';
    
    function __construct() {
        parent::__construct();
        $this->init();
        
        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
    }

}

?>
