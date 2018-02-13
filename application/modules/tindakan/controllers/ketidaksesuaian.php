<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ketidaksesuaian controller
 */
class ketidaksesuaian extends Admin_Controller
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

		$this->auth->restrict('Tindakan.Ketidaksesuaian.View');
		$this->load->model('tindakan_model', null, true);
		$this->lang->load('tindakan');
		
		Template::set_block('sub_nav', 'ketidaksesuaian/_sub_nav');

		Assets::add_module_js('tindakan', 'tindakan.js');
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
					$result = $this->tindakan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('tindakan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('tindakan_delete_failure') . $this->tindakan_model->error, 'error');
				}
			}
		}

		$records = $this->tindakan_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Kelola Tindakan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Tindakan object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Tindakan.Ketidaksesuaian.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_tindakan())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('tindakan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'tindakan');

				Template::set_message(lang('tindakan_create_success'), 'success');
				redirect(SITE_AREA .'/ketidaksesuaian/tindakan');
			}
			else
			{
				Template::set_message(lang('tindakan_create_failure') . $this->tindakan_model->error, 'error');
			}
		}
		Assets::add_module_js('tindakan', 'tindakan.js');

		Template::set('toolbar_title', lang('tindakan_create') . ' Tindakan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Tindakan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('tindakan_invalid_id'), 'error');
			redirect(SITE_AREA .'/ketidaksesuaian/tindakan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Tindakan.Ketidaksesuaian.Edit');

			if ($this->save_tindakan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('tindakan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'tindakan');

				Template::set_message(lang('tindakan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('tindakan_edit_failure') . $this->tindakan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Tindakan.Ketidaksesuaian.Delete');

			if ($this->tindakan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('tindakan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'tindakan');

				Template::set_message(lang('tindakan_delete_success'), 'success');

				redirect(SITE_AREA .'/ketidaksesuaian/tindakan');
			}
			else
			{
				Template::set_message(lang('tindakan_delete_failure') . $this->tindakan_model->error, 'error');
			}
		}
		Template::set('tindakan', $this->tindakan_model->find($id));
		Template::set('toolbar_title', lang('tindakan_edit') .' Tindakan');
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
	private function save_tindakan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['tindakan']        = $this->input->post('tindakan_tindakan');

		if ($type == 'insert')
		{
			$id = $this->tindakan_model->insert($data);

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
			$return = $this->tindakan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}