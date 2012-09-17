
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
//$CI->jqGrid->table = $model;
//$CI->jqGrid->setColModel($model);

$CI->jqGrid->table = $model->table;
$CI->jqGrid->setPrimaryKeyId("KODE_VENDOR");
//print_r($model->columns);
//die();
$CI->jqGrid->setColModel(array_values($model->columns));

if ($model != false)
    $CI->jqGrid->setUrl(get_class($model));

$CI->jqGrid->setGridOptions(array(
    "rownumbers" => true,
    "rownumWidth" => 40,
    "rowNum" => $rows,
    //"sortname" => "USERNAME",
    "height" => 300,
    "autoWidth" => true,
    "rowList" => array(10, 20, 50),
    "altRows" => true,
    "hoverrows" => true,
    "sortable" => true,
    "editurl" => "xx",
));
$CI->jqGrid->setColProperty("OrderDate", array(
    "formatter" => "date",
    "formatoptions" => array("srcformat" => "Y-m-d H:i:s", "newformat" => "m/d/Y"),
    "search" => true,
    "resizable" => false,
));
$CI->jqGrid->setColProperty("ShipName", array("classes" => "ui-ellipsis"));
$CI->jqGrid->toolbarfilter = false;
$CI->jqGrid->setFilterOptions(array("stringResult" => true));
$CI->jqGrid->navigator = true;
$CI->jqGrid->setNavOptions('navigator', array(
    //"excel" => true,
    //"add" => $read_only ? false : true,
    //"edit" => $read_only ? false : true,
    //"del" => $read_only ? false : true,
    //"view" => true
    "excel" => true,
    "add" => true,
    "edit" => false,
    "del" => true,
    "view" => true
));

$CI->jqGrid->setNavOptions('edit', array("closeAfterEdit" => true, "editCaption" => "Update Customer", "bSubmit" => "Update"));

$url = site_url('crud/modal_form/' . $model->table);
$form = <<< FORM
function(){
   var id = $("#grid").jqGrid('getGridParam','selrow'), data={};
   if(id) {
       data = {CustomerID:id};
   } else {
      alert('Please select a row to edit');
      return;
   }
   var ajaxDialog = $('<div id="ajax-dialog" style="display:hidden" title="Customer Edit"></div>').appendTo('body');
   ajaxDialog.load(
      '$url',
       data,
       function(response, status){
           ajaxDialog.dialog({
               width: 'auto',
               modal:true,
               open: function(ev, ui){
                  $(".ui-dialog").css('font-size','0.9em');
               },
               close: function(e,ui) {
                   ajaxDialog.remove();
               }
           });
        }
    );
}
FORM;

$buttonoptions = array("#pager",
    array(
        "caption" => "Edit",
        "onClickButton" => "js:" . $form
    )
);

$CI->jqGrid->callGridMethod("#grid", "navButtonAdd", $buttonoptions);
$CI->jqGrid->renderGrid('#grid', '#pager', true, null, null, true, true);
?>
<script>
    $(document).ready(function(){

        $('#grid').jqGrid("setGridWidth", $('#gbox_grid').parent().width() , false);
    });

</script>