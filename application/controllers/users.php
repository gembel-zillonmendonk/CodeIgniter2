<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		/*
		$this->load->library('CI_phpgrid');
		$this->ci_phpgrid->example_method(3);
		$this->ci_phpgrid->display();
		*/
		
		$this->load->library('MY_DBTableModel', array('source'=>'USERS'));
		
		echo "<pre>";
		print_r($this->my_dbtablemodel);
		
		//$this->load->view('grid');
	}
	
	public function index_extJs()
	{
		/*
		$this->load->library('CI_phpgrid');
		$this->ci_phpgrid->example_method(3);
		$this->ci_phpgrid->display();
		*/
		$this->load->library('Layout');
		$this->load->library('MY_DBTableModel', array('source'=>'USERS'));
		
		//echo "<pre>";
		//print_r($this->my_dbtablemodel);
		
		$this->layout->view('extJs');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */