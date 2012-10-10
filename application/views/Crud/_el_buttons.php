<?php if(!isset($read_only) || $read_only != true): ?>
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
                    //clearForm: <?php echo $form->clear_form ? "true" : "false"; ?>,
                    success: function(){
                        <?php if($form->clear_form): ?>
                            $("#<?php echo $form->id; ?>").resetForm();
                            $("#<?php echo $form->id; ?>").clearForm();
                            validator.prepareForm();
                            validator.hideErrors();
                        <?php endif; ?>
                                
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