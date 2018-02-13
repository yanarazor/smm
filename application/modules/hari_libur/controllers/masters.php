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

		$this->auth->restrict('Hari_Libur.Masters.View');
		$this->load->model('hari_libur_model', null, true);
		$this->lang->load('hari_libur');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('hari_libur', 'hari_libur.js');
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
					$result = $this->hari_libur_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('hari_libur_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('hari_libur_delete_failure') . $this->hari_libur_model->error, 'error');
				}
			}
		}

		$records = $this->hari_libur_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Hari Libur');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Hari Libur object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Hari_Libur.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_hari_libur())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('hari_libur_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'hari_libur');

				Template::set_message(lang('hari_libur_create_success'), 'success');
				redirect(SITE_AREA .'/masters/hari_libur');
			}
			else
			{
				Template::set_message(lang('hari_libur_create_failure') . $this->hari_libur_model->error, 'error');
			}
		}
		Assets::add_module_js('hari_libur', 'hari_libur.js');

		Template::set('toolbar_title', lang('hari_libur_create') . ' Hari Libur');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Hari Libur data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('hari_libur_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/hari_libur');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Hari_Libur.Masters.Edit');

			if ($this->save_hari_libur('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('hari_libur_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'hari_libur');

				Template::set_message(lang('hari_libur_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('hari_libur_edit_failure') . $this->hari_libur_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Hari_Libur.Masters.Delete');

			if ($this->hari_libur_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('hari_libur_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'hari_libur');

				Template::set_message(lang('hari_libur_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/hari_libur');
			}
			else
			{
				Template::set_message(lang('hari_libur_delete_failure') . $this->hari_libur_model->error, 'error');
			}
		}
		Template::set('hari_libur', $this->hari_libur_model->find($id));
		Template::set('toolbar_title', lang('hari_libur_edit') .' Hari Libur');
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
	private function save_hari_libur($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['tanggal']        = $this->input->post('hari_libur_tanggal') ? $this->input->post('hari_libur_tanggal') : '0000-00-00';
		$data['keterangan']        = $this->input->post('hari_libur_keterangan');

		if ($type == 'insert')
		{
			$id = $this->hari_libur_model->insert($data);

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
			$return = $this->hari_libur_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}