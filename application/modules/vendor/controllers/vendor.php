<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vendor
 *
 * @author farid
 */
class vendor extends MY_Controller
{
    public $rules;
    public $where;

    public function __construct()
    {
        parent::__construct();
        //$this->session->set_userdata('user_id', '512');
        //$this->session->set_userdata('user_id', '7827400');

        $this->where = 'KODE_VENDOR = ' . $this->session->userdata('user_id');
        $this->rules = array(
            '0' => array(// tabs-1
                array('model' => 'ep_vendor_perusahaan', 'label' => 'NAMA PERUSAHAAN', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'ep_vendor_alamat', 'label' => 'KONTAK PERUSAHAAN', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_kontak_person', 'label' => 'KONTAK PERSON', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'ep_vendor_jamsostek', 'label' => 'KEPESERTAAN JAMSOSTEK', 'rules' => 'required', 'where' => $this->where),
            ),
            '1' => array(// tabs-2
                array('model' => 'ep_vendor_akta', 'label' => 'AKTA PENDIRIAN', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_domisili', 'label' => 'DOMISILI PERUSAHAAN', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'ep_vendor_npwp', 'label' => 'NPWP', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_mitra', 'label' => 'JENIS MITRA KERJA', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'ep_vendor_siup', 'label' => 'SIUP', 'rules' => 'hasOne', 'where' => $this->where),
                //array('model' => 'ep_vendor_ijin', 'label' => 'IJIN LAIN-LAIN (OPSIONAL)', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_tdp', 'label' => 'TDP', 'rules' => 'required', 'where' => $this->where),
            //array('model' => 'ep_vendor_agen', 'label' => 'SURAT KEAGENAN/DISTRIBUTORSHIP (OPSIONAL)', 'rules' => 'hasOne', 'where' => $this->where . " AND TIPE = 'AGEN'"),
            //array('model' => 'ep_vendor_importir', 'label' => 'ANGKA PENGENAL IMPORTIR (OPSIONAL)', 'rules' => 'hasOne', 'where' => $this->where . " AND TIPE = 'IMPORTIR'"),
            ),
            '2' => array(// tabs-3
                array('model' => 'ep_vendor_komisaris', 'label' => 'DEWAN KOMISARIS', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_direksi', 'label' => 'DEWAN DIREKSI', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '3' => array(// tabs-4
                array('model' => 'ep_vendor_bank', 'label' => 'REKENING BANK', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_modal', 'label' => 'MODAL SESUAI DENGAN AKTA TERAKHIR', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'ep_vendor_laporan_keuangan', 'label' => 'INFORMASI LAPORAN KEUANGAN', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_klasifikasi', 'label' => 'KLASIFIKASI PERUSAHAAN', 'rules' => 'required', 'where' => $this->where),
            ),
            '4' => array(// tabs-5
                array('model' => 'ep_vendor_barang', 'label' => 'BARANG YANG BISA DIPASOK', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_jasa', 'label' => 'JASA YANG BISA DIPASOK', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '5' => array(// tabs-6
                array('model' => 'ep_vendor_tenaga_utama', 'label' => 'TENAGA AHLI UTAMA', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'ep_vendor_tenaga_pendukung', 'label' => 'TENAGA AHLI PENDUKUNG', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '6' => array(// tabs-7
                array('model' => 'ep_vendor_sertifikat', 'label' => 'KETERANGAN SERTIFIKAT', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '7' => array(// tabs-8
                array('model' => 'ep_vendor_peralatan', 'label' => 'KETERANGAN TENTANG FASILITAS / PERALATAN', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '9' => array(// tabs-10
                array('model' => 'ep_vendor_principal', 'label' => 'PRINCIPAL', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'ep_vendor_subkontraktor', 'label' => 'SUBKONTRAKTOR', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'ep_vendor_afiliasi', 'label' => 'PERUSAHAAN AFILIASI', 'rules' => 'required', 'where' => $this->where),
            ),
        );
    }

    public function view()
    {
        $this->layout->view('vendor/view');
    }
    
    public function update()
    {
        $is_success=''; 
        $kode_vendor=$this->session->userdata('user_id');
        $param = array(
           array('name'=>':p1', 'value'=>$kode_vendor, 'length' => -1, 'type'=>SQLT_INT ),
//           array('name'=>':a2', 'value'=>&$is_success),
        );   
        $this->db->stored_procedure('EPROC','PROC_EP_VENDOR_COPY_TO_TEMP',$param); 
        
        $this->db->query("
            begin 
            EPROC.PROC_EP_VENDOR_COPY_TO_TEMP( ".$this->session->userdata('user_id')."); 
            end;", FALSE, FALSE);
        $this->layout->view('vendor/update');
    }
    
    public function create_or_edit()
    {
        if(isset($_REQUEST['KODE_VENDOR']))
            $this->session->set_userdata('user_id', $_REQUEST['KODE_VENDOR']);
        
        if($this->_is_ajax_request())
            $this->load->view('vendor/create_or_edit');
        else
            $this->layout->view('vendor/create_or_edit');
    }

    
    /*
     * internal actions
     */
    
    public function todo()
    {
        $this->layout->view('vendor/todo');
    }
    
    public function checklist_doc()
    {
        if(isset($_REQUEST['KODE_VENDOR']))
            $this->session->set_userdata('user_id', $_REQUEST['KODE_VENDOR']);
        
        $this->session->set_userdata();
        
        if($this->_is_ajax_request())
            $this->load->view('vendor/checklist_doc');
        else
            $this->layout->view('vendor/checklist_doc');
    }
    
    public function activation()
    {
        if(isset($_POST))
        {
            redirect('vendor/todo');
        }
        $this->layout->view('vendor/activation');
    }
    
    
    // for internal & external actions
    
    public function view_data_vendor()
    {
        if(isset($_REQUEST['KODE_VENDOR']))
            $this->session->set_userdata('user_id', $_REQUEST['KODE_VENDOR']);
        
        if($this->_is_ajax_request())
            $this->load->view('vendor/view_data_vendor');
        else
            $this->layout->view('vendor/view_data_vendor');
    }
    
    public function _view()
    {
        $this->load->view('vendor/_view');
    }
    
    public function _editor()
    {
        $this->load->view('vendor/_editor');
    }
    
    public function start_wkf_registration()
    {
        
    }
}
?>
