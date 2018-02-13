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

		$this->auth->restrict('Status_Pengadaan.Masters.View');
		$this->load->model('status_pengadaan_model', null, true);
		$this->lang->load('status_pengadaan');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('status_pengadaan', 'status_pengadaan.js');
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
					$result = $this->status_pengadaan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('status_pengadaan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('status_pengadaan_delete_failure') . $this->status_pengadaan_model->error, 'error');
				}
			}
		}

		$records = $this->status_pengadaan_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Status Pengadaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Status Pengadaan object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Status_Pengadaan.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_status_pengadaan())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_pengadaan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'status_pengadaan');

				Template::set_message(lang('status_pengadaan_create_success'), 'success');
				redirect(SITE_AREA .'/masters/status_pengadaan');
			}
			else
			{
				Template::set_message(lang('status_pengadaan_create_failure') . $this->status_pengadaan_model->error, 'error');
			}
		}
		Assets::add_module_js('status_pengadaan', 'status_pengadaan.js');

		Template::set('toolbar_title', lang('status_pengadaan_create') . ' Status Pengadaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Status Pengadaan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('status_pengadaan_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/status_pengadaan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Status_Pengadaan.Masters.Edit');

			if ($this->save_status_pengadaan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_pengadaan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'status_pengadaan');

				Template::set_message(lang('status_pengadaan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('status_pengadaan_edit_failure') . $this->status_pengadaan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Status_Pengadaan.Masters.Delete');

			if ($this->status_pengadaan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_pengadaan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'status_pengadaan');

				Template::set_message(lang('status_pengadaan_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/status_pengadaan');
			}
			else
			{
				Template::set_message(lang('status_pengadaan_delete_failure') . $this->status_pengadaan_model->error, 'error');
			}
		}
		Template::set('status_pengadaan', $this->status_pengadaan_model->find($id));
		Template::set('toolbar_title', lang('status_pengadaan_edit') .' Status Pengadaan');
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
	private function save_status_pengadaan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['status_pengadaan']        = $this->input->post('status_pengadaan_status_pengadaan');

		if ($type == 'insert')
		{
			$id = $this->status_pengadaan_model->insert($data);

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
			$return = $this->status_pengadaan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}