<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ci_jqGrid
 *
 * @author farid
 */
require_once('jqSuitePHP/jqUtils.php');
require_once('jqSuitePHP/jqGrid.php');

class ci_jqGrid extends jqGridRender {

    public $query;

    public function __construct($params = array()) {
        $this->query = $params['query'];

        $db = null;
        $odbctype = '';
        parent::__construct($db, $odbctype);
    }

    public function setSelect($colname, $data, $formatter = true, $editing = true, $seraching = true, $defvals = array(), $sep = ":", $delim = ";") {
        $s1 = "";
        $prop = array();
        $goper = $this->oper ? $this->oper : 'nooper';
        if (($goper == 'nooper' || $goper == $this->GridParams["excel"] || $goper == "pdf" || $goper == "csv"))
            $runme = true; else
            $runme = !in_array($goper, array_values($this->GridParams)); if (!$this->runSetCommands && !$runme)
            return false; if (count($this->colModel) > 0 && $runme) {
            if (is_string($data)) {
                $aset = jqGridDB::query($this->pdo, $data);
                if ($aset) {
                    $i = 0;
                    $s = '';
                    while ($row = jqGridDB::fetch_num($aset, $this->pdo)) {
                        if ($i == 0) {
                            $s1 .= $row[0] . $sep . $row[1];
                        } else {
                            $s1 .= $delim . $row[0] . $sep . $row[1];
                        } $i++;
                    }
                } jqGridDB::closeCursor($aset);
            } else if (is_array($data)) {
                $i = 0;
                foreach ($data as $k => $v) {
                    if ($i == 0) {
                        $s1 .= $k . $sep . $v;
                    } else {
                        $s1 .= $delim . $k . $sep . $v;
                    } $i++;
                }
            } if ($editing) {
                $prop = array_merge($prop, array('edittype' => 'select', 'editoptions' => array('value' => $s1, 'separator' => $sep, 'delimiter' => $delim)));
            } if ($formatter) {
                $prop = array_merge($prop, array('formatter' => 'select', 'editoptions' => array('value' => $s1, 'separator' => $sep, 'delimiter' => $delim)));
            } if ($seraching) {
                if (is_array($defvals) && count($defvals) > 0) {
                    foreach ($defvals as $k => $v) {
                        $s1 = $k . $sep . $v . $delim . $s1;
                    }
                } $prop = array_merge($prop, array("stype" => "select", "searchoptions" => array("value" => $s1, 'separator' => $sep, 'delimiter' => $delim)));
            } if (count($prop) > 0) {
                $this->setColProperty($colname, $prop);
            } return true;
        } return false;
    }

    public function setColModel(array $model = null, array $params = null, array $labels = null) {
        $goper = $this->oper ? $this->oper : 'nooper';
        if (($goper == 'nooper' || $goper == $this->GridParams["excel"] || $goper == "pdf" || $goper == "csv"))
            $runme = true; else
            $runme = !in_array($goper, array_values($this->GridParams)); if ($runme) {
            if (is_array($model) && count($model) > 0) {
                $this->colModel = $model;
                if ($this->primaryKey) {
                    $this->setColProperty($this->primaryKey, array("key" => true));
                } 
                return true;
            }

            if ($this->query->stmt_id !== null) {
                if (is_array($labels) && count($labels) > 0)
                    $names = true;
                else
                    $names = false;

                for ($c = 1, $colcount = $this->query->num_fields(); $c <= $colcount; $c++) {
                    $meta = array();
                    $meta['name'] = oci_field_name($this->query->stmt_id, $c);
                    $meta['type'] = oci_field_type($this->query->stmt_id, $c);
                    $meta['max_length'] = oci_field_size($this->query->stmt_id, $c);
                    $meta['raw_type'] = oci_field_type_raw($this->query->stmt_id, $c);
                    $meta['is_null'] = oci_field_is_null($this->query->stmt_id, $c);
                    $meta['scale'] = oci_field_scale($this->query->stmt_id, $c);
                    $meta['precision'] = oci_field_precision($this->query->stmt_id, $c);

                    if (strtolower($meta['name']) == 'jqgrid_row')
                        continue;
                    if ($names && array_key_exists($meta['name'], $labels))
                        $this->colModel[] = array(
                            'label' => $labels[$meta['name']],
                            'name' => $meta['name'],
                            'index' => $meta['name'],
                            'sorttype' => $meta['type']
                        );
                    else
                        $this->colModel[] = array(
                            'name' => $meta['name'],
                            'index' => $meta['name'],
                            'sorttype' => $meta['type']
                        );
                }
            } else {
                $this->errorMessage = "Errors : No statement was executed";
                if ($this->showError) {
                    $this->sendErrorHeader();
                } 
                return $this->query->stmt_id;
            }

            /*
            $sql = null;
            $sqlId = $this->_setSQL();
            if (!$sqlId)
                return false;

            $nof = ($this->dbtype == 'sqlite' || $this->dbtype == 'db2' || $this->dbtype == 'array' || $this->dbtype == 'mongodb' || $this->dbtype == 'adodb') ? 1 : 0;
            $ret = $this->execute($sqlId, $params, $sql, true, $nof, 0);
            if ($ret) {
                if (is_array($labels) && count($labels) > 0)
                    $names = true;
                else
                    $names = false;

                $colcount = jqGridDB::columnCount($sql);
                for ($i = 0; $i < $colcount; $i++) {
                    $meta = jqGridDB::getColumnMeta($i, $sql);
                    if (strtolower($meta['name']) == 'jqgrid_row')
                        continue;
                    if ($names && array_key_exists($meta['name'], $labels))
                        $this->colModel[] = array('label' => $labels[$meta['name']], 'name' => $meta['name'], 'index' => $meta['name'], 'sorttype' => jqGridDB::MetaType($meta, $this->dbtype));
                    else
                        $this->colModel[] = array('name' => $meta['name'], 'index' => $meta['name'], 'sorttype' => jqGridDB::MetaType($meta, $this->dbtype));
                }
                jqGridDB::closeCursor($sql);
                if ($this->primaryKey)
                    $pk = $this->primaryKey; else {
                    $pk = jqGridDB::getPrimaryKey($this->table, $this->pdo, $this->dbtype);
                    if ($pk !== false) {
                        $this->primaryKey = $pk;
                    }
                } if ($pk === false) {
                    $pk = 0;
                } $this->setColProperty($pk, array("key" => true));
            } else {
                $this->errorMessage = jqGridDB::errorMessage($sql);
                if ($this->showError) {
                    $this->sendErrorHeader();
                } return $ret;
            }
             */

        } if ($goper == $this->GridParams["excel"]) {
            $this->runSetCommands = false;
        } else if (!$runme) {
            $this->runSetCommands = false;
        } return true;
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
    
    protected function getStringForGroup($group, $prm) {
        $i_ = $this->I;
        $sopt = array('eq' => "=", 'ne' => "<>", 'lt' => "<", 'le' => "<=", 'gt' => ">", 'ge' => ">=", 'bw' => " {$i_}LIKE ", 'bn' => " NOT {$i_}LIKE ", 'in' => ' IN ', 'ni' => ' NOT IN', 'ew' => " {$i_}LIKE ", 'en' => " NOT {$i_}LIKE ", 'cn' => " {$i_}LIKE ", 'nc' => " NOT {$i_}LIKE ", 'nu' => 'IS NULL', 'nn' => 'IS NOT NULL');
        $s = "(";
        if (isset($group['groups']) && is_array($group['groups']) && count($group['groups']) > 0) {
            for ($j = 0; $j < count($group['groups']); $j++) {
                if (strlen($s) > 1) {
                    $s .= " " . $group['groupOp'] . " ";
                } try {
                    $dat = $this->getStringForGroup($group['groups'][$j], $prm);
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
}

?>
