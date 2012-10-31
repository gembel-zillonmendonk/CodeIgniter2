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
class Ep_pgd_penawaran_teknis extends MY_Model {
    
    public $table = "EP_PGD_PENAWARAN_TEKNIS";
    
    public $elements_conf = array(
        'KETERANGAN_VENDOR', 
        );
    
    public $validation = array(
        'KETERANGAN_VENDOR' => array('required' => true),   
    );
    
    public $form_view = 'pengadaan/form_teknis';
    
    function __construct()
    {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
        $this->attributes['KODE_TENDER'] = 1;

        // get existing value 
        $query = $this->db->query('
            SELECT 
              KODE_TENDER,
              KODE_KANTOR,
              KODE_VENDOR,
              KETERANGAN,
              BERAT ,
              STATUS_CEK,
              VENDOR_CEK,
              NILAI,
              KETERANGAN_VENDOR
            FROM EP_PGD_PENAWARAN_TEKNIS 
            WHERE KODE_VENDOR = ' . $this->attributes['KODE_VENDOR'] . ' 
                AND KODE_TENDER = ' . $this->attributes['KODE_TENDER'] . ' AND COALESCE(BERAT, 0) <> 0'
        );

        $rows = $query->result_array();
        if (count($rows) > 0)
        {
            $this->elements_conf['KETERANGAN_VENDOR']['value'] = array();
            foreach ($rows as $v)
            {
                $this->elements_conf['KETERANGAN_VENDOR']['options'][] = $v;
                $this->elements_conf['KETERANGAN_VENDOR']['value'][] = $v['KETERANGAN_VENDOR'];
            }
        }
        else
        {
            // get options
            /*
              $query = $this->db->query('
              INSERT INTO EP_PGD_PENAWARAN_TEKNIS (KODE_TENDER,KODE_KANTOR,KODE_VENDOR,KETERANGAN,BERAT,STATUS_CEK,VENDOR_CEK,NILAI,KETERANGAN_VENDOR)
              SELECT KODE_TENDER, KODE_KANTOR, '.$this->attributes['KODE_VENDOR'].',
              KETERANGAN          ,
              BOBOT               ,
              0 as STATUS_CEK          ,
              0 as VENDOR_CEK          ,
              0 as NILAI               ,
              \'\' as KETERANGAN_VENDOR
              FROM vw_ext_quotation_eval
              WHERE KODE_TENDER = ' . $this->attributes['KODE_TENDER'] .'
              AND COALESCE(BOBOT, 0) = 0'
              );
             */
            $query = $this->db->query('
                SELECT KODE_TENDER, KODE_KANTOR, ' . $this->attributes['KODE_VENDOR'] . ' as KODE_VENDOR,
                    KETERANGAN          , 
                    BOBOT as BERAT              , 
                    0 as STATUS_CEK          ,
                    0 as VENDOR_CEK          ,
                    0 as NILAI               ,
                    \'\' as KETERANGAN_VENDOR   
                FROM vw_ext_quotation_eval 
                WHERE KODE_TENDER = ' . $this->attributes['KODE_TENDER'] . '
                    AND COALESCE(BOBOT, 0) <> 0'
            );
            $rows = $query->result_array();

            $this->elements_conf['KETERANGAN_VENDOR']['options'] = array();
            foreach ($rows as $v)
            {
                $this->elements_conf['KETERANGAN_VENDOR']['options'][] = $v;
            }
        }
    }

    public function save()
    {
        // cek if record new
        if (count($this->primary_keys) == 0)
            show_error("Table doesn't have a primary key");

        // custom handler for save multiple rows at once
        $data = isset($_POST['EP_PGD_PENAWARAN_TEKNIS']) ? $_POST['EP_PGD_PENAWARAN_TEKNIS'] : NULL;
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
