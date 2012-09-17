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
class MY_Model extends CI_Model {

    public $columns;
    private $_columns_params = array(
        'sort_type' => 'x',
        'index' => '',
        'name' => '',
        'label' => '',
        'db_type' => '',
        'type' => '',
        'options' => null,
        'default_value' => '',
        'size' => 0,
        'precision' => 0,
        'scale' => 0,
        'allow_null' => false,
        'is_primary_key' => false,
        'is_foreign_key' => false,
        'is_searchable' => false,
        'is_readonly' => false,
        'auto_increment' => false,
        'rules' => array(),
        'key' => 0,
    );
    public $meta_columns;
    public $table; // must be initialize by override class
    public $sql_select;
    public $primary_keys;
    public $foreign_keys;
    public $show_columns;

    public $attributes;
    
    public function __construct() {
        parent::__construct();
    }

    public function init() {

        if ($this->table === null)
            show_error("Table cannot be null");

        // load library adodbx
        //$this->load->library('ci_adodb');
        //$CI = & get_instance();
        //$this->primary_keys = $CI->adodb->MetaPrimaryKeys($this->table);
        //$this->foreign_keys = $CI->adodb->MetaForeignKeys($this->table);

        //$this->primary_keys = $this->db->list_columns($this->table);
        $this->foreign_keys = $this->db->list_constraints($this->table);

        $this->meta_columns = $this->db->list_columns($this->table);
        $intial_columns = (count($this->show_columns) > 0) ? true : false;
        
        foreach ($this->meta_columns as $k => $v) {

            // set primary keys 
            if ($v['key'] == 'P')
                $this->primary_keys[] = $k;

            //$CI->load->library('MY_DBColumnModel', (array) $v, $k);
            //$v['is_primary_key'] = $this->is_primary_key($v['raw_name);
            //$v['is_foreign_key'] = $this->is_foreign_key($v['raw_name);
            //if (!$intial_columns) {

            $this->meta_columns[$k]['index'] = $v['name'];
            $this->meta_columns[$k]['sort_type'] = $this->extract_type($v['db_type']);
            
            $this->meta_columns[$k]['label'] = $this->extract_label($v['name']);
            $this->meta_columns[$k]['type'] = $this->extract_type($v['db_type']);
            $this->meta_columns[$k]['is_primary_key'] = ($v['key'] == 'P') ? 1 : 0;
            $this->meta_columns[$k]['is_foreign_key'] = ($v['key'] == 'R') ? 1 : 0;
            $this->meta_columns[$k]['key'] = ($v['key'] == 'P') ? 1 : 0;
            $this->meta_columns[$k]['is_searchable'] = true;
            $this->meta_columns[$k]['is_readonly'] = false;
            $this->meta_columns[$k]['auto_increment'] = false;
            $this->meta_columns[$k]['rules'] = array();

            //}
        }

        // override default column properties
        if ($intial_columns)
            foreach ($this->show_columns as $column) {
                foreach ($this->_columns_params as $attr => $attr_val) {
                    $this->set_column_param($column, $attr, isset($this->meta_columns[$column][$attr]) ? $this->meta_columns[$column][$attr] : $attr_val);
                }
            }
        else
            $this->columns = $this->meta_columns;
        
        // set default select query for grid
        if(! isset($this->sql_select)) $this->sql_select = $this->table;
    }

    public function is_primary_key($column) {
        return array_search($column, $this->primary_keys);
    }

    public function is_foreign_key($column) {
        if (!is_array($this->foreign_keys))
            return false;
        return array_search($column, $this->foreign_keys);
    }

    private function set_column_param($column, $attr, $val) {
        if (isset($this->columns[$column][$attr]))
            return;
        $this->columns[$column][$attr] = $val;
    }

    public function save($attributes)
    {
        // cek if record new
        if(count($this->primary_keys) == 0)
            show_error ("Table doesn't have a primary key");
        
        $where = array();
        foreach ($this->primary_keys as $key) {
            $where[$key] = $attributes[$key];
        }

        $this->db->where($where);
        $is_new = ($this->db->count_all_results($this->table) > 0 ? false : true);
        
        if($is_new)
            return $this->_insert($attributes);
        else
            return $this->_update($attributes, $where);
    }
    
    public function delete()
    {
        
    }
    
    public function is_new_record()
    {
        
    }
    
    public function typecast($value) {
        if (gettype($value) === $this->type || $value === null || $value instanceof CDbExpression)
            return $value;
        if ($value === '' && $this->allow_null)
            return $this->type === 'string' ? '' : null;
        switch ($this->type) {
            case 'string': return (string) $value;
            case 'integer': return (integer) $value;
            case 'boolean': return (boolean) $value;
            case 'double':
            default: return $value;
        }
    }

    protected function _insert($attributes) {
        return $this->db->insert($this->table, $attributes);
    }
    
    protected function _update($attributes, $where) {
        $this->db->update($this->table, $attributes, $where);
    }
    
    protected function _delete() {
        
    }
    
    protected function extractOraType($dbType) {
        if (strpos($dbType, 'FLOAT') !== false)
            return 'NUMBER';

        if (strpos($dbType, 'NUMBER') !== false || strpos($dbType, 'INTEGER') !== false || strpos($dbType, 'INT') !== false) {
            if (strpos($dbType, '(') && preg_match('/\((.*)\)/', $dbType, $matches)) {
                $values = explode(',', $matches[1]);
                if (isset($values[1]) and (((int) $values[1]) > 0))
                    return 'number';
                else
                    return 'number';
            }
            else
                return 'number';
        } else if (strpos($dbType, 'DATE') !== false) {
            return 'date';
        }
        else
            return 'text';
    }

    protected function extract_type($dbType) {
        return $this->extractOraType($dbType);
    }

    protected function extract_label($name) {
        return str_replace('_', ' ', $name);
    }

}

?>
