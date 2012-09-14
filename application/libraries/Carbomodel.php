<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carbomodel
{
	public $language_id = 1;

	function __construct($params = array())
	{
		$this->CI = & get_instance();

		$this->CI->load->model('Carbo_model');

		$this->CI->load->language('carbomodel');
	}

	function create_grid($uris, $table, $limit, $offset, $cols, $order, $filter_string)
	{
		$fields = $this->CI->Carbo_model->get_table_fields($table, $this->language_id);
		$grid_fields = array();
		$i = 0;

		foreach ($fields as $alias => $field)
		{
			$grid_fields[$i] = array(
				'name'		=> $field->order_name,
				'type'		=> $field->type_id,
				'header'	=> $field->header_name
			);
			// Set orderable
			if ($field->orderable)
			{
				$grid_fields[$i]['order'] = $field->table_name . '.' . $field->order_name;
			}
			// Set up filters
			if (in_array($field->type_id, array(2)))
			{
				// Simple text filter
				$grid_fields[$i]['filter'] = 1;
			}
			$i++;
		}

		$params = array(
			'id' 				=> $table,
			'url' 				=> $uris['grid'],
			'add' 				=> $uris['add'],
			'edit' 				=> $uris['edit'],
			'delete'			=> $uris['delete'],
			'limit' 			=> $limit,
			'offset' 			=> $offset,
			'order_string' 		=> $order,
			'filter_string' 	=> $filter_string,
			'column_string'		=> $cols,
			'fields' 			=> $grid_fields,
			'form_js'			=> 'js/carbo.forms.js'
		);

		$this->CI->load->library('carbogrid', $params);

		$this->CI->load->language('carbogrid');

		$this->CI->carbogrid->total = $this->CI->Carbo_model->count_table_data($table, $fields, $this->CI->carbogrid->filters_set); //count($this->CI->Carbo_model->get_table_data($table, $fields, $this->language_id, $this->CI->carbogrid->filters_set));

		$this->CI->carbogrid->data = $this->CI->Carbo_model->get_table_data($table, $fields, NULL, $this->language_id, $this->CI->carbogrid->filters_set, $this->CI->carbogrid->limit, $this->CI->carbogrid->offset, $this->CI->carbogrid->order);

		return $this->CI->carbogrid;
	}

	function create_form($table, $item_id = NULL)
	{
		if ($this->CI->input->post('cancel') !== FALSE)
		{
			$data->result = TRUE;
			return $data;
		}

		$this->CI->load->library('form_validation');

		$data->fields = $this->CI->Carbo_model->get_table_fields($table, $this->language_id);

		$item_data = NULL;
		if (!is_null($item_id))
		{
			$item_data = $this->CI->Carbo_model->get_item($table, $data->fields, $item_id, $this->language_id);
		}

		foreach ($data->fields as $field)
		{
			$data->formdata[$field->field_name] = is_null($item_id) ? '' : $item_data->{$field->field_name};

			// Set up validation rules
			$validation = 'trim|xss_clean' . ($field->validation ? ('|' . $field->validation) : '');

			if ($field->type_id == 1)
			{
				$validation .= '|integer';
			}
			if (!is_null($field->min_length))
			{
				$validation .= '|min_length[' . $field->min_length . ']';
			}
			if (!is_null($field->max_length))
			{
				$validation .= '|max_length[' . $field->max_length . ']';
			}
			if ($field->required == 1)
			{
				$validation .= '|required';
			}
			if ($field->unique == 1)
			{
				$validation .= '|cm_unique_check[' . $table . ':' . $field->field_name . (is_null($item_id) ? '' : (':' . $item_id)) . ']';
			}

			$this->CI->form_validation->set_rules($field->field_name, $field->name, $validation);
		}

		$this->CI->form_validation->set_error_delimiters('<li>', '</li>');

		if ($this->CI->form_validation->run() !== FALSE)
		{
			$this->CI->Carbo_model->save_item($table, $data->fields, $this->language_id, $item_id, $item_data);
			$data->result = TRUE;
		}
		else
		{
			$data->result = FALSE;
		}

		return $data;
	}

	function create_confirm_form($table, $item_ids = NULL)
	{
		$this->CI->load->language('carbogrid');

		$data->multiple = (strpos($item_ids, ',') !== FALSE) ? '_multiple' : '';

		if ($this->CI->input->post('yes') !== FALSE)
		{
			$item_ids = explode(',', $item_ids);
			$this->CI->Carbo_model->delete_items($table, $item_ids);
			$data->result = TRUE;
		}
		elseif ($this->CI->input->post('no') !== FALSE)
		{
			$data->result = TRUE;
		}
		else
		{
			$data->result = FALSE;
		}

		return $data;
	}

	function is_ajax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}

}

/* End of file Carbomodel.php */
/* Location: ./system/application/libraries/Carbomodel.php */
