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

		$this->auth->restrict('Sub_Bidang.Masters.View');
		$this->load->model('sub_bidang_model', null, true);
		$this->lang->load('sub_bidang');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('sub_bidang', 'sub_bidang.js');
		$this->load->model('bidang/bidang_model', null, true);
		$bidangs = $this->bidang_model->find_all();
		Template::set('bidangs', $bidangs);
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
					$result = $this->sub_bidang_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('sub_bidang_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('sub_bidang_delete_failure') . $this->sub_bidang_model->error, 'error');
				}
			}
		}

		$records = $this->sub_bidang_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Kelola Sub Bidang');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Sub Bidang object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Sub_Bidang.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_sub_bidang())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('sub_bidang_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'sub_bidang');

				Template::set_message(lang('sub_bidang_create_success'), 'success');
				redirect(SITE_AREA .'/masters/sub_bidang');
			}
			else
			{
				Template::set_message(lang('sub_bidang_create_failure') . $this->sub_bidang_model->error, 'error');
			}
		}
		Assets::add_module_js('sub_bidang', 'sub_bidang.js');

		Template::set('toolbar_title', lang('sub_bidang_create') . ' Sub Bidang');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Sub Bidang data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('sub_bidang_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/sub_bidang');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Sub_Bidang.Masters.Edit');

			if ($this->save_sub_bidang('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('sub_bidang_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'sub_bidang');

				Template::set_message(lang('sub_bidang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('sub_bidang_edit_failure') . $this->sub_bidang_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Sub_Bidang.Masters.Delete');

			if ($this->sub_bidang_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('sub_bidang_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'sub_bidang');

				Template::set_message(lang('sub_bidang_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/sub_bidang');
			}
			else
			{
				Template::set_message(lang('sub_bidang_delete_failure') . $this->sub_bidang_model->error, 'error');
			}
		}
		Template::set('sub_bidang', $this->sub_bidang_model->find($id));
		Template::set('toolbar_title', lang('sub_bidang_edit') .' Sub Bidang');
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
	private function save_sub_bidang($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nama_subbid']        = $this->input->post('sub_bidang_nama_subbid');
		$data['kasubid']        = $this->input->post('sub_bidang_kasubid');
		$data['id_bidang']        = $this->input->post('sub_bidang_id_bidang');

		if ($type == 'insert')
		{
			$id = $this->sub_bidang_model->insert($data);

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
			$return = $this->sub_bidang_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}