<?php
//echo "<pre>";
//print_r($grid->columns);
//die();
$obj = strtolower($grid->model);
$grid_id = 'grid_' . $obj;
$pager_id = 'pager_' . $obj;
$form_id = 'modal_form_' . $obj;
?>
<div id="<?php echo $form_id ?>"></div>
<table id="<?php echo $grid_id ?>"></table>
<div id="<?php echo $pager_id ?>"></div>
<script>
    jQuery(document).ready(function ($) {
                
        jQuery('#<?php echo $grid_id ?>').jqGrid({
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
            "editurl": '<?php echo $obj ?>',
            "cellurl": '<?php echo $obj ?>',
            "rownumbers": true,
            "rownumWidth": 40,
            "rowNum": 15,
            "height": 300,
            "rowList": [10, 20, 50],
            "altRows": true,
            "sortable": true,
            "datatype": "json",
            "colModel": <?php echo json_encode(array_values($grid->columns)) ?>,
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
        })
        /// start button configuration ///
        .jqGrid('navButtonAdd','#<?php echo $pager_id ?>',{
            id: 'pager_columns',
            caption: '',
            buttonicon:'ui-icon-carat-2-e-w', 
            title: 'Reorder Columns',
            position:'first',
            onClickButton : function (){
                jQuery('#<?php echo $grid_id ?>').jqGrid('columnChooser');
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
                    jQuery('#<?php echo $grid_id ?>').jqGrid('excelExport', {
                        tag: 'excel',
                        url: 'Ep_vendor'
                    });
                } catch (e) {
                    window.location = 'Ep_vendor?oper=excel';
                }
            }
        })        
        /// delete button
        .jqGrid('navButtonAdd','#<?php echo $pager_id ?>',{
            id: 'pager_delete',
            caption: '',
            buttonicon:'ui-icon-trash', 
            title: 'Hapus Data',
            position:'first',
            onClickButton : function (){
                jQuery('#<?php echo $grid_id ?>').jqGrid('columnChooser');
            }
        })
        /// edit button
        .jqGrid('navButtonAdd','#<?php echo $pager_id ?>',{
            id: 'pager_edit',
            caption: '',
            buttonicon:'ui-icon-pencil', 
            title: 'Ubah Data',
            position:'first',
            onClickButton : function (){
                var selected = $('#<?php echo $grid_id ?>').jqGrid('getGridParam', 'selrow');
                
                if (selected) {
                    selected = jQuery('#<?php echo $grid_id ?>').jqGrid('getRowData',selected);
                    var keys = <?php echo json_encode($grid->primary_keys); ?>;
                    var count = 0;
                
                    var data = {};
                    var str ="";
                    $.each(keys, function(k, v) { 
                        data = {v:selected[v]};
                        str += v + "=" + selected[v] + "&";
                        count++; 
                    });
                    
                    //console.debug(data);
                    
                    jQuery('#<?php echo $form_id ?>')
                    .load($site_url + '/crud/modal_form/<?php echo $obj ?>?' + str)
                    .dialog({ //dialog form use for popup after click button in pager
                        autoOpen:false,
                        width:800,
                        modal:true,
                        position:'top',
                        buttons: {
                            "SIMPAN": function() {
                                //jQuery("form", this).submit();
                                var d = this;
                                if($("form", this).valid()){
                                    jQuery("form", this).ajaxSubmit({
                                        debug:true,
                                        success:function(x){                                
                                            if(x == ""){
                                                alert("Data berhasil disimpan");
                                                $(d).dialog("close");
                                            }
                                            else
                                                alert("Data gagal disimpan : " + x);
                                        }
                                    });

                                }
                            
                            }, 
                            "BATAL": function() { 
                                $(this).dialog("close");
                            } 
                        }
                    });
                    jQuery('#<?php echo $form_id ?>').dialog("open");
                } else {
                    alert('Harap pilih data yang akan diubah');
                    return;
                }
                
                
            }
        })
        /// add button
        .jqGrid('navButtonAdd','#<?php echo $pager_id ?>',{
            id: 'pager_add',
            caption: '',
            buttonicon:'ui-icon-plus', 
            title: 'Tambah Data',
            position:'first',
            onClickButton : function (){
                
                jQuery('#<?php echo $form_id; ?>')
                //.load($site_url + '/crud/modal_form/' + $obj)
                .load($site_url + '/crud/modal_form/<?php echo $obj ?>')
                .dialog({ //dialog form use for popup after click button in pager
                    autoOpen:false,
                    width: 800,
                    modal:true,
                    position:'top',
                    buttons: {
                        "SIMPAN": function(x) {                            
                            var d = this;
                            if($("form", this).valid()){
                                jQuery("form", this).ajaxSubmit({
                                    debug:true,
                                    success:function(x){                                
                                        if(x == ""){
                                            alert("Data berhasil disimpan");
                                            $(d).dialog("close");
                                        }
                                        else
                                            alert("Data gagal disimpan : " + x);
                                    }
                                });

                            }
                        }, 
                        "BATAL": function() { 
                            $(this).dialog("close");
                        } 
                    }
                });
                
                jQuery('#<?php echo $form_id ?>').dialog("open");
            }
        });
        
        $('#<?php echo $grid_id ?>').jqGrid("setGridWidth", $('#gbox_<?php echo $grid_id ?>').parent().width() , false);
    });
</script>