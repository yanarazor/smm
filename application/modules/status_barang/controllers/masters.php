<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * masters controller
 */
class masters extends Admin_Controller
{

	//--------------------------------------------------------------------


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Status_Barang.Masters.View');
		$this->load->model('status_barang_model', null, true);
		$this->lang->load('status_barang');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('status_barang', 'status_barang.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->status_barang_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('status_barang_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('status_barang_delete_failure') . $this->status_barang_model->error, 'error');
				}
			}
		}

		$records = $this->status_barang_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Status Barang');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Status Barang object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Status_Barang.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_status_barang())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_barang_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'status_barang');

				Template::set_message(lang('status_barang_create_success'), 'success');
				redirect(SITE_AREA .'/masters/status_barang');
			}
			else
			{
				Template::set_message(lang('status_barang_create_failure') . $this->status_barang_model->error, 'error');
			}
		}
		Assets::add_module_js('status_barang', 'status_barang.js');

		Template::set('toolbar_title', lang('status_barang_create') . ' Status Barang');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Status Barang data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('status_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/status_barang');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Status_Barang.Masters.Edit');

			if ($this->save_status_barang('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_barang_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'status_barang');

				Template::set_message(lang('status_barang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('status_barang_edit_failure') . $this->status_barang_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Status_Barang.Masters.Delete');

			if ($this->status_barang_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_barang_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'status_barang');

				Template::set_message(lang('status_barang_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/status_barang');
			}
			else
			{
				Template::set_message(lang('status_barang_delete_failure') . $this->status_barang_model->error, 'error');
			}
		}
		Template::set('status_barang', $this->status_barang_model->find($id));
		Template::set('toolbar_title', lang('status_barang_edit') .' Status Barang');
		Template::render();
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_status_barang($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['status']        = $this->input->post('status_barang_status');

		if ($type == 'insert')
		{
			$id = $this->status_barang_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			}
			else
			{
				$return = FALSE;
			}
		}
		elseif ($type == 'update')
		{
			$return = $this->status_barang_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}