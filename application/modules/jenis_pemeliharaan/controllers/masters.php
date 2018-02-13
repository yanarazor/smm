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

		$this->auth->restrict('Jenis_Pemeliharaan.Masters.View');
		$this->load->model('jenis_pemeliharaan_model', null, true);
		$this->lang->load('jenis_pemeliharaan');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');
		$this->load->model('users/user_model', null, true);
		$this->user_model->where('nip != ""');
		$this->user_model->order_by('display_name',"asc");
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		Assets::add_module_js('jenis_pemeliharaan', 'jenis_pemeliharaan.js');
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
					$result = $this->jenis_pemeliharaan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('jenis_pemeliharaan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('jenis_pemeliharaan_delete_failure') . $this->jenis_pemeliharaan_model->error, 'error');
				}
			}
		}

		$records = $this->jenis_pemeliharaan_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Jenis Pemeliharaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Jenis Pemeliharaan object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Jenis_Pemeliharaan.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_jenis_pemeliharaan())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jenis_pemeliharaan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'jenis_pemeliharaan');

				Template::set_message(lang('jenis_pemeliharaan_create_success'), 'success');
				redirect(SITE_AREA .'/masters/jenis_pemeliharaan');
			}
			else
			{
				Template::set_message(lang('jenis_pemeliharaan_create_failure') . $this->jenis_pemeliharaan_model->error, 'error');
			}
		}
		Assets::add_module_js('jenis_pemeliharaan', 'jenis_pemeliharaan.js');

		Template::set('toolbar_title', lang('jenis_pemeliharaan_create') . ' Jenis Pemeliharaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Jenis Pemeliharaan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('jenis_pemeliharaan_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/jenis_pemeliharaan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Jenis_Pemeliharaan.Masters.Edit');

			if ($this->save_jenis_pemeliharaan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jenis_pemeliharaan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'jenis_pemeliharaan');

				Template::set_message(lang('jenis_pemeliharaan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('jenis_pemeliharaan_edit_failure') . $this->jenis_pemeliharaan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Jenis_Pemeliharaan.Masters.Delete');

			if ($this->jenis_pemeliharaan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jenis_pemeliharaan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'jenis_pemeliharaan');

				Template::set_message(lang('jenis_pemeliharaan_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/jenis_pemeliharaan');
			}
			else
			{
				Template::set_message(lang('jenis_pemeliharaan_delete_failure') . $this->jenis_pemeliharaan_model->error, 'error');
			}
		}
		Template::set('jenis_pemeliharaan', $this->jenis_pemeliharaan_model->find($id));
		Template::set('toolbar_title', lang('jenis_pemeliharaan_edit') .' Jenis Pemeliharaan');
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
	private function save_jenis_pemeliharaan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['jenis']        = $this->input->post('jenis_pemeliharaan_jenis');
		$data['petugas']        = $this->input->post('jenis_pemeliharaan_petugas');
		$data['verifikasi2']        = $this->input->post('verifikasi2');

		if ($type == 'insert')
		{
			$id = $this->jenis_pemeliharaan_model->insert($data);

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
			$return = $this->jenis_pemeliharaan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}