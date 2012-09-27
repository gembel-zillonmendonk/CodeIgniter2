<?php $this->load->helper('form'); ?>
<?php
//echo "<pre>";
//print_r($this->model->cls_form);
//die("xx");
?>

<?php echo form_open($form->action, $form->form_params); ?>
<fieldset style="width:100%">
    <legend>Fields with remark (*) is required.</legend>
    <?php foreach ($form->elements as $k => $v): ?>
        <p>
            <?php echo form_label($v['label'] . " " . ($form->validation[$k]['validate']['required'] == true ? "*" : ""), $v['name']) ?>
            <?php
            //echo str_replace('"', '', json_encode($form->validation[$k]));
            switch ($v['type']) {
                case 'textarea':
                    echo form_textarea(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
                    break;
                case 'number':
                    echo form_input(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
                    break;
                case 'dropdown':
                    $opt = array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k]))));
                    
                    $opt = $form->implodeAssoc(' ', $opt);
                    echo form_dropdown($v['name'], $v['options'], $v['value'], $opt);
                    break;
                case 'multiselect':
                    echo form_multiselect(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
                    break;
                case 'checkbox':
                    echo form_checkbox(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
                    break;
                case 'radiobutton':
                    echo form_radio(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
                    break;
                case 'date':
                    echo form_input(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
                    break;
                case 'file':
                    echo form_upload(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
                    break;
                default:
                    echo form_input(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
            }
            ?>

        </p>

    <?php endforeach; ?>
</fieldset>
</form>

<script>
    $("#<?php echo $form->id; ?>").validate({
        meta: "validate",
        debug:true
    });
</script>