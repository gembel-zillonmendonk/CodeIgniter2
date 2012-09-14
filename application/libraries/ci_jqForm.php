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
require_once('jqSuitePHP/jqForm.php');

class ci_jqForm extends jqForm {

    public $name;
    public $id;

    public function __construct($params = array()) {
        $this->name = $params['name'];
        $this->id = $params['id'];

        $db = null;
        $odbctype = '';
        parent::__construct($this->name, array('id'=>$this->id));
    }
    
}

?>
