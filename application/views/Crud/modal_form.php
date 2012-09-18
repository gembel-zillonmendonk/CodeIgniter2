<style>

    /**********************************

Use: cmxform template

***********************************/
    form.cmxform fieldset {
        margin-bottom: 10px;
    }

    form.cmxform legend {
        padding: 0 2px;
        font-weight: bold;
        _margin: 0 -7px; /* IE Win */
    }

    form.cmxform label {
        display: inline-block;
        line-height: 1.8;
        vertical-align: top;
        cursor: hand;
    }

    form.cmxform fieldset p {
        list-style: none;
        padding: 5px;
        margin: 0;
    }

    form.cmxform fieldset fieldset {
        border: none;
        margin: 3px 0 0;
    }

    form.cmxform fieldset fieldset legend {
        padding: 0 0 5px;
        font-weight: normal;
    }

    form.cmxform fieldset fieldset label {
        display: block;
        width: auto;
    }

    form.cmxform label { width: 100px; } /* Width of labels */
    form.cmxform fieldset fieldset label { margin-left: 103px; } /* Width plus 3 (html space) */
    form.cmxform label.error {
        margin-left: 103px;
        width: 220px;
    }

    form.cmxform input.submit {
        margin-left: 103px;
    }

    /*\*//*/ form.cmxform legend { display: inline-block; } /* IE Mac legend fix */

</style>

<?php $this->load->helper('form'); ?>
<?php echo form_open('crud/modal_form/' . $model->table, array('class' => 'cmxform')); ?>
<fieldset>
    <legend>Please provide your name, email address (won't be published) and a comment</legend>
    <?php foreach ($model->columns as $k => $v): ?>
        <p>
            <?php echo form_label($v['label'], $name . '-' . $v['name']) ?>
            <?php
            $prop = array(
                'name' => $model->table . '[' . $v['name'] . ']',
                'id' => $name . '-' . $v['name'],
                'maxlength' => $v['size'],
                'style' => 'width:100%',
                'size' => $v['size'],
                'value' => (isset($model->attributes[$k]) ? $model->attributes[$k] : $v['default_value']),
            );

            /*
              if ($v['allow_null'])
              $prop['required'] = "required";
             */
            switch ($v['type']) {
                case 'number':
                    echo form_input(array_merge($prop, array('class' => '{validate:{required:true,number:true}}')));
                    break;
                case 'number':
                    echo form_input($prop);
                    break;
                case 'number':
                    echo form_input($prop);
                    break;
                case 'number':
                    echo form_input($prop);
                    break;
                case 'number':
                    echo form_input($prop);
                    break;
                default:
                    echo form_input(array_merge($prop, array('class' => '{validate:{required:true,minlength:3}}')));
            }
            ?>

        </p>
    <?php endforeach; ?>
</fieldset>
</form>

<script>
    $("form").validate({
        meta: "validate",
        submitHandler: function(form) {
            jQuery(form).ajaxSubmit({
                //target: "#result"
            });
        }
    });
</script>