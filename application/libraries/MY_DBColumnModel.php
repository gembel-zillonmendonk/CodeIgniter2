<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_DBColumnModel {

    public $name;
    public $raw_name;
    public $allow_null;
    public $db_type;
    public $type;
    public $default_value;
    public $size;
    public $precision;
    public $scale;
    public $is_primary_key;
    public $is_foreign_key;
    public $auto_increment = false;

    public function __construct(&$params) {
        $dbType = $params['type'];
        $defaultValue = $params['default_value'];
        $this->name = $params['name'];
        $this->raw_name = $params['name'];
        $this->allow_null = $params['not_null'] ? false : true;
        $this->db_type = $dbType;
        $this->extractType($dbType);
        $this->extractLimit($dbType);
        if ($defaultValue !== null)
            $this->extractDefault($defaultValue);
    }

    /**
     * Extracts size, precision and scale information from column's DB type.
     * @param string $dbType the column's DB type
     */
    protected function extractLimit($dbType) {
        if (strpos($dbType, '(') && preg_match('/\((.*)\)/', $dbType, $matches)) {
            $values = explode(',', $matches[1]);
            $this->size = $this->precision = (int) $values[0];
            if (isset($values[1]))
                $this->scale = (int) $values[1];
        }
    }

    /**
     * Converts the input value to the type that this column is of.
     * @param mixed $value input value
     * @return mixed converted value
     */
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

    /**
     * Extracts the PHP type from DB type.
     * @param string $dbType DB type
     * @return string
     */
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

    /**
     * Extracts the PHP type from DB type.
     * @param string $dbType DB type
     */
    protected function extractType($dbType) {
        $this->type = $this->extractOraType($dbType);
    }

    /**
     * Extracts the default value for the column.
     * The value is typecasted to correct PHP type.
     * @param mixed $defaultValue the default value obtained from metadata
     */
    protected function extractDefault($defaultValue) {
        if (stripos($defaultValue, 'timestamp') !== false)
            $this->default_value = null;
        else
            $this->default_value = $this->typecast($defaultValue);
    }

}

/* End of file MY_DBColumnModel.php */
/* Location: ./system/application/libraries/MY_DBColumnModel.php */
