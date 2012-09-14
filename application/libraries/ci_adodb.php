<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ci_adodb {

    private $_adodb_path = 'libraries/adodb5/';
    function ci_adodb() {
        if (!class_exists('ADONewConnection')) {
            require_once(APPPATH . $this->_adodb_path . 'adodb.inc' . EXT);
            require_once(APPPATH . $this->_adodb_path . 'adodb-error.inc' . EXT);
        }

        $obj = & get_instance();
        $this->_init_adodb_library($obj);
    }

    function _init_adodb_library(&$ci) {
        $db_var = false;
        $debug = false;
        $show_errors = true;
        $active_record = false;
        $db = NULL;

        if (!isset($dsn)) {
            // fallback to using the CI database file 
            include(APPPATH . 'config/database' . EXT);
            $group = 'default';
            $dsn = $db[$group]['dbdriver'] . '://' . $db[$group]['username']
                    . ':' . $db[$group]['password'] . '@' . $db[$group]['hostname']
                    . '/' . $db[$group]['database'];
        }

        // Show Message Adodb Library PHP
        if ($show_errors) {
            require_once(APPPATH . $this->_adodb_path . 'adodb-errorhandler.inc' . EXT);
        }

        // $ci is by reference, refers back to global instance
        $ci->adodb = & ADONewConnection($dsn);
        // Use active record adodbx
        $ci->adodb->setFetchMode(ADODB_FETCH_ASSOC);

        if ($db_var) {
            // Also set the normal CI db variable
            $ci->db = & $ci->adodb;
        }

        if ($active_record) {
            require_once(APPPATH . $this->_adodb_path . 'adodb-active-record.inc' . EXT);
            ADOdb_Active_Record::SetDatabaseAdapter($ci->adodb);
        }

        if ($debug) {
            $ci->adodb->debug = true;
        }
    }

    /*
     * Function Factory for call ADODB Active Record function
     */

    function ADOdb_Active_Record_Factory($classname, $tablename = null) {
        // create the class
        eval('class ' . $classname . ' extends ADOdb_Active_Record{}');

        if ($tablename != null) {
            return new $classname($tablename);
        } else {
            return new $classname;
        }
    }

}

?>
