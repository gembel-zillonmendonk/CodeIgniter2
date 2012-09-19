<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of form
 *
 * @author farid
 */
class MY_Form
{
    public $action = '';
    public $method = 'POST';
    public $name = '';
    public $id = '';
    public $before_submit = '';
    public $after_submit = '';
    public $referer_url = '';
    public $elements = array(); //--> required = array(id, name) and optionals --> array(type, size, maxlength, style, value)
    public $validation = array();
    public $layout = '';
    public $is_modal = false;
    public $form_params = array();

    public function __construct($params)
    {
        $model = $params['model'];
        if ($this->action == '')
            $this->action = 'crud/modal_form/' . $model->table;

        if ($this->name == '')
            $this->name = 'form_' . $model->table;

        if ($this->id == '')
            $this->id = 'id_form_' . $model->table;

        // set elements and validation
        $el = array();
        $r = array();
        foreach ($model->columns as $k => $v)
        {
            $r[$k] = array(
                'required'=>true,
                'maxlength'=>$v['size'],
                'number'=>true,
                'number'=>true,
                'number'=>true,
                'number'=>true,
                'number'=>true,
            );
            
            $el[$k] = array(
                'id'=>'id_' . strtolower($k),
                'name'=>$model->table . '[' . $k . ']',
                'type'=>$v['type'],
                'size'=>$v['size'],
                'maxlength'=>$v['size'],
                'style'=>'',
                'value'=>(isset($model->attributes[$k]) ? $model->attributes[$k] : $v['default_value']),
            );
        }

        echo "<pre>";
        $x =& get_instance();
        print_r($x->load);
        die();
    }

}
?>
