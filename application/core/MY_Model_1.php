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
require_once(APPPATH . 'libraries/jqSuitePHP/jqUtils.php');

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
    public $encoding = 'utf-8';
    public $select = "";
    public $datearray = array();
    protected $dbdateformat = 'Y-m-d';
    protected $dbtimeformat = 'Y-m-d H:i:s';
    protected $userdateformat = 'd/m/Y';
    protected $usertimeformat = 'd/m/Y H:i:s';
    protected $I = '';
    protected $GridParams = array("page" => "page", "rows" => "rows", "sort" => "sidx", "order" => "sord", "search" => "_search", "nd" => "nd", "id" => "id", "filter" => "filters", "searchField" => "searchField", "searchOper" => "searchOper", "searchString" => "searchString", "oper" => "oper", "query" => "grid", "addoper" => "add", "editoper" => "edit", "deloper" => "del", "excel" => "excel", "subgrid" => "subgrid", "totalrows" => "totalrows", "autocomplete" => "autocmpl");

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
        /*
        if (!$this->sql_select)
            $this->meta_columns = $this->db->list_columns($this->table);
        else {
            $q = $this->db->query($this->sql_select);
            foreach ($q->field_data() as $field) {
                $this->meta_columns[$field->name] = array(
                    'name' => $field->name,
                    'db_type' => $field->type,
                    'size' => $field->max_length,
                    'key' => '',
                );
            }
        }
        */
        
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
        if (!isset($this->sql_select))
            $this->sql_select = $this->table;
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

    public function save($attributes) {
        // cek if record new
        if (count($this->primary_keys) == 0)
            show_error("Table doesn't have a primary key");

        $where = array();
        foreach ($this->primary_keys as $key) {
            $where[$key] = $attributes[$key];
        }

        $this->db->where($where);
        $is_new = ($this->db->count_all_results($this->table) > 0 ? false : true);

        if ($is_new)
            return $this->_insert($attributes);
        else
            return $this->_update($attributes, $where);
    }

    public function delete() {
        
    }

    public function is_new_record() {
        
    }

    public function get_attributes() {
        return $this->attributes;
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
        return $this->db->update($this->table, $attributes, $where);
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

    protected function _buildSearch(array $prm = null, $str_filter = '') {
        $filters = ($str_filter && strlen($str_filter) > 0 ) ? $str_filter : jqGridUtils::GetParam($this->GridParams["filter"], "");
        //$filters = ($str_filter && strlen($str_filter) > 0 ) ? $str_filter : null;
        $jsona = NULL;
        $rules = "";
        if ($filters) {
            $count = 0;
            $filters = str_replace('$', '\$', $filters, $count);
            if (function_exists('json_decode') && strtolower(trim($this->encoding)) == "utf-8" && $count == 0) {
                $jsona = json_decode($filters, true);
            } else {
                $jsona = jqGridUtils::decode($filters);
            } if (is_array($jsona)) {
                $gopr = $jsona['groupOp'];
                $rules[0]['data'] = 'dummy';
            }
        } else if (jqGridUtils::GetParam($this->GridParams['searchField'], '')) {
            $gopr = '';
            $rules[0]['field'] = jqGridUtils::GetParam($this->GridParams['searchField'], '');
            $rules[0]['op'] = jqGridUtils::GetParam($this->GridParams['searchOper'], '');
            $rules[0]['data'] = jqGridUtils::GetParam($this->GridParams['searchString'], '');
            $jsona = array();
            $jsona['groupOp'] = "AND";
            $jsona['rules'] = $rules;
            $jsona['groups'] = array();
        }

        $ret = array("", $prm);
        if ($jsona) {
            if ($rules && count($rules) > 0) {
                if (!is_array($prm)) {
                    $prm = array();
                } $ret = $this->_getStringForGroup($jsona, $prm);
                if (count($ret[1]) == 0)
                    $ret[1] = null;
            }
        } return $ret;
    }

    protected function _getStringForGroup($group, $prm) {
        $i_ = $this->I;
        $sopt = array('eq' => "=", 'ne' => "<>", 'lt' => "<", 'le' => "<=", 'gt' => ">", 'ge' => ">=", 'bw' => " {$i_}LIKE ", 'bn' => " NOT {$i_}LIKE ", 'in' => ' IN ', 'ni' => ' NOT IN', 'ew' => " {$i_}LIKE ", 'en' => " NOT {$i_}LIKE ", 'cn' => " {$i_}LIKE ", 'nc' => " NOT {$i_}LIKE ", 'nu' => 'IS NULL', 'nn' => 'IS NOT NULL');
        $s = "(";
        if (isset($group['groups']) && is_array($group['groups']) && count($group['groups']) > 0) {
            for ($j = 0; $j < count($group['groups']); $j++) {
                if (strlen($s) > 1) {
                    $s .= " " . $group['groupOp'] . " ";
                } try {
                    $dat = $this->_getStringForGroup($group['groups'][$j], $prm);
                    $s .= $dat[0];
                    $prm = $prm + $dat[1];
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        } if (isset($group['rules']) && count($group['rules']) > 0) {
            try {
                foreach ($group['rules'] as $key => $val) {
                    if (strlen($s) > 1) {
                        $s .= " " . $group['groupOp'] . " ";
                    } $field = $val['field'];
                    $op = $val['op'];
                    $v = $val['data'];
                    if (strtolower($this->encoding) != 'utf-8') {
                        $v = iconv("utf-8", $this->encoding . "//TRANSLIT", $v);
                    } if ($op) {
                        if (in_array($field, $this->datearray)) {
                            $v = jqGridUtils::parseDate($this->userdateformat, $v, $this->dbdateformat);
                        } switch ($op) {
                            case 'bw': case 'bn': $s .= $field . ' ' . $sopt[$op] . " ?";
                                $prm[] = "$v%";
                                break;
                            case 'ew': case 'en': $s .= $field . ' ' . $sopt[$op] . " ?";
                                $prm[] = "%$v";
                                break;
                            case 'cn': case 'nc': $s .= $field . ' ' . $sopt[$op] . " ?";
                                $prm[] = "%$v%";
                                break;
                            case 'in': case 'ni': $s .= $field . ' ' . $sopt[$op] . "( ?)";
                                $prm[] = $v;
                                break;
                            case 'nu': case 'nn': $s .= $field . ' ' . $sopt[$op] . " ";
                                break;
                            default : $s .= $field . ' ' . $sopt[$op] . " ?";
                                $prm[] = $v;
                                break;
                        }
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } $s .= ")";
        if ($s == "()") {
            return array("", $prm);
        } else {
            return array($s, $prm);
        }
    }

    public function buildSearch($filter, $otype = 'str') {
        $ret = $this->_buildSearch(null, $filter);
        if ($otype === 'str') {
            $s2a = explode("?", $ret[0]);
            $csa = count($s2a);
            $s = "";
            for ($i = 0; $i < $csa - 1; $i++) {
                $s .= $s2a[$i] . " '" . $ret[1][$i] . "' ";
            } $s .= $s2a[$csa - 1];
            return $s;
        } return $ret;
    }

}

class MY_Form {

    public $action = '';
    public $method = 'POST';
    public $label = 'Form Detail';
    public $name = '';
    public $id = '';
    public $before_submit = '';
    public $after_submit = '';
    public $referer_url = '';
    public $elements = array(); //--> required = array(id, name) and optionals --> array(type, size, maxlength, style, value)
    public $validation = array("validate" => array());
    public $layout = '';
    public $is_modal = false;
    public $form_params = array();
    public $form_view = 'crud/form';
    public $grid_view = 'crud/grid';

    public function __construct($model) {
        if ($this->action == '')
            $this->action = 'crud/modal_form/' . $model->table;

        if ($this->name == '')
            $this->name = 'form_' . $model->table;

        if ($this->id == '')
            $this->id = 'id_form_' . $model->table;

        $this->form_params = array('id' => $this->id, 'name' => $this->name);
        // set elements and validation
        $el = $r = array();
        $attributes = $model->get_attributes();
        foreach ($model->columns as $k => $v) {

            if (isset($model->show_columns) && !in_array($k, $model->show_columns))
                continue;

            $r[$k]['validate'] = array(
                'required' => $v['allow_null'] == 'Y' ? false : true,
                'maxlength' => $v['size'],
            );

            $el[$k] = array(
                'id' => 'id_' . strtolower($k),
                'name' => $model->table . '[' . $k . ']',
                'label' => str_replace('_', ' ', $v['name']),
                'type' => $v['type'],
                //'size' => $v['size'],
                'maxlength' => $v['size'],
                'style' => '',
                'value' => (isset($attributes[$k]) ? $attributes[$k] : $v['default_value']),
            );
        }
        $this->elements = $el;
        $this->validation = $r;


//echo "<pre>";
//print_r(str_replace('"', '', json_encode($this->validation['KODE_VENDOR'])));
//die();
    }

}

?>
