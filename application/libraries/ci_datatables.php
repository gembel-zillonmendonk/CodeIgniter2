<?php
require_once('phpgrid/conf.php');

		
class CI_datatables {
	const DB_HOSTNAME = 'xx';
	const DB_USERNAME = 'xx';
	const DB_PASSWORD = 'xx';
	const DB_NAME = 'xx';
	const DB_TYPE = 'xx';
	const DB_CHARSET = 'xx';
	
	public $lib_folder = 'DataTables-1.9.3/';
	
	private $cols;
	private $sql;
	private $query;
	
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
	
	public function render()
	{
		
	}
	
	public function fetch_json()
	{
	
	}
	
	public function build_queries()
	{
	
	}
	
	public function set_query()
	{
		if(isset($this->sql))
			$this->query = $this->CI->db->query($this->sql);
	}
	
	public function set_cols()
	{
		if(isset($this->query))
			$this->cols = $this->query->list_fields();
	}
	
	public function get_cols()
	{
		return $this->cols;
	}
}