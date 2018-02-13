<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ptpp controller
 */
class ptpp extends Admin_Controller
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

		$this->auth->restrict('Status_Ptpp.Ptpp.View');
		$this->load->model('status_ptpp_model', null, true);
		$this->lang->load('status_ptpp');
		
		Template::set_block('sub_nav', 'ptpp/_sub_nav');

		Assets::add_module_js('status_ptpp', 'status_ptpp.js');
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
					$result = $this->status_ptpp_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('status_ptpp_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('status_ptpp_delete_failure') . $this->status_ptpp_model->error, 'error');
				}
			}
		}

		$records = $this->status_ptpp_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Kelola Status Ptpp');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Status Ptpp object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Status_Ptpp.Ptpp.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_status_ptpp())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_ptpp_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'status_ptpp');

				Template::set_message(lang('status_ptpp_create_success'), 'success');
				redirect(SITE_AREA .'/ptpp/status_ptpp');
			}
			else
			{
				Template::set_message(lang('status_ptpp_create_failure') . $this->status_ptpp_model->error, 'error');
			}
		}
		Assets::add_module_js('status_ptpp', 'status_ptpp.js');

		Template::set('toolbar_title', lang('status_ptpp_create') . ' Status Ptpp');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Status Ptpp data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('status_ptpp_invalid_id'), 'error');
			redirect(SITE_AREA .'/ptpp/status_ptpp');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Status_Ptpp.Ptpp.Edit');

			if ($this->save_status_ptpp('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_ptpp_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'status_ptpp');

				Template::set_message(lang('status_ptpp_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('status_ptpp_edit_failure') . $this->status_ptpp_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Status_Ptpp.Ptpp.Delete');

			if ($this->status_ptpp_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('status_ptpp_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'status_ptpp');

				Template::set_message(lang('status_ptpp_delete_success'), 'success');

				redirect(SITE_AREA .'/ptpp/status_ptpp');
			}
			else
			{
				Template::set_message(lang('status_ptpp_delete_failure') . $this->status_ptpp_model->error, 'error');
			}
		}
		Template::set('status_ptpp', $this->status_ptpp_model->find($id));
		Template::set('toolbar_title', lang('status_ptpp_edit') .' Status Ptpp');
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
	private function save_status_ptpp($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['status']        = $this->input->post('status_ptpp_status');

		if ($type == 'insert')
		{
			$id = $this->status_ptpp_model->insert($data);

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
			$return = $this->status_ptpp_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}