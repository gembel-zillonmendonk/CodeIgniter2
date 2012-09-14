<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    
    var $obj;
    var $layout;
    
    function Layout($layout = "layout_main")
    {
        $this->obj =& get_instance();
        $this->layout = $layout;
		
		log_message('debug','BackendPro : Layout class loaded');
    }

    function setLayout($layout)
    {	
		$this->layout = $layout;
    }
    
    function view($view, $data=null, $return=false)
    {			
        $loadedData = array();
        //$loadedData['content_for_layout'] = $auth ? $this->obj->load->view($view,$data,true) : $this->obj->load->view('app_forbidden',$data,true);
		$loadedData['content_for_layout'] = $this->obj->load->view($view,$data,true);
		
        $this->_load_view($loadedData, false);        
    }
	
	function _load_view($loadedData, $return=false){
		//$template_dir = PUBPATH . '/' .$this->obj->session->userdata('themes');
		//$template_file = $template_dir .'layout_main.php';

		//$tmp_view_path = $this->obj->load->_ci_view_path;
		//if(file_exists($template_file)){			
			//$this->obj->load->_ci_view_path = $template_dir;
		//}
		
		if($return)
        {			
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        }
        else
        {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
		
		//$this->obj->load->_ci_view_path = $tmp_view_path;
	}
}
?>