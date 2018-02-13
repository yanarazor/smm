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

		$this->auth->restrict('Pangkat.Masters.View');
		$this->load->model('pangkat_model', null, true);
		$this->lang->load('pangkat');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('pangkat', 'pangkat.js');
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
					$result = $this->pangkat_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('pangkat_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('pangkat_delete_failure') . $this->pangkat_model->error, 'error');
				}
			}
		}

		$records = $this->pangkat_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Pangkat');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Pangkat object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Pangkat.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_pangkat())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pangkat_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'pangkat');

				Template::set_message(lang('pangkat_create_success'), 'success');
				redirect(SITE_AREA .'/masters/pangkat');
			}
			else
			{
				Template::set_message(lang('pangkat_create_failure') . $this->pangkat_model->error, 'error');
			}
		}
		Assets::add_module_js('pangkat', 'pangkat.js');

		Template::set('toolbar_title', lang('pangkat_create') . ' Pangkat');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Pangkat data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('pangkat_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/pangkat');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Pangkat.Masters.Edit');

			if ($this->save_pangkat('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pangkat_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'pangkat');

				Template::set_message(lang('pangkat_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('pangkat_edit_failure') . $this->pangkat_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Pangkat.Masters.Delete');

			if ($this->pangkat_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pangkat_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'pangkat');

				Template::set_message(lang('pangkat_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/pangkat');
			}
			else
			{
				Template::set_message(lang('pangkat_delete_failure') . $this->pangkat_model->error, 'error');
			}
		}
		Template::set('pangkat', $this->pangkat_model->find($id));
		Template::set('toolbar_title', lang('pangkat_edit') .' Pangkat');
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
	private function save_pangkat($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['pangkat']        = $this->input->post('pangkat_pangkat');
		$data['golongan']        = $this->input->post('pangkat_golongan');
		$data['pajak']        = $this->input->post('pangkat_pajak');

		if ($type == 'insert')
		{
			$id = $this->pangkat_model->insert($data);

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
			$return = $this->pangkat_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}