<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_DB_oci8_driver extends CI_DB_oci8_driver {

    final public function __construct($params) {
        parent::__construct($params);
        
        // change datatime format to 'YYYY-MM-DD HH24:MI:SS'
        $this->query("alter session set nls_date_format='YYYY-MM-DD HH24:MI:SS'");
        
        log_message('debug', 'Extended DB driver class instantiated!');
    }

    public function list_columns($table = '') {
        // Is there a cached result?
        if (isset($this->data_cache['column_names'][$table])) {
            return $this->data_cache['column_names'][$table];
        }

        if ($table == '') {
            if ($this->db_debug) {
                return $this->display_error('db_field_param_missing');
            }
            return FALSE;
        }

        if (FALSE === ($sql = $this->_list_columns($table))) {
            if ($this->db_debug) {
                return $this->display_error('db_unsupported_function');
            }
            return FALSE;
        }
        $sql = "SELECT a.column_name as \"name\", a.data_length as \"size\", a.data_precision as \"precision\", a.data_scale as \"scale\", a.data_type as \"db_type\",
    a.nullable as \"allow_null\", a.data_default as \"default_value\",
    (   SELECT D.constraint_type
        FROM ALL_CONS_COLUMNS C
        inner join ALL_constraints D on D.OWNER = C.OWNER and D.constraint_name = C.constraint_name
        WHERE C.OWNER = B.OWNER
           and C.table_name = B.object_name
           and C.column_name = A.column_name
           and D.constraint_type = 'P') as \"key\"
FROM ALL_TAB_COLUMNS A
inner join ALL_OBJECTS B ON b.owner = a.owner and ltrim(B.OBJECT_NAME) = ltrim(A.TABLE_NAME)
WHERE (b.object_type = 'TABLE' or b.object_type = 'VIEW')
	and b.object_name = '$table'
ORDER by a.column_id";

        $query = $this->query($sql);
        $retval = array();

        foreach ($query->result_array() as $column) {
            $retval[$column['name']] = $column;
        }
        $this->data_cache['column_names'][$table] = $retval;
        return $this->data_cache['column_names'][$table];
    }

    public function list_constraints($table = '') {
        // Is there a cached result?
        if (isset($this->data_cache['constraint_names'][$table])) {
            return $this->data_cache['constraint_names'][$table];
        }

        if ($table == '') {
            if ($this->db_debug) {
                return $this->display_error('db_field_param_missing');
            }
            return FALSE;
        }

        if (FALSE === ($sql = $this->_list_columns($table))) {
            if ($this->db_debug) {
                return $this->display_error('db_unsupported_function');
            }
            return FALSE;
        }

        $sql = <<<EOD
		SELECT D.constraint_type as CONSTRAINT_TYPE, C.COLUMN_NAME, C.position, D.r_constraint_name,
                E.table_name as table_ref, f.column_name as column_ref,
            	C.table_name
        FROM ALL_CONS_COLUMNS C
        inner join ALL_constraints D on D.OWNER = C.OWNER and D.constraint_name = C.constraint_name
        left join ALL_constraints E on E.OWNER = D.r_OWNER and E.constraint_name = D.r_constraint_name
        left join ALL_cons_columns F on F.OWNER = E.OWNER and F.constraint_name = E.constraint_name and F.position = c.position
        WHERE  C.table_name = '$table'
           and D.constraint_type <> 'P'
        order by d.constraint_name, c.position
EOD;
        $query = $this->query($sql);
        $retval = array();
        foreach ($query->result_array() as $row) {
            if ($row['CONSTRAINT_TYPE'] === 'R') {   // foreign key
                $retval[$row["COLUMN_NAME"]] = array($row["TABLE_REF"], $row["COLUMN_REF"]);
            }
        }
        $this->data_cache['constraint_names'][$table] = $retval;
        return $this->data_cache['constraint_names'][$table];
    }

}

/* End of file oci8_driver.php */
/* Location: ./system/database/drivers/oci8/oci8_driver.php */
