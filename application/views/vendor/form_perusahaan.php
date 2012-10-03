<?php $this->load->helper('form'); ?>
<?php echo form_open($form->action, $form->form_params); ?>
<!--<h3 class="ui-widget ui-widget-header ui-corner-all"><span>Form Detail</span></h3>-->
<fieldset class="ui-widget-content">
    <legend>Fields with remark (*) is required.</legend>
    <?php foreach ($form->elements as $k => $v): ?>
        <p>
            <?php echo form_label($v['label'] . " " . ($form->validation[$k]['validate']['required'] == true ? "*" : ""), $v['id']) ?>
            <?php
            //echo str_replace('"', '', json_encode($form->validation[$k]));


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
    <p>
        <?php echo form_label("TIPE PERUSAHAAN *", "id_tipe_perusahaan") ?>
        <?php echo form_multiselect("EP_VENDOR_TIPE[TIPE_VENDOR][]", 
                $form->model->elements_conf['VENDOR_TIPE']['options'],
                $form->model->elements_conf['VENDOR_TIPE']['value'],
                'id="id_tipe_perusahaan" class="{validate:{required:true,maxlength:255}}"'); ?>
    </p>
    
    <p>
        <label></label>
        <input type="submit" value="Submit" />
    </p>
</fieldset>
</form>

<script>
    $(function() {
        $( "input:submit, button").button();
        $( ".datepicker" ).datepicker();
        //$( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        
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