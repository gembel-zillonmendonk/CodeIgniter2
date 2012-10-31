<?php $this->load->helper('form'); ?>
<?php echo form_open($form->action, $form->form_params); ?>
<!--<h3 class="ui-widget ui-widget-header ui-corner-all"><span>Form Detail</span></h3>-->
<table class="table">
    <tr>
        <th width="5%">No.</th>
        <th>Deskripsi</th>
        <th width="20%">Respon Vendor</th>
    </tr>
    <?php if (count($form->elements) > 0): ?>
        <?php foreach ($form->elements as $k => $v): ?>

            <?php foreach ($v['options'] as $key => $opt): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $opt['KETERANGAN']; ?></td>
                    <td>
                        <input type="hidden" name="EP_PGD_PENAWARAN_TEKNIS[<?php echo $key; ?>][KODE_TENDER]" value="<?php echo $opt['KODE_TENDER']; ?>"/>
                        <input type="hidden" name="EP_PGD_PENAWARAN_TEKNIS[<?php echo $key; ?>][KODE_KANTOR]" value="<?php echo $opt['KODE_KANTOR']; ?>"/>
                        <input type="hidden" name="EP_PGD_PENAWARAN_TEKNIS[<?php echo $key; ?>][KODE_VENDOR]" value="<?php echo $opt['KODE_VENDOR']; ?>"/>
                        <input type="hidden" name="EP_PGD_PENAWARAN_TEKNIS[<?php echo $key; ?>][KETERANGAN]" value="<?php echo $opt['KETERANGAN']; ?>"/>
                        <input type="hidden" name="EP_PGD_PENAWARAN_TEKNIS[<?php echo $key; ?>][BERAT]" value="<?php echo $opt['BERAT']; ?>"/>
                        
                        <?php
                        $class = (isset($v['class']) ? $v['class'] : ' ' ) . ' ' . str_replace('"', '', json_encode($form->validation[$k]));
                        ?>
                        <textarea name="EP_PGD_PENAWARAN_TEKNIS[<?php echo $key; ?>][KETERANGAN_VENDOR]" class="<?php echo $class; ?>" ><?php echo strlen($opt['KETERANGAN_VENDOR']) > 0 ? $opt['KETERANGAN_VENDOR'] : ''; ?></textarea>
                    </td>
                </tr>
            <?php endforeach; ?>

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