<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_DBTableSchema {

    /**
     * @var string name of this table.
     */
    public $name;

    /**
     * @var string raw name of this table. This is the quoted version of table name with optional schema name. It can be directly used in SQLs.
     */
    public $rawName;

    /**
     * @var string|array primary key name of this table. If composite key, an array of key names is returned.
     */
    public $primaryKey;

    /**
     * @var string sequence name for the primary key. Null if no sequence.
     */
    public $sequenceName;

    /**
     * @var array foreign keys of this table. The array is indexed by column name. Each value is an array of foreign table name and foreign column name.
     */
    public $foreignKeys = array();

    /**
     * @var array column metadata of this table. Each array element is a CDbColumnSchema object, indexed by column names.
     */
    public $columns = array();

    /**
     * @var string name of the schema (database) that this table belongs to.
     * Defaults to null, meaning no schema (or the current database).
     */
    public $schemaName;

    /**
     * Gets the named column metadata.
     * This is a convenient method for retrieving a named column even if it does not exist.
     * @param string $name column name
     * @return CDbColumnSchema metadata of the named column. Null if the named column does not exist.
     */
    public function getColumn($name) {
        return isset($this->columns[$name]) ? $this->columns[$name] : null;
    }

    /**
     * @return array list of column names
     */
    public function getColumnNames() {
        return array_keys($this->columns);
    }

}

/*
class My_DBTableModel {

    public $name;
    public $label;
    public $attributes;
    public $query;
    public $schema;
    private $db;
    private $_read_only = false;

    function __construct($params = array()) {
        $CI = & get_instance();
        $this->db = & $CI->db;
        if (isset($params['source']) && $params['source'] !== null) {
            preg_match("/select/", $this->model, $matches);
            if (count($matches) > 0) {
                //$query = $this->CI->db->query($params['source']); 
                //$params['source'] = "SELECT * FROM (".$params['source'].") inner_query WHERE rownum < 1";
                $this->schema = $this->db->query($params['source']);
                $this->_read_only = true;
            } else {
                $this->schema = $this->db->get($params['source']);
            }

            if ($this->schema->stmt_id !== null) {
                for ($c = 1, $fieldCount = $this->schema->num_fields(); $c <= $fieldCount; $c++) {
                    $F = new stdClass();
                    $F->name = oci_field_name($this->schema->stmt_id, $c);
                    $F->type = oci_field_type($this->schema->stmt_id, $c);
                    $F->max_length = oci_field_size($this->schema->stmt_id, $c);
                    $F->raw_type = oci_field_type_raw($this->schema->stmt_id, $c);
                    $F->is_null = oci_field_is_null($this->schema->stmt_id, $c);
                    $F->scale = oci_field_scale($this->schema->stmt_id, $c);
                    $F->precision = oci_field_precision($this->schema->stmt_id, $c);

                    $this->attributes[$F->name] = $F;
                }
            }

            $this->name = $params['source'];
        }

        if (isset($params['label'])) {
            $this->label = $params['label'];
        }
    }

    public function get_attributes() {
        return $this->attributes;
    }

    public function get_result_array() {
        return $this->query->result_array;
    }

    public function get_result_json() {
        return json_encode($this->get_result_array());
    }

    public function get_attributes_json() {
        return json_encode($this->get_attributes());
    }

    public function build_json_result() {
        return json_encode(array(
                    "records" => "1000000",
                    "page" => 2,
                    "total" => 10000,
                    "rows" => $this->get_result_array()));
    }

    function __set($key, $val) {
        $this->$key = $val;
    }

}
*/
/* End of file My_DBModel.php */
/* Location: ./system/application/libraries/My_DBModel.php */
