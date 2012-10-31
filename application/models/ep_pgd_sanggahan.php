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
class Ep_pgd_sanggahan extends MY_Model
{
    public $table = "EP_PGD_SANGGAHAN";
    public $elements_conf = array(
        'KODE_SANGGAHAN',
        'KODE_TENDER' => array(
            'label' => 'NOMOR PENGADAAN',
            'type' => 'dropdown',
        ),
        'JUDUL',
        'ALASAN',
        'KETERANGAN_PENDUKUNG'=> array(
            'label' => 'BUKTI PENDUKUNG',
            'type' => 'textarea',
        ),
        'KETERANGAN_FILE',
        'MATA_UANG',
        'JUMLAH',
        'BANK',
        'NO_REFERENSI',
        'TANGGAL_MULAI',
        'TANGGAL_SELESAI',
//  'DISETUJUI_OLEH',
//  'STATUS',
//  'NO_JAWABAN',
//  'JUDUL_JAWABAN',
//  'ISI_JAWABAN',
//  'FILE_JAWABAN',
//  'TANGGAL_DIBUAT',
//  'TANGGAL_DITUTUP',
    );
    public $validation = array(
        'KODE_TENDER' => array('required' => true),
        'JUDUL' => array('required' => true),
        'ALASAN' => array('required' => true),
//        'KETERANGAN_PENDUKUNG' => array('required' => true),
//        'KETERANGAN_FILE' => array('required' => true),
        'MATA_UANG' => array('required' => true),
        'JUMLAH' => array('required' => true),
        'BANK' => array('required' => true),
        'NO_REFERENSI' => array('required' => true),
        'TANGGAL_MULAI' => array('required' => true),
        'TANGGAL_SELESAI' => array('required' => true),
        'JUMLAH' => array('required' => true),
    );

    //public $form_view = 'pengadaan/form_penawaran';

    function __construct()
    {
        parent::__construct();
        $this->init();

        // set default value here
        $CI = & get_instance();
        $this->attributes['KODE_VENDOR'] = $CI->session->userdata('user_id');
        
        // get selected value 
        $query = $this->db->query('SELECT KODE_TENDER, JUDUL_PEKERJAAN 
            FROM vw_ext_lelang_4_claim 
            WHERE KODE_VENDOR = ' . $this->attributes['KODE_VENDOR']);
        $rows = $query->result_array();
        
        $this->elements_conf['KODE_TENDER']['options'] = array();
        foreach ($rows as $v)
        {
            $this->elements_conf['KODE_TENDER']['options'][$v['KODE_TENDER']] = $v['JUDUL_PEKERJAAN'];
        }
    }

}
?>
