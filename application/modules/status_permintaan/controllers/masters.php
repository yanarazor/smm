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

		$this->auth->restrict('Status_Permintaan.Masters.View');
		$this->load->model('status_permintaan_model', null, true);
		$this->lang->load('status_permintaan');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('status_permintaan', 'status_permintaan.js');
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
					$result = $this->status_permintaan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('status_permintaan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('status_permintaan_delete_failure') . $this->status_permintaan_model->error, 'error');
				}
			}
		}

		$records = $this->status_permintaan_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Status Permintaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Status Permintaan object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Status_Permintaan.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_status_permintaan())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_permintaan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'status_permintaan');

				Template::set_message(lang('status_permintaan_create_success'), 'success');
				redirect(SITE_AREA .'/masters/status_permintaan');
			}
			else
			{
				Template::set_message(lang('status_permintaan_create_failure') . $this->status_permintaan_model->error, 'error');
			}
		}
		Assets::add_module_js('status_permintaan', 'status_permintaan.js');

		Template::set('toolbar_title', lang('status_permintaan_create') . ' Status Permintaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Status Permintaan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('status_permintaan_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/status_permintaan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Status_Permintaan.Masters.Edit');

			if ($this->save_status_permintaan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_permintaan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'status_permintaan');

				Template::set_message(lang('status_permintaan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('status_permintaan_edit_failure') . $this->status_permintaan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Status_Permintaan.Masters.Delete');

			if ($this->status_permintaan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_permintaan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'status_permintaan');

				Template::set_message(lang('status_permintaan_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/status_permintaan');
			}
			else
			{
				Template::set_message(lang('status_permintaan_delete_failure') . $this->status_permintaan_model->error, 'error');
			}
		}
		Template::set('status_permintaan', $this->status_permintaan_model->find($id));
		Template::set('toolbar_title', lang('status_permintaan_edit') .' Status Permintaan');
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
	private function save_status_permintaan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nama_status']        = $this->input->post('status_permintaan_nama_status');

		if ($type == 'insert')
		{
			$id = $this->status_permintaan_model->insert($data);

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
			$return = $this->status_permintaan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}