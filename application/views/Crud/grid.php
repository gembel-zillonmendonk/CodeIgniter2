<?php
$obj = strtolower(get_class($model));
$grid_id = 'grid_' . $obj;
$pager_id = 'pager_' . $obj;
$toolbar_id = 'toolbar_' . $obj;
$form_id = 'modal_form_' . $obj;
?>
<div id="<?php echo $form_id ?>"></div>
<table id="<?php echo $grid_id ?>"></table>
<table id="<?php echo $toolbar_id ?>"></table>
<div id="<?php echo $pager_id ?>"></div>
<script>
    var $obj = "<?php echo $obj ?>";
    var $grid_id = "#<?php echo $grid_id ?>";
    var $toolbar_id = "#<?php echo $toolbar_id ?>";
    var $pager_id = "#<?php echo $pager_id ?>";
    var $box_id = "#gbox_<?php echo $grid_id ?>";
    var $form_id = "#<?php echo $form_id ?>";
    var $col_model = <?php echo json_encode(array_values($model->meta_columns)) ?>;
    
    
    jQuery(document).ready(function ($) {
        jQuery($grid_id).jqGrid({
            "shrinkToFit": false,
            "autoWidth": true,
            "hoverrows": true,
            "viewrecords": true,
            "jsonReader": {
                "repeatitems": false,
                "subgrid": {
                    "repeatitems": false
                }
            },
            "xmlReader": {
                "repeatitems": false,
                "subgrid": {
                    "repeatitems": false
                }
            },
            "gridview": true,
            //"url": $obj,
            "editurl": "xx",
            "cellurl": "Ep_vendor",
            "rownumbers": true,
            "rownumWidth": 40,
            "rowNum": 15,
            "height": 300,
            "rowList": [10, 20, 50],
            "altRows": true,
            "sortable": true,
            "datatype": "json",
            "colModel": $col_model,
            "toolbar" : [true,"top"],
            "postData": {
                "oper": "grid"
            },
            "prmNames": {
                "page": "page",
                "rows": "rows",
                "sort": "sidx",
                "order": "sord",
                "search": "_search",
                "nd": "nd",
                "id": "id",
                "filter": "filters",
                "searchField": "searchField",
                "searchOper": "searchOper",
                "searchString": "searchString",
                "oper": "oper",
                "query": "grid",
                "addoper": "add",
                "editoper": "edit",
                "deloper": "del",
                "excel": "excel",
                "subgrid": "subgrid",
                "totalrows": "totalrows",
                "autocomplete": "autocmpl"
            },
            "loadError": function (xhr, status, err) {
                try {
                    jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap, '<div class="ui-state-error">' + xhr.responseText + '</div>', jQuery.jgrid.edit.bClose, {
                        buttonalign: 'right'
                    });
                } catch (e) {
                    alert(xhr.responseText);
                }
            },
            "pager": $pager_id
        });
        
        jQuery($grid_id).jqGrid('navGrid', $pager_id, {
            "edit": true,
            "add": false,
            "del": false,
            "search": true,
            "refresh": true,
            "view": false,
            "excel": false,
            "pdf": false,
            "csv": false,
            "columns": true
        }, {
            "drag": true,
            "resize": true,
            "closeOnEscape": true,
            "dataheight": 150,
            "errorTextFormat": function (r) {
                return r.responseText;
            },
            "closeAfterEdit": true,
            "editCaption": "Update Customer",
            "bSubmit": "Update"
        }, {
            "drag": true,
            "resize": true,
            "closeOnEscape": true,
            "dataheight": 150,
            "errorTextFormat": function (r) {
                return r.responseText;
            }
        }, {
            "errorTextFormat": function (r) {
                return r.responseText;
            }
        }, {
            "drag": true,
            "closeAfterSearch": true,
            "multipleSearch": true
        }, {
            "drag": true,
            "resize": true,
            "closeOnEscape": true,
            "dataheight": 150
        });
        
        
        /// start button configuration ///
        jQuery($grid_id).jqGrid('navButtonAdd',$pager_id,{
            id: 'pager_columns',
            caption: '',
            buttonicon:'ui-icon-carat-2-e-w', 
            title: 'Reorder Columns',
            position:'first',
            onClickButton : function (){
                jQuery($grid_id).jqGrid('columnChooser');
            }
        });
        jQuery($grid_id).jqGrid('navButtonAdd', $pager_id, {
            id: 'pager_excel',
            caption: '',
            buttonicon: 'ui-icon-newwin',
            title: 'Export To Excel',
            position:'first',
            onClickButton: function (e) {
                try {
                    jQuery($grid_id).jqGrid('excelExport', {
                        tag: 'excel',
                        url: 'Ep_vendor'
                    });
                } catch (e) {
                    window.location = 'Ep_vendor?oper=excel';
                }
            }
        });
        
        /// delete button
        jQuery($grid_id).jqGrid('navButtonAdd',$pager_id,{
            id: 'pager_delete',
            caption: '',
            buttonicon:'ui-icon-trash', 
            title: 'Delete row',
            position:'first',
            onClickButton : function (){
                jQuery($grid_id).jqGrid('columnChooser');
            }
        });
        
        /// edit button
        jQuery($grid_id).jqGrid('navButtonAdd',$pager_id,{
            id: 'pager_edit',
            caption: '',
            buttonicon:'ui-icon-pencil', 
            title: 'Edit Row',
            position:'first',
            onClickButton : function (){
                var selected = $($grid_id).jqGrid('getGridParam', 'selrow');
                
                if (selected) {
                    selected = jQuery($grid_id).jqGrid('getRowData',selected);
                    var keys = <?php echo json_encode($model->primary_keys); ?>;
                    var count = 0;
                
                    var data = {};
                    var str ="";
                    $.each(keys, function(k, v) { 
                        data = {v:selected[v]};
                        str += v + "=" + selected[v] + "&";
                        count++; 
                    });
                    
                    //console.debug(data);
                    
                    jQuery($form_id)
                    .load($site_url + '/crud/modal_form/' + $obj + '?' + str)
                    .dialog({ //dialog form use for popup after click button in pager
                        autoOpen:false,
                        width:800,
                        modal:true,
                        position:'top',
                        buttons: {
                            "SUBMIT": function() {
                                jQuery("form", this).submit();
                                //jQuery("input[type=submit]", this).ajaxSubmit();
                            
                            }, 
                            "CANCEL": function() { 
                                $(this).dialog("close");
                            } 
                        }
                    });
                    jQuery($form_id).dialog("open");
                } else {
                    alert('Please select a row to edit');
                    return;
                }
                
                
            }
        });
        
        /// add button
        jQuery($grid_id).jqGrid('navButtonAdd',$pager_id,{
            id: 'pager_add',
            caption: '',
            buttonicon:'ui-icon-plus', 
            title: 'Add new row',
            position:'first',
            onClickButton : function (){
                jQuery($form_id)
                .load($site_url + '/crud/modal_form/' + $obj)
                .dialog({ //dialog form use for popup after click button in pager
                    autoOpen:false,
                    width: 800,
                    modal:true,
                    position:'top',
                    buttons: {
                        "SUBMIT": function() {
                            jQuery("form", this).submit();
                            //jQuery("input[type=submit]", this).ajaxSubmit();
                            
                        }, 
                        "CANCEL": function() { 
                            $(this).dialog("close");
                        } 
                    }
                });
                
                jQuery($form_id).dialog("open");
            }
        });
        
        
        
        
        $($grid_id).jqGrid("setGridWidth", $($box_id).parent().width() , false);
    });
</script>