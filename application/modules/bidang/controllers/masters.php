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

		$this->auth->restrict('Bidang.Masters.View');
		$this->load->model('bidang_model', null, true);
		$this->lang->load('bidang');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('bidang', 'bidang.js');
		$this->load->model('user/user_model', null, true);
		$users = $this->user_model->find_all();
		Template::set('users', $users);
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
					$result = $this->bidang_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('bidang_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('bidang_delete_failure') . $this->bidang_model->error, 'error');
				}
			}
		}

		$records = $this->bidang_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Kelola Bidang');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Bidang object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Bidang.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_bidang())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('bidang_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'bidang');

				Template::set_message(lang('bidang_create_success'), 'success');
				redirect(SITE_AREA .'/masters/bidang');
			}
			else
			{
				Template::set_message(lang('bidang_create_failure') . $this->bidang_model->error, 'error');
			}
		}
		Assets::add_module_js('bidang', 'bidang.js');

		Template::set('toolbar_title', lang('bidang_create') . ' Bidang');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Bidang data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('bidang_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/bidang');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Bidang.Masters.Edit');

			if ($this->save_bidang('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('bidang_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'bidang');

				Template::set_message(lang('bidang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('bidang_edit_failure') . $this->bidang_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Bidang.Masters.Delete');

			if ($this->bidang_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('bidang_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'bidang');

				Template::set_message(lang('bidang_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/bidang');
			}
			else
			{
				Template::set_message(lang('bidang_delete_failure') . $this->bidang_model->error, 'error');
			}
		}
		Template::set('bidang', $this->bidang_model->find($id));
		Template::set('toolbar_title', lang('bidang_edit') .' Bidang');
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
	private function save_bidang($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['bidang']        = $this->input->post('bidang_bidang');
		$data['kabid']        = $this->input->post('bidang_kabid');

		if ($type == 'insert')
		{
			$id = $this->bidang_model->insert($data);

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
			$return = $this->bidang_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}