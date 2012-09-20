<?php $this->load->helper('form'); ?>
<?php
//print_r($form->elements);
//die("xx");
?>

<?php echo form_open($form->action, $form->form_params); ?>
<h3 class="ui-widget ui-widget-header ui-corner-all"><span>Form Detail</span></h3>
<fieldset class="ui-widget-content">
    <legend>Fields with remark (*) is required.</legend>
    <?php foreach ($form->elements as $k => $v): ?>
        <p>
            <?php echo form_label($v['label'] . " " . ($form->validation[$k]['validate']['required'] == true ? "*" : ""), $v['name']) ?>
            <?php
            //echo str_replace('"', '', json_encode($form->validation[$k]));
            switch ($v['type'])
            {
                case 'number':
                    echo form_input(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
                    break;
                case 'select':
                    echo form_input($v);
                    break;
                case 'checkbox':
                    echo form_input($v);
                    break;
                case 'radiobutton':
                    echo form_input($v);
                    break;
                case 'date':
                    echo form_input($v);
                    break;
                default:
                    echo form_input(array_merge($v, array('class' => str_replace('"', '', json_encode($form->validation[$k])))));
            }
            ?>

        </p>
    <?php endforeach; ?>
    <p>
        <label></label>
        <input type="submit" value="Submit" />
    </p>
</fieldset>
</form>

<script>
    $(function() {
        $( "input:submit, button").button();
    });
    $("#<?php echo $form->id; ?>").validate({
        meta: "validate",
        submitHandler: function(form) {
            jQuery(form).ajaxSubmit({
                //target: "#result"
            });
        }
    });
</script>