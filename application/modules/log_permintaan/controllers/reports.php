<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * reports controller
 */
class reports extends Admin_Controller
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

		$this->auth->restrict('Log_permintaan.Reports.View');
		$this->load->model('log_permintaan_model', null, true);
		$this->lang->load('log_permintaan');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');

		Assets::add_module_js('log_permintaan', 'log_permintaan.js');
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
					$result = $this->log_permintaan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('log_permintaan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('log_permintaan_delete_failure') . $this->log_permintaan_model->error, 'error');
				}
			}
		}

		$records = $this->log_permintaan_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage log permintaan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of log permintaan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('log_permintaan_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/log_permintaan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Log_permintaan.Reports.Edit');

			if ($this->save_log_permintaan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('log_permintaan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'log_permintaan');

				Template::set_message(lang('log_permintaan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('log_permintaan_edit_failure') . $this->log_permintaan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Log_permintaan.Reports.Delete');

			if ($this->log_permintaan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('log_permintaan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'log_permintaan');

				Template::set_message(lang('log_permintaan_delete_success'), 'success');

				redirect(SITE_AREA .'/reports/log_permintaan');
			}
			else
			{
				Template::set_message(lang('log_permintaan_delete_failure') . $this->log_permintaan_model->error, 'error');
			}
		}
		Template::set('log_permintaan', $this->log_permintaan_model->find($id));
		Template::set('toolbar_title', lang('log_permintaan_edit') .' log permintaan');
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
	private function save_log_permintaan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['kode_permintaan']        = $this->input->post('log_permintaan_kode_permintaan');
		$data['kode_detil_permintaan']        = $this->input->post('log_permintaan_kode_detil_permintaan');
		$data['user_id']        = $this->input->post('log_permintaan_user_id');
		$data['tanggal_jam']        = $this->input->post('log_permintaan_tanggal_jam') ? $this->input->post('log_permintaan_tanggal_jam') : '0000-00-00 00:00:00';
		$data['aksi']        = $this->input->post('log_permintaan_aksi');
		$data['keterangan']        = $this->input->post('log_permintaan_keterangan');

		if ($type == 'insert')
		{
			$id = $this->log_permintaan_model->insert($data);

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
			$return = $this->log_permintaan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}