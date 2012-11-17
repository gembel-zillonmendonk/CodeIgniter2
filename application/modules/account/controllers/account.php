<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends MX_Controller
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
                array('model' => 'vendor/ep_vendor_perusahaan', 'label' => 'NAMA PERUSAHAAN', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_alamat', 'label' => 'KONTAK PERUSAHAAN', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_kontak_person', 'label' => 'KONTAK PERSON', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_jamsostek', 'label' => 'KEPESERTAAN JAMSOSTEK', 'rules' => 'required', 'where' => $this->where),
            ),
            '1' => array(// tabs-2
                array('model' => 'vendor/ep_vendor_akta', 'label' => 'AKTA PENDIRIAN', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_domisili', 'label' => 'DOMISILI PERUSAHAAN', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_npwp', 'label' => 'NPWP', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_mitra', 'label' => 'JENIS MITRA KERJA', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_siup', 'label' => 'SIUP', 'rules' => 'hasOne', 'where' => $this->where),
                //array('model' => 'vendor/ep_vendor_ijin', 'label' => 'IJIN LAIN-LAIN (OPSIONAL)', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_tdp', 'label' => 'TDP', 'rules' => 'required', 'where' => $this->where),
            //array('model' => 'vendor/ep_vendor_agen', 'label' => 'SURAT KEAGENAN/DISTRIBUTORSHIP (OPSIONAL)', 'rules' => 'hasOne', 'where' => $this->where . " AND TIPE = 'AGEN'"),
            //array('model' => 'vendor/ep_vendor_importir', 'label' => 'ANGKA PENGENAL IMPORTIR (OPSIONAL)', 'rules' => 'hasOne', 'where' => $this->where . " AND TIPE = 'IMPORTIR'"),
            ),
            '2' => array(// tabs-3
                array('model' => 'vendor/ep_vendor_komisaris', 'label' => 'DEWAN KOMISARIS', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_direksi', 'label' => 'DEWAN DIREKSI', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '3' => array(// tabs-4
                array('model' => 'vendor/ep_vendor_bank', 'label' => 'REKENING BANK', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_modal', 'label' => 'MODAL SESUAI DENGAN AKTA TERAKHIR', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_laporan_keuangan', 'label' => 'INFORMASI LAPORAN KEUANGAN', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_klasifikasi', 'label' => 'KLASIFIKASI PERUSAHAAN', 'rules' => 'required', 'where' => $this->where),
            ),
            '4' => array(// tabs-5
                array('model' => 'vendor/ep_vendor_barang', 'label' => 'BARANG YANG BISA DIPASOK', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_jasa', 'label' => 'JASA YANG BISA DIPASOK', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '5' => array(// tabs-6
                array('model' => 'vendor/ep_vendor_tenaga_utama', 'label' => 'TENAGA AHLI UTAMA', 'rules' => 'hasOne', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_tenaga_pendukung', 'label' => 'TENAGA AHLI PENDUKUNG', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '6' => array(// tabs-7
                array('model' => 'vendor/ep_vendor_sertifikat', 'label' => 'KETERANGAN SERTIFIKAT', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '7' => array(// tabs-8
                array('model' => 'vendor/ep_vendor_peralatan', 'label' => 'KETERANGAN TENTANG FASILITAS / PERALATAN', 'rules' => 'hasOne', 'where' => $this->where),
            ),
            '9' => array(// tabs-10
                array('model' => 'vendor/ep_vendor_principal', 'label' => 'PRINCIPAL', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_subkontraktor', 'label' => 'SUBKONTRAKTOR', 'rules' => 'required', 'where' => $this->where),
                array('model' => 'vendor/ep_vendor_afiliasi', 'label' => 'PERUSAHAAN AFILIASI', 'rules' => 'required', 'where' => $this->where),
            ),
        );
    }
    
    public function login()
    {
        if (count($_POST) > 0)
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $query = $this->db->query("select KODE_VENDOR, KODE_LOGIN, PASSWRD from EP_VENDOR where KODE_LOGIN = '$username'");
            $row = $query->row();

            if(count($row) > 0 && $row->PASSWRD == md5($password))
            {
                $this->session->set_userdata('user_id', $row->KODE_VENDOR);
                $this->session->set_userdata('username', $row->KODE_LOGIN);

                redirect('welcome/index');
            }
        }


        $this->load->view('account/layout_login');
    }

    public function registration()
    {
        if (count($_POST) > 0)
        {
            try
            {
                $query = $this->db->query("select max(NOMORURUT) + 1 as idx from ep_nomorurut where kode_nomorurut = 'VENDOR'");
                $row = $query->row();
                $_POST['EP_VENDOR']['KODE_VENDOR'] = $row->IDX;
                $_POST['EP_VENDOR']['PASSWRD'] = md5($_POST['EP_VENDOR']['PASSWRD']);
                $this->db->insert('EP_VENDOR', $_POST['EP_VENDOR']);
                $this->db->query("update ep_nomorurut set NOMORURUT = NOMORURUT + 1 where kode_nomorurut = 'VENDOR'");
            }
            catch(Exception $e)
            {
                print($e);
            }
        }
        
        $this->load->view('account/layout_registration');
    }

    public function complete_registration()
    {
        $query = $this->db->query('SELECT coalesce(HALAMAN_SELANJUTNYA, \'0\') as HALAMAN_SELANJUTNYA FROM EP_VENDOR WHERE KODE_VENDOR = ' . $this->session->userdata('user_id'));
        $data = $query->row_array();
        $ap = $data['HALAMAN_SELANJUTNYA'];

        $cnt = 9; // count all tabs
        $str = array();

        $np = $ap;
        if($ap <= $cnt){
            while ($ap <= $cnt)
            {
                $str[] = ++$ap;
            }
        }
        
        $str = '[' . implode(',', $str) . ']';

        if ($this->_is_ajax_request())
        {
            if (isset($this->rules[$data['HALAMAN_SELANJUTNYA']]) && $return = $this->xvalidation($this->rules[$data['HALAMAN_SELANJUTNYA']]))
            {
                echo json_encode($return);
                exit();
            }
            else
            {
                if($np < $cnt)
                    $this->db->query('UPDATE EP_VENDOR set HALAMAN_SELANJUTNYA = coalesce(HALAMAN_SELANJUTNYA, \'0\') + 1 WHERE KODE_VENDOR = ' . $this->session->userdata('user_id'));
                
                echo json_encode(array(
                    'active_tabs' => $np + 1,
                    'disable_tabs' => $str
                ));
                exit();
            }
        }


        $this->layout->setLayout('layout_nomenu');
        $this->layout->view('complete_registration', array(
            'active_tabs' => $np,
            'disable_tabs' => $str
        ));
    }
    
    public function resetpassword()
    {
        $this->layout->view('account/resetpassword');
    }
    
    public function changepassword()
    {
        $this->layout->view('account/changepassword');
    }
    
    public function logout()
    {
        unset($_SESSION);
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
        redirect('account/login');
    }
    
    public function activation()
    {
        foreach ($this->rules as $k => $v)
        {
            if ($return = $this->xvalidation($v))
            {
                echo json_encode($return);
                exit();
            }
        }
    }

    public function xvalidation($rules = array())
    {
        if (count($rules) == 0)
            return false;

        $ret = array('errors' => array());
        foreach ($rules as $v)
        {
            if (!isset($v['rules']))
                return false;

//$obj = $this->_load_model($v['model']);
            $this->load->model($v['model'], $v['model']);
            $obj = $this->$v['model'];
            
//echo $obj->table.'<br>';
//print_r($obj);
            if (!$obj)
                continue;


            $err = false;
            if ($v['rules'] == 'required')
            {
                $fields = implode(',', array_keys($obj->validation, array('required' => true)));
                $this->where = '( ' . implode(' IS NULL OR ', array_keys($obj->validation, array('required' => true))) . ' IS NULL )';

                $this->where .= ' AND ' . $v['where'];
                $this->db->select($fields);
                $this->db->where($this->where);
                $this->db->from($obj->table);

                $err = $this->db->count_all_results() > 0 ? true : false;
            }
            else
            {
                $this->db->where($v['where']);
                $this->db->from($obj->table);

                $err = $this->db->count_all_results() > 0 ? false : true;
            }
//echo $this->db->last_query()."\n";
            if ($err)
            {
                $ret['errors'][] = array('model' => get_class($obj), 'message' => $v['label'] . ' tidak boleh kosong');
            }
        }

        if (count($ret['errors']) > 0)
        {
//$this->session->set_flashdata($ret);
            return $ret;
        }

        return false;
    }
    
    public function _is_ajax_request()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */