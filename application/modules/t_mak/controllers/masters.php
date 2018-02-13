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

		$this->auth->restrict('T_mak.Masters.View');
		$this->load->model('t_mak_model', null, true);
		$this->lang->load('t_mak');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('t_mak', 't_mak.js');
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
					$result = $this->t_mak_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('t_mak_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('t_mak_delete_failure') . $this->t_mak_model->error, 'error');
				}
			}
		}

		$records = $this->t_mak_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage t mak');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a t mak object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('T_mak.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_t_mak())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('t_mak_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 't_mak');

				Template::set_message(lang('t_mak_create_success'), 'success');
				redirect(SITE_AREA .'/masters/t_mak');
			}
			else
			{
				Template::set_message(lang('t_mak_create_failure') . $this->t_mak_model->error, 'error');
			}
		}
		Assets::add_module_js('t_mak', 't_mak.js');

		Template::set('toolbar_title', lang('t_mak_create') . ' t mak');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of t mak data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('t_mak_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/t_mak');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('T_mak.Masters.Edit');

			if ($this->save_t_mak('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('t_mak_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 't_mak');

				Template::set_message(lang('t_mak_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('t_mak_edit_failure') . $this->t_mak_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('T_mak.Masters.Delete');

			if ($this->t_mak_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('t_mak_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 't_mak');

				Template::set_message(lang('t_mak_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/t_mak');
			}
			else
			{
				Template::set_message(lang('t_mak_delete_failure') . $this->t_mak_model->error, 'error');
			}
		}
		Template::set('t_mak', $this->t_mak_model->find($id));
		Template::set('toolbar_title', lang('t_mak_edit') .' t mak');
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
	private function save_t_mak($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['kdmak']        = $this->input->post('t_mak_kdmak');
		$data['nmmak']        = $this->input->post('t_mak_nmmak');

		if ($type == 'insert')
		{
			$id = $this->t_mak_model->insert($data);

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
			$return = $this->t_mak_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}