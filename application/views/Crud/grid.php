
<?php
/*
  $aColumns = array();
  foreach ($model->attributes as $v) {
  $aColumns[] = array(
  'label' => $v->name,
  'name' => $v->name,
  'width' => 100,
  'size' => $v->max_length,
  );
  }
  $aData = array(
  'set_columns' => $aColumns,
  'div_name' => 'grid',
  'source' => site_url('/crud/grid') . '/USERS',
  'sort_name' => 'custname',
  'add_url' => 'customer/exec/add',
  'edit_url' => 'customer/exec/edit',
  'delete_url' => 'customer/exec/del',
  'caption' => 'Customer Maintenance',
  'primary_key' => 'custid',
  'grid_height' => 230
  );

  $this->load->helper('jqgrid_helper');

  echo buildGrid($aData);
 */


$CI = & get_instance();
$CI->load->library('ci_jqGrid', array('query' => $query), 'jqGrid');

//$this->load->library('ci_jqGrid', array('query' => $model->query), 'jqGrid');
//print_r($CI->jqGrid);
$CI->jqGrid->dataType = 'json';
$CI->jqGrid->table = $model;
$CI->jqGrid->setColModel();

if ($model != false)
    $CI->jqGrid->setUrl($model);

$CI->jqGrid->setGridOptions(array(
    "rownumbers" => true,
    "rownumWidth" => 40,
    "rowNum" => $rows,
    //"sortname" => "USERNAME",
    "height" => 400,
    "autoWidth" => true,
    "rowList" => array(10, 20, 50),
    "altRows" => true,
    "hoverrows" => true,
    "sortable" => true,
));
$CI->jqGrid->setColProperty("OrderDate", array(
    "formatter" => "date",
    "formatoptions" => array("srcformat" => "Y-m-d H:i:s", "newformat" => "m/d/Y"),
    "search" => true,
    "resizable" => false,
));
$CI->jqGrid->setColProperty("ShipName", array("classes" => "ui-ellipsis"));
$CI->jqGrid->toolbarfilter = true;
$CI->jqGrid->setFilterOptions(array("stringResult" => true));
$CI->jqGrid->navigator = true;
$CI->jqGrid->setNavOptions('navigator', array(
    "excel" => true,
    "add" => $read_only ? false : true,
    "edit" => $read_only ? false : true,
    "del" => $read_only ? false : true,
    "view" => true
));
$CI->jqGrid->renderGrid('#grid', '#pager', true, null, null, true, true);
?>
<script>
    $(document).ready(function(){

        $('#grid').jqGrid("setGridWidth", $('#gbox_grid').parent().width() , false);
    });

</script>