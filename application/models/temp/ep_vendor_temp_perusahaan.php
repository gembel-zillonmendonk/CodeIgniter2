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
class Ep_vendor_temp_perusahaan extends MY_Model
{
	public $dir = "temp";
    public $table = "EP_VENDOR_TEMP";
    //public $table = "EP_NOMORURUT";

    public $elements_conf = array(
        'AWALAN' => array(
            'type' => 'dropdown', 'options' => array(
                'PT' => 'PT',
                'CV' => 'CV',
                'LAINNYA' => 'LAINNYA',
        )),
        'AWALAN_LAIN',
        'NAMA_VENDOR',
        'AKHIRAN' => array(
            'type' => 'dropdown', 'options' => array(
                'TBK' => 'TBK',
                'GMBH' => 'GMBH',
                'NV' => 'NV',
                'BV' => 'BV',
                'BHD' => 'BHD',
                'PTE' => 'PTE',
                'LTD' => 'LTD',
                'LAINNYA' => 'LAINNYA',
        )),
        'AKHIRAN_LAIN',
        'VENDOR_TIPE' => array('type' => 'multiselect', 'options' => array(
                'GENERAL SUPPLIER' => 'GENERAL SUPPLIER',
                'DISTRIBUTOR' => 'DISTRIBUTOR',
                'MANUFACTURE' => 'MANUFACTURE',
                'SERVICE' => 'SERVICE',
                'KONSULTAN' => 'KONSULTAN',
                'GENERAL KONTRAKTOR' => 'GENERAL KONTRAKTOR',
        )),
        'ALAMAT_EMAIL',
    );
    public $validation = array(
        'AWALAN' => array('required' => true),
        'NAMA_VENDOR' => array('required' => true),
        'AKHIRAN' => array('required' => true),
        //'VENDOR_TIPE' => array('required' => true),
        'ALAMAT_EMAIL' => array('required' => true),
    );
    public $columns_conf = array('NAMA_VENDOR', 'KODE_LOGIN');
    public $sql_select = "(select KODE_VENDOR, NAMA_VENDOR, KODE_LOGIN, (1) as \"ad\" from EPROC.EP_VENDOR_TEMP)";
    public $form_view = 'vendor/form_perusahaan';
    /*
      public $columns = array(
      'KODE_VENDOR'=>array('name'=>'KODE VENDOR', 'raw_name'=>'KODE_VENDOR', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      'NAMA_VENDOR'=>array('name'=>'NAMA VENDOR', 'raw_name'=>'NAMA_VENDOR', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      'KODE_LOGIN'=>array('name'=>'KODE LOGIN', 'raw_name'=>'KODE_LOGIN', 'type' => 'text', 'size' => 255, 'allow_null' => false),
      );
     */

    function __construct()
    {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');

        $this->elements_conf['VENDOR_TIPE']['value'] = array('GENERAL SUPPLIER');
    }

    function _after_save()
    {
        parent::_after_save();

        if (isset($_POST['EP_VENDOR_TEMP_TIPE']['TIPE_VENDOR']) && count($_POST['EP_VENDOR_TEMP_TIPE']['TIPE_VENDOR']) > 0)
        {
            $this->db->delete('EP_VENDOR_TEMP_TIPE', array('KODE_VENDOR' => $this->attributes['KODE_VENDOR']));

            foreach ($_POST['EP_VENDOR_TEMP_TIPE']['TIPE_VENDOR'] as $v)
            {
                $data = array(
                    'KODE_VENDOR' => $this->attributes['KODE_VENDOR'],
                    'TIPE_VENDOR' => $v,
                    'TGL_REKAM' => date("Y-m-d"),
                    'PETUGAS_REKAM' => $this->session->userdata('user_id'),
                );

                $this->db->insert('EP_VENDOR_TEMP_TIPE', $data);
            }
        }
    }

}
?>
