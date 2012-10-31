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
class Ep_pgd_item_penawaran extends MY_Model
{
    public $table = "EP_PGD_ITEM_PENAWARAN";
    public $elements_conf = array(
        'KODE_TENDER',
        'KODE_KANTOR',
        'KODE_VENDOR',
        'KODE_BARANG_JASA',
        'KODE_SUB_BARANG_JASA',
        'NAMA_BARANG_JASA',
        'KETERANGAN',
        'JUMLAH',
        'HARGA'
    );
    public $validation = array(
        'KETERANGAN' => array('required' => true),
        'JUMLAH' => array('required' => true),
        'HARGA' => array('required' => true),
    );
    public $form_view = 'pengadaan/form_item';

    function __construct()
    {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
        $this->attributes['KODE_TENDER'] = 1;

        $this->elements_conf['KETERANGAN']['value'] = array();
        $this->elements_conf['JUMLAH']['value'] = array();
        $this->elements_conf['HARGA']['value'] = array();
        $this->elements_conf['KETERANGAN']['options'] = array();
        $this->elements_conf['JUMLAH']['options'] = array();
        $this->elements_conf['HARGA']['options'] = array();

        // get existing value 
        $query = $this->db->query('
            SELECT 
              KODE_TENDER,
              KODE_KANTOR,
              KODE_VENDOR,              
              KODE_BARANG_JASA,
              KODE_SUB_BARANG_JASA,
              NAMA_BARANG_JASA,
              KETERANGAN,
              JUMLAH,
              HARGA
            FROM vw_ext_tender_item
            WHERE KODE_VENDOR = ' . $this->attributes['KODE_VENDOR'] . ' 
                AND KODE_TENDER = ' . $this->attributes['KODE_TENDER'] . ''
        );

        $rows = $query->result_array();
        $el = array();
        if (count($rows) > 0)
        {
            foreach ($rows as $v)
            {
                foreach($v as $key=>$val)
                {
                    $el[$key]['value'] = $val;
                }
            }
            
            $this->elements_conf = array();
            $this->elements_conf[] = $el;
        }
    }

    public function save()
    {
        // cek if record new
        if (count($this->primary_keys) == 0)
            show_error("Table doesn't have a primary key");

        // custom handler for save multiple rows at once
        $data = isset($_POST['EP_PGD_ITEM_PENAWARAN']) ? $_POST['EP_PGD_ITEM_PENAWARAN'] : NULL;
        if ($data)
        {
            foreach ($data as $k => $v)
            {
                $this->attributes = $v;
                
                // run before save
                $this->_before_save();

                $where = array();
                foreach ($this->primary_keys as $key)
                {
                    $where[$key] = $this->attributes[$key];
                }

                $this->db->where($where);

                $ret = null;
                if (!$this->db->count_all_results($this->table))
                    $ret = $this->_insert();
                else
                    $ret = $this->_update($where);

                $this->_after_save();
            }
        }



        return $ret;
    }
}
?>
