<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ep_vendor_wilayah extends MY_Model
{
    public $table = "EP_VENDOR_WILAYAH";
    public $elements_conf = array(
        'KODE_WILAYAH' => array('label'=>'WILAYAH', 'type' => 'dropdown', 'options' => null),
//        'NO_SMK',
//        'TGL_SMK',
//        'BERLAKU_SMK',
    );
    public $validation = array(
        //'NAMA_BARANG' => array('required' => true),
        'KODE_WILAYAH' => array('required' => true),
    );
    public $columns_conf = array(
        'KODE_WILAYAH',
        'WILAYAH',
    );
    public $sql_select = "(select KODE_WILAYAH, (case kode_wilayah
when 1 then 'JAKARTA'
when 2 then 'DEPOK'
when 3 then 'TANGERANG'
when 4 then 'BEKASI'
else 'BOGOR'
end)  \"WILAYAH\" from EP_VENDOR_WILAYAH)";

    function __construct()
    {
        parent::__construct();
        $this->init();

        // dropdown from table relation
        $this->elements_conf['KODE_WILAYAH']['options'] = array('1' => 'Kantor Pusat', '2' => 'Bogor', '3' => 'Bekasi');
        
        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
    }

    function _default_scope()
    {
        $CI = & get_instance();
        return ' KODE_VENDOR = '.$CI->session->userdata('user_id');
    }
}
?>
