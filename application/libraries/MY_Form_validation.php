<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

    function __construct()
    {
        $this->CI = & get_instance();
    }

    function cm_unique_check($value, $str)
    {
        $str = explode(':', $str);
        $table = $str[0];
        $field = $str[1];
        $item_id = isset($str[2]) ? $str[2] : NULL;

        if ($this->CI->Carbo_model->get_duplicate($table, $field, $value, $item_id))
        {
            return TRUE;
        }
        else
        {
            //$this->set_message('unique', sprintf(lang('cm_validation_unique'), $this->[]));
            return FALSE;
        }
    }

}
/* End of file MY_Form_validation.php */
/* Location: ./system/application/libraries/MY_Form_validation.php */
