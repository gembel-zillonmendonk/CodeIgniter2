<?php
require_once('phpgrid/conf.php');

		
class CI_phpgrid extends C_DataGrid{
	const DB_HOSTNAME = 'xx';
	const DB_USERNAME = 'xx';
	const DB_PASSWORD = 'xx';
	const DB_NAME = 'xx';
	const DB_TYPE = 'xx';
	const DB_CHARSET = 'xx';
	
	public function CI_phpgrid() {
		$this->CI =& get_instance();
		//$this->CI->load->library('Users');
		echo "<pre>";
		print_r($this);
	}
	
    public function example_method($val = '')
    {
        $dg = new C_DataGrid("SELECT * FROM user", $val, "user");
        return $dg;
    }
}