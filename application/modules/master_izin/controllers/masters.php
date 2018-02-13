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

		$this->auth->restrict('Master_Izin.Masters.View');
		$this->load->model('master_izin_model', null, true);
		$this->lang->load('master_izin');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('master_izin', 'master_izin.js');
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
					$result = $this->master_izin_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('master_izin_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('master_izin_delete_failure') . $this->master_izin_model->error, 'error');
				}
			}
		}

		$records = $this->master_izin_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Master Izin');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Master Izin object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Master_Izin.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_master_izin())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('master_izin_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'master_izin');

				Template::set_message(lang('master_izin_create_success'), 'success');
				redirect(SITE_AREA .'/masters/master_izin');
			}
			else
			{
				Template::set_message(lang('master_izin_create_failure') . $this->master_izin_model->error, 'error');
			}
		}
		Assets::add_module_js('master_izin', 'master_izin.js');

		Template::set('toolbar_title', lang('master_izin_create') . ' Master Izin');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Master Izin data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('master_izin_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/master_izin');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Master_Izin.Masters.Edit');

			if ($this->save_master_izin('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('master_izin_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'master_izin');

				Template::set_message(lang('master_izin_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('master_izin_edit_failure') . $this->master_izin_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Master_Izin.Masters.Delete');

			if ($this->master_izin_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('master_izin_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'master_izin');

				Template::set_message(lang('master_izin_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/master_izin');
			}
			else
			{
				Template::set_message(lang('master_izin_delete_failure') . $this->master_izin_model->error, 'error');
			}
		}
		Template::set('master_izin', $this->master_izin_model->find($id));
		Template::set('toolbar_title', lang('master_izin_edit') .' Master Izin');
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
	private function save_master_izin($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nama_izin']        = $this->input->post('master_izin_nama_izin');

		if ($type == 'insert')
		{
			$id = $this->master_izin_model->insert($data);

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
			$return = $this->master_izin_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}