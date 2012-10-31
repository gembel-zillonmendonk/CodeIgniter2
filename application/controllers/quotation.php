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
class quotation extends CI_Controller {

    public $rules;
    public $where;

    public function __construct() {
        parent::__construct();
        $this->session->set_userdata('user_id', '512');
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

    public function grid() {
        $query = $this->db->query('SELECT * FROM vw_ext_todo WHERE KODE_VENDOR = ' . $this->session->userdata('user_id'));

        $gopts = array(
            'page' => (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1),
            'rows' => (isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15),
        );

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 15;
        $filter = null;
        if (isset($_REQUEST['filters'])) {
            //$this->load->library('jqGrid', null, 'jq');
            $filter = $model->buildSearch($_REQUEST['filters']);
        }

        $filter = strlen($filter) > 0 ? $filter : null;
        //$query = $this->db->get('USERS', 10, $page);



        $src = $model->table;
        preg_match("/select/", $model->sql_select, $matches);
        if (count($matches) > 0) {
            $src = $model->sql_select;
            $read_only = true;
        }

        $this->db->start_cache();
        $this->db->from($src, true);
        if ($filter !== null)
            $this->db->where($filter);
        $this->db->stop_cache();

        $count = $this->db->count_all_results();
        $count > 0 ? $total_pages = ceil($count / $rows) : $total_pages = 0;
        if ($page > $total_pages)
            $page = $total_pages;

        // build data
        $this->db->limit($rows, $page);
        $query = $this->db->get();
        $return = array(
            "records" => $count,
            "page" => $page,
            "total" => $total_pages,
            "rows" => $query->result_array,
        );

        $this->db->flush_cache();
        
        if ($this->_is_ajax_request()) {
            if (isset($_REQUEST['oper'])) {
                echo json_encode($query);
                exit();
            } else {

                $this->load->view('Crud/grid', array(
                    'grid' => new MY_Grid($model),
                ));
            }
        } else {
            $this->layout->view('Crud/grid', array(
                'grid' => new MY_Grid($model),
            ));
        }
    }

    public function view() {
        $this->layout->view('vendor/view');
    }

    public function update() {
        $is_success = '';
        $kode_vendor = $this->session->userdata('user_id');
        $param = array(
            array('name' => ':p1', 'value' => $kode_vendor, 'length' => -1, 'type' => SQLT_INT),
//           array('name'=>':a2', 'value'=>&$is_success),
        );
        $this->db->stored_procedure('EPROC', 'PROC_EP_VENDOR_COPY_TO_TEMP', $param);

        $this->db->query("
            begin 
            EPROC.PROC_EP_VENDOR_COPY_TO_TEMP( " . $this->session->userdata('user_id') . "); 
            end;", FALSE, FALSE);
        $this->layout->view('vendor/update');
    }

    public function createOrEdit() {
        $this->layout->view('vendor/createOrEdit');
    }

    public function activation() {
        foreach ($this->rules as $k => $v) {
            if ($return = $this->xvalidation($v)) {
                echo json_encode($return);
                exit();
            }
        }
    }

    public function xvalidation($rules = array()) {
        if (count($rules) == 0)
            return false;

        $ret = array('errors' => array());
        foreach ($rules as $v) {
            if (!isset($v['rules']))
                return false;

//$obj = $this->_load_model($v['model']);
            $this->load->model($v['model']);
            $obj = $this->$v['model'];
//echo $obj->table.'<br>';
//print_r($obj);
            if (!$obj)
                continue;


            $err = false;
            if ($v['rules'] == 'required') {
                $fields = implode(',', array_keys($obj->validation, array('required' => true)));
                $this->where = '( ' . implode(' IS NULL OR ', array_keys($obj->validation, array('required' => true))) . ' IS NULL )';

                $this->where .= ' AND ' . $v['where'];
                $this->db->select($fields);
                $this->db->where($this->where);
                $this->db->from($obj->table);

                $err = $this->db->count_all_results() > 0 ? true : false;
            } else {
                $this->db->where($v['where']);
                $this->db->from($obj->table);

                $err = $this->db->count_all_results() > 0 ? false : true;
            }
//echo $this->db->last_query()."\n";
            if ($err) {
                $ret['errors'][] = array('model' => get_class($obj), 'message' => $v['label'] . ' tidak boleh kosong');
            }
        }

        if (count($ret['errors']) > 0) {
//$this->session->set_flashdata($ret);
            return $ret;
        }

        return false;
    }

}

?>
