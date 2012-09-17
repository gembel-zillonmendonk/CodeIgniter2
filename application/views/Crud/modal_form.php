<?php

$CI = & get_instance();
$CI->load->library('ci_jqForm', array('method' => 'post', 'name' => $name, 'id' => $id), 'f');

// Set url
$url = site_url('crud/modal_form/' . $model->table);
$CI->f->setUrl($url);
// Set parameters 
$params = array();
// Set SQL Command, table, keys 
$CI->f->table = $model->table;
$CI->f->setPrimaryKeys('OrderID');
$CI->f->serialKey = false;
// Set Form layout 
$CI->f->setColumnLayout('twocolumn');
// Set the style for the table
$CI->f->setTableStyles('border:1px solid; border-spacing:none; border-collapse:collapse;');

// Add elements
foreach ($model->columns as $k => $v) {
    $prop = array(
        'label' => $v['label'],
        'id' => $name . $v['name'],        
        'maxlength' => $v['size'],
        'style' => 'width:100%',
        'size' => $v['size'],
        'value' => (isset($model->attributes[$k]) ? $model->attributes[$k] : $v['default_value']),
    );
    
    if($v['allow_null']) $prop['required'] = "1";
    
    $CI->f->addElement($model->table . '[' .$v['name'] .']', $v['type'], $prop);
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
