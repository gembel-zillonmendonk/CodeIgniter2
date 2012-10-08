<?php $this->load->helper('form'); ?>
<?php echo form_open($form->action, $form->form_params); ?>
<?php 

// load partial fields
if(isset($el_fields)):
    echo $el_fields;
endif; 

// load partial buttons with js
if(isset($el_buttons)):
    echo $el_buttons;
endif; 

?>
</form>