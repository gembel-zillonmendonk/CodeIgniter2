<?php $this->load->helper('form'); ?>
<?php
//echo "<pre>";
//print_r($form);
//die("xx");
?>

<?php echo form_open($form->action, $form->form_params); ?>
<fieldset style="width:100%">
    <legend>Fields with remark (*) is required.</legend>
    <?php foreach ($form->elements as $k => $v): ?>
        <p>
            <?php echo form_label($v['label'] . " " . ($form->validation[$k]['validate']['required'] == true ? "*" : ""), $v['name']) ?>
            <?php
            $v['class'] = (isset($v['class']) ? $v['class'] : ' ' ) . ' ' . str_replace('"', '', json_encode($form->validation[$k]));

            switch ($v['type'])
            {
                case 'textarea':
                    echo form_textarea($v);
                    break;
                case 'number':
                    echo form_input($v);
                    break;
                case 'dropdown':
                    $opt = $v;
                    unset($opt['name'], $opt['options'], $opt['value']);
                    $opt = $form->implodeAssoc(' ', $opt);
                    echo form_dropdown($v['name'], $v['options'], $v['value'], $opt);
                    break;
                case 'multiselect':
                    echo form_multiselect($v);
                    break;
                case 'checkbox':
                    echo form_checkbox($v);
                    break;
                case 'radiobutton':
                    echo form_radio($v);
                    break;
                case 'date':
                    $v['type'] = 'text';
                    $v['class'] = 'datepicker ' . $v['class'];
                    echo form_input($v);
                    break;
                case 'file':
                    echo form_upload($v);
                    break;
                default:
                    echo form_input($v);
            }
            ?>

        </p>

    <?php endforeach; ?>
</fieldset>
</form>

<script>
    $( ".datepicker" ).datepicker();
    
    $("#<?php echo $form->id; ?>").validate({
        meta: "validate",
        debug:true
    });
</script>