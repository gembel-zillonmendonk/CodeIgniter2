<?php $this->load->helper('form'); ?>
<?php $i = 1; ?>
<div class="row-fluid">
    <div class="span6">
        <?php foreach ($form->elements as $k => $v): ?>
        
        <?php 
        if(isset($read_only) && $read_only == true):
            $v['readonly'] = 'readonly';
        endif; 
        ?>
            <div class="control-group">
                <?php echo form_label($v['label'] . " " . ($form->validation[$k]['validate']['required'] == true ? "*" : ""), $v['id'], array("class" => "control-label")) ?>
                <div class="controls">
                    <?php
                    $v['class'] = (isset($v['class']) ? $v['class'] : ' ' ) . ' ' . str_replace('"', '', json_encode($form->validation[$k]));

                    switch ($v['type']) {
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
                </div>
            </div>
            <?php if ($i % 5 == 0): ?>
            </div>
            <div class="span6">
            <?php endif; ?>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>
</div>