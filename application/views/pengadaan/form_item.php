<?php $this->load->helper('form'); ?>
<?php echo form_open($form->action, $form->form_params); ?>
<!--<h3 class="ui-widget ui-widget-header ui-corner-all"><span>Form Detail</span></h3>-->
<table class="table">
    <tr>
        <th width="5%">No.</th>
        <th>Nama Barang</th>
        <th width="20%">Keterangan</th>
        <th width="10%">Jumlah</th>
        <th width="10%">Harga</th>
    </tr>
    <?php if (count($form->model->elements_conf) > 0): ?>
        <?php foreach ($form->model->elements_conf as $k => $v): ?>

            <tr>
                <td><?php echo $k + 1; ?></td>
                <td><?php echo $v['NAMA_BARANG_JASA']['value']; ?></td>
                <td>
                    <input type="hidden" name="EP_PGD_ITEM_PENAWARAN[<?php echo $k; ?>][KODE_TENDER]" value="<?php echo $v['KODE_TENDER']['value']; ?>"/>
                    <input type="hidden" name="EP_PGD_ITEM_PENAWARAN[<?php echo $k; ?>][KODE_KANTOR]" value="<?php echo $v['KODE_KANTOR']['value']; ?>"/>
                    <input type="hidden" name="EP_PGD_ITEM_PENAWARAN[<?php echo $k; ?>][KODE_VENDOR]" value="<?php echo $v['KODE_VENDOR']['value']; ?>"/>
                    <input type="hidden" name="EP_PGD_ITEM_PENAWARAN[<?php echo $k; ?>][KODE_BARANG_JASA]" value="<?php echo $v['KODE_BARANG_JASA']['value']; ?>"/>
                    <input type="hidden" name="EP_PGD_ITEM_PENAWARAN[<?php echo $k; ?>][KODE_SUB_BARANG_JASA]" value="<?php echo $v['KODE_SUB_BARANG_JASA']['value']; ?>"/>

                    <textarea name="EP_PGD_ITEM_PENAWARAN[<?php echo $k; ?>][KETERANGAN]" ><?php echo strlen($v['KETERANGAN']['value']) > 0 ? $v['KETERANGAN']['value'] : ''; ?></textarea>
                </td>
                <td>  
                    <input type="number" name="EP_PGD_ITEM_PENAWARAN[<?php echo $k; ?>][JUMLAH]" class="{validate:{required:true,number:true}}" value="<?php echo $v['JUMLAH']['value']; ?>"/>
                </td>
                <td>
                    <input type="number" name="EP_PGD_ITEM_PENAWARAN[<?php echo $k; ?>][HARGA]" class="{validate:{required:true,number:true}}" value="<?php echo $v['HARGA']['value']; ?>"/>
                </td>
            </tr>

        <?php endforeach; ?>
<?php endif; ?>
</table>
<?php if (!isset($read_only) || $read_only != true): ?>
    <button type="button" id="btnSimpan">SIMPAN</button>
    <button type="button" id="btnBatal">BATAL</button>
    <script>
        $(document).ready(function(){
            // stylish button and input date
            $(function() {
                $( "input:submit, button").button();
                $( ".datepicker" ).datepicker();
                //$( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                                
            });
                            
            var validator = $("#<?php echo $form->id; ?>").validate({
                meta: "validate",
                submitHandler: function(form) {
                    jQuery(form).ajaxSubmit();
                }
            });
                            
            // attach event to button
            $("#<?php echo $form->id; ?> #btnSimpan").click(function() {
                if(validator.form()) {
                    jQuery("#<?php echo $form->id; ?>").ajaxSubmit({
                        clearForm: false,
                        success: function(){
                            alert('Data berhasil disimpan');
                            //reload grid
                            $('#grid_<?php echo strtolower(get_class($form->model)); ?>').trigger("reloadGrid");
                        },
                        error: function(){
                            alert('Data gagal disimpan')
                        }
                    });
                }
            });
                                
            $("#<?php echo $form->id; ?> #btnBatal").click(function() {
                $("#<?php echo $form->id; ?>").resetForm();
                validator.prepareForm();
                validator.hideErrors();
            });
        });
                            
    </script>
<?php endif; ?>
</form>