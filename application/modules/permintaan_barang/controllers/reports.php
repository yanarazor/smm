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

		$this->auth->restrict('Permintaan_Barang.Reports.View');
		$this->load->model('permintaan_barang_model', null, true);
		$this->lang->load('permintaan_barang');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');

		Assets::add_module_js('permintaan_barang', 'permintaan_barang.js');
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
					$result = $this->permintaan_barang_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('permintaan_barang_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('permintaan_barang_delete_failure') . $this->permintaan_barang_model->error, 'error');
				}
			}
		}

		$records = $this->permintaan_barang_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Permintaan Barang');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Permintaan Barang object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Permintaan_Barang.Reports.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_permintaan_barang())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('permintaan_barang_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_create_success'), 'success');
				redirect(SITE_AREA .'/reports/permintaan_barang');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_create_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		Assets::add_module_js('permintaan_barang', 'permintaan_barang.js');

		Template::set('toolbar_title', lang('permintaan_barang_create') . ' Permintaan Barang');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Permintaan Barang data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/permintaan_barang');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Permintaan_Barang.Reports.Edit');

			if ($this->save_permintaan_barang('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('permintaan_barang_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_edit_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Permintaan_Barang.Reports.Delete');

			if ($this->permintaan_barang_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('permintaan_barang_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_delete_success'), 'success');

				redirect(SITE_AREA .'/reports/permintaan_barang');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_delete_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		Template::set('permintaan_barang', $this->permintaan_barang_model->find($id));
		Template::set('toolbar_title', lang('permintaan_barang_edit') .' Permintaan Barang');
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
	private function save_permintaan_barang($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nomor']        = $this->input->post('permintaan_barang_nomor');
		$data['user_request']        = $this->input->post('permintaan_barang_user_request');
		$data['tanggal_permintaan']        = $this->input->post('permintaan_barang_tanggal_permintaan') ? $this->input->post('permintaan_barang_tanggal_permintaan') : '0000-00-00';
		$data['anggaran']        = $this->input->post('permintaan_barang_anggaran');
		$data['kegiatan']        = $this->input->post('permintaan_barang_kegiatan');
		$data['tanggal_selesai']        = $this->input->post('permintaan_barang_tanggal_selesai') ? $this->input->post('permintaan_barang_tanggal_selesai') : '0000-00-00';
		$data['status_atasan']        = $this->input->post('permintaan_barang_status_atasan');
		$data['status_kabag']        = $this->input->post('permintaan_barang_status_kabag');
		$data['status_permintaan']        = $this->input->post('permintaan_barang_status_permintaan');

		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_model->insert($data);

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
			$return = $this->permintaan_barang_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}