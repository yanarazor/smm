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

		$this->auth->restrict('Status_pemeliharaan.Masters.View');
		$this->load->model('status_pemeliharaan_model', null, true);
		$this->lang->load('status_pemeliharaan');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('status_pemeliharaan', 'status_pemeliharaan.js');
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
					$result = $this->status_pemeliharaan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('status_pemeliharaan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('status_pemeliharaan_delete_failure') . $this->status_pemeliharaan_model->error, 'error');
				}
			}
		}

		$records = $this->status_pemeliharaan_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage status pemeliharaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a status pemeliharaan object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Status_pemeliharaan.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_status_pemeliharaan())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_pemeliharaan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'status_pemeliharaan');

				Template::set_message(lang('status_pemeliharaan_create_success'), 'success');
				redirect(SITE_AREA .'/masters/status_pemeliharaan');
			}
			else
			{
				Template::set_message(lang('status_pemeliharaan_create_failure') . $this->status_pemeliharaan_model->error, 'error');
			}
		}
		Assets::add_module_js('status_pemeliharaan', 'status_pemeliharaan.js');

		Template::set('toolbar_title', lang('status_pemeliharaan_create') . ' status pemeliharaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of status pemeliharaan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('status_pemeliharaan_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/status_pemeliharaan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Status_pemeliharaan.Masters.Edit');

			if ($this->save_status_pemeliharaan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_pemeliharaan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'status_pemeliharaan');

				Template::set_message(lang('status_pemeliharaan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('status_pemeliharaan_edit_failure') . $this->status_pemeliharaan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Status_pemeliharaan.Masters.Delete');

			if ($this->status_pemeliharaan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_pemeliharaan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'status_pemeliharaan');

				Template::set_message(lang('status_pemeliharaan_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/status_pemeliharaan');
			}
			else
			{
				Template::set_message(lang('status_pemeliharaan_delete_failure') . $this->status_pemeliharaan_model->error, 'error');
			}
		}
		Template::set('status_pemeliharaan', $this->status_pemeliharaan_model->find($id));
		Template::set('toolbar_title', lang('status_pemeliharaan_edit') .' status pemeliharaan');
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
	private function save_status_pemeliharaan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['status_perbaikan']        = $this->input->post('status_pemeliharaan_status_perbaikan');

		if ($type == 'insert')
		{
			$id = $this->status_pemeliharaan_model->insert($data);

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
			$return = $this->status_pemeliharaan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}