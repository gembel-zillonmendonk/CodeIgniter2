<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carbogrid
{
	public $id = 'datagrid';
	public $url = '';
	public $params = '';
	public $add = '';
	public $edit = '';
	public $delete = '';
	public $total = 0;
	public $limit = 10;
	public $offset = 0;
	public $pagination_links = 5;
	public $max_cell_length = 50;

	public $order_string = NULL;
	public $filter_string = 'all';
	public $column_string = 'all';

	public $filters_set = array();
	public $order = array();
	public $limits = array(5 => 5, 10 => 10, 20 => 20, 50 => 50);

	public $fields = array();
	public $data = array();
	public $columns_visible = array();
	public $actions = array();

	public $show_col_list = FALSE;

	public $page_max = 0;
	public $page_curr = 1;
	public $page_start = 1;
	public $page_nr = 0;

	public $first_link;
	public $prev_link;
	public $next_link;
	public $last_link;
	public $page_links = array();

	public $item_start = 0;
	public $item_end = 0;

	public $form_js = NULL;

	public $filter_nr = 0; // Number of filters, if none, we render no filter row
	public $headers = array();
	public $ajax = TRUE;

	// Default field settings
	private $field = array(
		'name'		=> FALSE,
		'order'		=> FALSE,
		'type'		=> FALSE,
		'header'	=> FALSE,
		'filter'	=> FALSE
	);
	// Default action settings
	private $action = array(
		'name'		=> '',
		'alias'		=> '',
		'url'		=> '',
		'icon'		=> '',
		'toolbar'	=> FALSE,
		'multi'		=> FALSE,
		'grid'		=> TRUE,
		'ajax'		=> TRUE
	);

	function __construct($params = array())
	{
		$this->CI = & get_instance();

		$this->CI->load->language('carbogrid');

		// Set parameters
		foreach ($params as $key => $value)
		{
			$this->$key = $value;
		}

		// Set default actions
		$def_actions = array();
		if ($this->add)
		{
			$def_actions['add'] = array('name' => lang('carbogrid_add'), 'alias' => 'add', 'url' => $this->add, 'icon' => 'ui-icon-circle-plus', 'toolbar' => TRUE, 'grid' => FALSE);
		}
		if ($this->delete)
		{
			$def_actions['delete'] = array('name' => lang('carbogrid_delete'), 'alias' => 'delete', 'url' => $this->delete, 'icon' => 'ui-icon-trash', 'toolbar' => TRUE, 'multi' => TRUE);
		}
		if ($this->edit)
		{
			$def_actions['edit'] = array('name' => lang('carbogrid_edit'), 'alias' => 'edit', 'url' => $this->edit, 'icon' => 'ui-icon-pencil');
		}
		$this->actions = array_merge($def_actions, $this->actions);

		foreach ($this->actions as $key => $value)
		{
			$this->actions[$key] = array_merge($this->action, $value);

			// Peform action if posted
			if ($this->CI->input->post($value['alias']) !== FALSE)
			{
				$action_url = $value['url'];
				$item_ids = $this->CI->input->post('item_ids');
				// Add the selected ids as params
				if ($value['multi'] === TRUE)
				{
					if (is_array($item_ids))
					{
						redirect(rtrim($action_url, '/') . '/' . implode(',', $item_ids));
						return FALSE;
					}
				}
				else
				{
					redirect($action_url);
					return FALSE;
				}
			}
		}

		// Ensure trailing slash to the url end
		$this->url = rtrim($this->url, '/') . '/';

		// Setup headers, all columns are visible by default
		$i = 2;
		$this->filter_nr = 0;
		foreach ($this->fields as $key => $field)
		{
			$field = array_merge($this->field, $field);

			// Count filters
			if ($field['filter'] !== FALSE)
			{
				$this->filter_nr++;
			}
			$this->headers[$field['order']] = $field['header'];
			$this->columns_visible[] = $i;
			$i++;
		}

		// Show columns visibility list
		if ($this->CI->input->post('columns') !== FALSE)
		{
			$this->show_col_list = TRUE;
		}

		// Init visible columns array
		if ($this->CI->input->post('columns_list') !== FALSE)
		{
			$this->columns_visible = $this->CI->input->post('columns_visible');
			$this->column_string = (count($this->columns_visible) == count($this->headers)) ? 'all' : implode(',', $this->columns_visible);
			if (!$this->is_ajax())
			{
				redirect($this->url . $this->limit . '/' . $this->offset . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string);
				return FALSE;
			}
			$this->show_col_list = FALSE;
		}
		elseif ($this->column_string != 'all')
		{
			$this->columns_visible = explode(',', $this->column_string);
		}

		if ($this->CI->input->post('change_page_size') !== FALSE)
		{
			$this->limit = $this->CI->input->post('limit');
			redirect($this->url . $this->limit . '/' . $this->offset . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string);
			return FALSE;
		}

		if ($this->CI->input->post('apply_filter') !== FALSE)
		{
			foreach ($this->fields as $key => $field)
			{
				if (($value = $this->CI->input->post($field['name'])) !== FALSE && ($value !== ''))
				{
					$this->filters_set[$field['name']] = $value;
				}
			}
			$this->filter_string = count($this->filters_set) ? $this->paramsencode($this->filters_set) : 'all';
			if (!$this->is_ajax())
			{
				redirect($this->url . $this->limit . '/0/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string);
				return FALSE;
			}
		}
		elseif ($this->filter_string != 'all')
		{
			try
			{
				$this->filters_set = $this->paramsdecode($this->filter_string);
			}
			catch (Exception $ex)
			{
				$this->filters_set = array();
			}
		}
		else
		{
			$this->filters_set = array();
		}

		// Set order
		if (!is_null($this->order_string))
		{
			$order = explode('+', $this->order_string);
			$ord = array();
			foreach ($order as $o)
			{
				$o = explode(':', $o);
				if (array_key_exists($o[0], $this->headers))
				{
					if (!isset($o[1]) OR ($o[1] != 'desc'))
					{
						$ord[$o[0]] = 'ASC';
					}
					else
					{
						$ord[$o[0]] = 'DESC';
					}
				}
			}
			$this->order = $ord;
		}
	}

	function render()
	{
		// Calculate page numbers and pagination links
		if (!$this->limit)
		{
			$this->limit = 10;
		}
		$this->page_max = ceil($this->total / $this->limit);
		$this->page_curr = ceil(($this->offset + 1) / $this->limit);
		$this->page_curr = ($this->page_curr > $this->page_max) ? $this->page_max : $this->page_curr;
		$this->page_curr = ($this->page_curr < 1) ? 1 : $this->page_curr;
		$this->page_start = (($this->page_curr - ceil($this->pagination_links / 2) + 1) < 1) ? 1 : ($this->page_curr - ceil($this->pagination_links / 2) + 1);
		$this->page_nr = ($this->page_start + $this->pagination_links < $this->page_max) ? $this->page_start + $this->pagination_links : $this->page_max + 1;
		$this->offset = ($this->page_curr - 1) * $this->limit;
		$this->item_start = ($this->total > 0) ? $this->offset + 1 : 0;
		$this->item_end = ($this->offset + $this->limit > $this->total) ? $this->total : $this->offset + $this->limit;

		$this->first_link = $this->url . ($this->params ? ($this->params . '/') : ''). $this->limit . '/' . ($this->page_curr - 2) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string . '#' . ($this->params ? ($this->params . '/') : '') . $this->limit . '/' . ($this->page_curr - 2) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string;
		$this->prev_link = $this->url . ($this->params ? ($this->params . '/') : ''). $this->limit . '/' . ($this->page_curr - 2) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string . '#' . ($this->params ? ($this->params . '/') : '') . $this->limit . '/' . ($this->page_curr - 2) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string;
		$this->next_link = $this->url . ($this->params ? ($this->params . '/') : ''). $this->limit . '/' . ($this->page_curr) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string . '#' . ($this->params ? ($this->params . '/') : '') . $this->limit . '/' . ($this->page_curr) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string;
		$this->last_link = $this->url . ($this->params ? ($this->params . '/') : ''). $this->limit . '/' . ($this->page_max) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string . '#' . ($this->params ? ($this->params . '/') : '') . $this->limit . '/' . ($this->page_curr) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string;

		for ($i = $this->page_start; $i < $this->page_nr; $i++)
		{
			$this->page_links[$i] = ($i == $this->page_curr) ? '' : ($this->url . ($this->params ? ($this->params . '/') : ''). $this->limit . '/' . ($i - 1) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string . '#' . ($this->params ? ($this->params . '/') : '') . $this->limit . '/' . ($i - 1) * $this->limit . '/' . $this->column_string . '/' . $this->order_string . '/' . $this->filter_string);
		}

		// Export to PDF
		if ($this->CI->input->post('export') !== FALSE)
		{
			$this->CI->load->plugin('dompdf');
			$dompdf = new DOMPDF();
			$html =  $this->CI->load->view('carbogrid/datagrid_print', array('grid' => $this), TRUE);
			//echo $html;
			$dompdf->load_html($html);
			$dompdf->render();
			$dompdf->stream('datagrid.pdf');
		}
		else
		{
			$this->CI->load->view('carbogrid/datagrid', array('grid' => $this));
		}
	}

	function is_ajax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}

	function paramsencode($params)
	{
		return strtr(base64_encode(@serialize($params)), '+/=', '-_~');
	}

	function paramsdecode($params)
	{
		return @unserialize(base64_decode(strtr($params, '-_~', '+/=')));
	}

}

/* End of file Grid.php */
/* Location: ./system/application/libraries/Grid.php */
