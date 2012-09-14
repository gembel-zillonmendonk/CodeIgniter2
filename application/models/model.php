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
class Model extends CI_Model {

    public $columns;
    public $meta_columns;
    public $table;
    public $primary_keys;
    public $foreign_keys;

    function __construct($table = null) {
        parent::__construct();

        if ($table !== null)
            $this->table = $table;

        // load library adodbx
        $this->load->library('ci_adodb');
        $this->init();
    }

    public static function load($table) {
        $this->load->library('ci_adodb');
        $this->init();
    }

    function init() {
        $CI = & get_instance();
        $this->meta_columns = $CI->adodb->MetaColumns($this->table);
        $this->primary_keys = $CI->adodb->MetaPrimaryKeys($this->table);
        $this->foreign_keys = $CI->adodb->MetaForeignKeys($this->table);
        
        foreach($this->meta_columns as $k=>$v){
            $CI->load->library('MY_DBColumnModel', (array)$v, $k);
            $this->columns[$k] = $this->$k;
        }
    }

    function is_primary_key($column) {
        return array_search($column, $this->primary_keys);
    }
    
    function is_foreign_key($column) {
        return array_search($column, $this->foreign_keys);
    }
}

?>
