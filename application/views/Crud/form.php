<?php

$CI = & get_instance();
$CI->load->library('ci_jqForm', array('method' => 'post', 'name' => $name, 'id' => $id), 'f');

// Set url
$CI->f->setUrl($model->table);
// Set parameters 
$params = array();
// Set SQL Command, table, keys 
$CI->f->table = $model->table;
$CI->f->setPrimaryKeys('OrderID');
$CI->f->serialKey = false;
// Set Form layout 
$CI->f->setColumnLayout('twocolumn');
// Set the style for the table
$CI->f->setTableStyles('width: 940px; margin:0 auto; border:none; border-spacing:none; border-collapse:collapse;');

// Add elements
//print_r($model->columns);
foreach ($model->columns as $k => $v) {
    $prop = array(
        'label' => $v->name,
        'id' => $name . $k,        
        'maxlength' => $v->size,
        'style' => 'width:100%',
        'size' => $v->size,
    );
    
    if($v->allowNull) $prop['required'] = "1";
    
    $CI->f->addElement($v->name, $v->type, $prop);
}

$elem_8[] = $CI->f->createElement('newSubmit', 'submit', array('value' => 'Submit'));
$CI->f->addGroup("newGroup", $elem_8, array('style' => 'text-align:right;', 'id' => 'newForm_newGroup'));
// Add events
// Add ajax submit events
//$x = "function(x) {alert('sdsd')}";
$CI->f->setAjaxOptions(array('dataType' => null,
    'resetForm' => false,
    'clearForm' => false,
    'iframe' => false,
    'forceSync' => false,
        //'success' => $x,
));
// Demo mode - no input 
//$CI->f->demo = true;
// Render the form 
echo $CI->f->renderForm($params);
?>
