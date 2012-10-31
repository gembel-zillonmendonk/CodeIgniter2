<?php
//echo "<pre>";
//print_r($grid->columns);
//die();
$pager_id = 'pager_' . $grid->id;
$form_id = 'modal_form_' . $grid->id;
?>
<div id="<?php echo $form_id ?>"></div>
<table id="<?php echo $grid->id ?>"></table>
<div id="<?php echo $pager_id ?>"></div>
<script>
    jQuery(document).ready(function ($) {

        fx = function(id, param){
            if(id == 'btnProses')
                window.location.href = $site_url + '/pengadaan/createOrEdit?' + param;
            else
                window.location.href = $site_url + '/pengadaan/daftar?' + param;
            return false;
        }

        jQuery('#<?php echo $grid->id ?>').jqGrid({
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
            "url": "<?php echo site_url($grid->url) ?>",
            "editurl": '<?php echo $grid->model ?>',
            "cellurl": '<?php echo $grid->model ?>',
            "rownumbers": true,
            "rownumWidth": 40,
            "rowNum": 15,
            "height": 300,
            "rowList": [10, 20, 50],
            "altRows": true,
            "sortable": true,
            "datatype": "json",
            "colModel": <?php echo json_encode( (array_values($grid->columns + array('action'=>array('name'=>'ACTION','sortable'=>false))))) ?>,
            "toolbar" : [false,"top"],
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
            "gridComplete":function(){
                               
                var ids = jQuery('#<?php echo $grid->id ?>').jqGrid('getDataIDs');
                for(var i=0;i < ids.length;i++){
                    var cl = ids[i];
                    var selected = jQuery('#<?php echo $grid->id ?>').jqGrid('getRowData',cl);
                    
                    var keys = <?php echo json_encode($grid->primary_keys); ?>;
                    var count = 0;
                
                    var data = {};
                    var str ="";
                    $.each(keys, function(k, v) { 
                        data = {v:selected[v]};
                        str += v + "=" + selected[v] + "&";
                        count++; 
                    });
                    
                    btn = '<button type="button" id="btnProses" onclick="fx(this.id, \''+str+'\');" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">PROSES</span></button>';
                    btn = btn + '<button type="button" id="btnDaftar" onclick="fx(this.id, \''+str+'\');" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">DAFTAR</span></button>';
                    jQuery('#<?php echo $grid->id ?>').jqGrid('setRowData',ids[i],{ACTION:btn});
		}
                <?php echo $grid->js_grid_completed; ?>
                	
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
            "pager": '#<?php echo $pager_id ?>'
        })
        .jqGrid('navGrid', '#<?php echo $pager_id ?>', {
            "edit": false,
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
        })
        /// start button configuration ///
        .jqGrid('navButtonAdd','#<?php echo $pager_id ?>',{
            id: 'pager_columns',
            caption: '',
            buttonicon:'ui-icon-carat-2-e-w', 
            title: 'Reorder Columns',
            position:'first',
            onClickButton : function (){
                jQuery('#<?php echo $grid->id ?>').jqGrid('columnChooser');
            }
        })
        .jqGrid('navButtonAdd', '#<?php echo $pager_id ?>', {
            id: 'pager_excel',
            caption: '',
            buttonicon: 'ui-icon-newwin',
            title: 'Export To Excel',
            position:'first',
            onClickButton: function (e) {
                try {
                    jQuery('#<?php echo $grid->id ?>').jqGrid('excelExport', {
                        tag: 'excel',
                        url: $site_url + '/crud/modal_form/<?php echo $grid->model ?>'
                    });
                } catch (e) {
                    window.location = 'Ep_vendor?oper=excel';
                }
            }
        });
        
        $('#<?php echo $grid->id ?>').jqGrid("setGridWidth", $('#gbox_<?php echo $grid->id ?>').parent().width() , false);
        
        $('#<?php echo $grid->id ?>').jqGrid('setGridParam',{
            
        }).trigger("reloadGrid");
    });
    
    
</script>