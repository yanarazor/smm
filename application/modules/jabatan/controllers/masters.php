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

		$this->auth->restrict('Jabatan.Masters.View');
		$this->load->model('jabatan_model', null, true);
		$this->lang->load('jabatan');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('jabatan', 'jabatan.js');
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
					$result = $this->jabatan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('jabatan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('jabatan_delete_failure') . $this->jabatan_model->error, 'error');
				}
			}
		}

		$records = $this->jabatan_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Jabatan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Jabatan object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Jabatan.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_jabatan())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jabatan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'jabatan');

				Template::set_message(lang('jabatan_create_success'), 'success');
				redirect(SITE_AREA .'/masters/jabatan');
			}
			else
			{
				Template::set_message(lang('jabatan_create_failure') . $this->jabatan_model->error, 'error');
			}
		}
		Assets::add_module_js('jabatan', 'jabatan.js');

		Template::set('toolbar_title', lang('jabatan_create') . ' Jabatan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Jabatan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('jabatan_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/jabatan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Jabatan.Masters.Edit');

			if ($this->save_jabatan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jabatan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'jabatan');

				Template::set_message(lang('jabatan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('jabatan_edit_failure') . $this->jabatan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Jabatan.Masters.Delete');

			if ($this->jabatan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jabatan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'jabatan');

				Template::set_message(lang('jabatan_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/jabatan');
			}
			else
			{
				Template::set_message(lang('jabatan_delete_failure') . $this->jabatan_model->error, 'error');
			}
		}
		Template::set('jabatan', $this->jabatan_model->find($id));
		Template::set('toolbar_title', lang('jabatan_edit') .' Jabatan');
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
	private function save_jabatan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nama_jabatan']        = $this->input->post('jabatan_nama_jabatan');
		$data['kelas_jabatan']        = $this->input->post('jabatan_kelas_jabatan');
		$data['tukin']        = $this->input->post('jabatan_tukin');

		if ($type == 'insert')
		{
			$id = $this->jabatan_model->insert($data);

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
			$return = $this->jabatan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}