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
class contract extends MY_Controller
{
    public $rules;
    public $where;

    public function index() {
        $this->layout->view('todo');
    }
    
    public function createDraft(){
        
        if($this->_is_ajax_request())
            $this->load->view('contract/contract/draft');
        else
            $this->layout->view('contract/contract/draft');
    }
    
    public function updateProgress(){
        
        if($this->_is_ajax_request())
            $this->load->view('contract/contract/updateProgress');
        else
            $this->layout->view('contract/contract/updateProgress');
    }
    
    public function updateBASTP(){
        
        if($this->_is_ajax_request())
            $this->load->view('contract/contract/updateBASTP');
        else
            $this->layout->view('contract/contract/updateBASTP');
    }
    
    public function update_progress_validation()
    {
        $where = '1=1 ';
        $where .= isset($_REQUEST['KODE_JANGKA']) ? ' AND KODE_JANGKA = ' . $_REQUEST['KODE_JANGKA'] : '';
        $where .= isset($_REQUEST['KODE_KONTRAK']) ? ' AND KODE_KONTRAK = ' . $_REQUEST['KODE_KONTRAK'] : '';
        $where .= isset($_REQUEST['KODE_KANTOR']) ? ' AND KODE_KANTOR = ' . $_REQUEST['KODE_KANTOR'] : '';
        
        $sql = 'select sum(persentasi) as persentasi
                from ep_ktr_jangka_perkembangan where ' . $where;
        
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if($row['PERSENTASI'] != 100){
            $error['errors'][] = array('model' => 'Detail Progress', 'message' => 'TOTAL JUMLAH DETAIL PROGRESS YANG DIAJUKAN HARUS SAMA DENGAN 100');
            echo json_encode($error);
            exit();
        }
    }
    
}
?>
