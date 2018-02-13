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

		$this->auth->restrict('Daftar_ptpp.Reports.View');
		$this->load->model('daftar_ptpp_model', null, true);
		$this->lang->load('daftar_ptpp');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');

		Assets::add_module_js('daftar_ptpp', 'daftar_ptpp.js');
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
					$result = $this->daftar_ptpp_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('daftar_ptpp_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('daftar_ptpp_delete_failure') . $this->daftar_ptpp_model->error, 'error');
				}
			}
		}

		$records = $this->daftar_ptpp_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage daftar ptpp');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a daftar ptpp object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Daftar_ptpp.Reports.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_daftar_ptpp())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_ptpp_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'daftar_ptpp');

				Template::set_message(lang('daftar_ptpp_create_success'), 'success');
				redirect(SITE_AREA .'/reports/daftar_ptpp');
			}
			else
			{
				Template::set_message(lang('daftar_ptpp_create_failure') . $this->daftar_ptpp_model->error, 'error');
			}
		}
		Assets::add_module_js('daftar_ptpp', 'daftar_ptpp.js');

		Template::set('toolbar_title', lang('daftar_ptpp_create') . ' daftar ptpp');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of daftar ptpp data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('daftar_ptpp_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/daftar_ptpp');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Daftar_ptpp.Reports.Edit');

			if ($this->save_daftar_ptpp('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_ptpp_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_ptpp');

				Template::set_message(lang('daftar_ptpp_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('daftar_ptpp_edit_failure') . $this->daftar_ptpp_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Daftar_ptpp.Reports.Delete');

			if ($this->daftar_ptpp_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_ptpp_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_ptpp');

				Template::set_message(lang('daftar_ptpp_delete_success'), 'success');

				redirect(SITE_AREA .'/reports/daftar_ptpp');
			}
			else
			{
				Template::set_message(lang('daftar_ptpp_delete_failure') . $this->daftar_ptpp_model->error, 'error');
			}
		}
		Template::set('daftar_ptpp', $this->daftar_ptpp_model->find($id));
		Template::set('toolbar_title', lang('daftar_ptpp_edit') .' daftar ptpp');
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
	private function save_daftar_ptpp($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['ditujukan_kepada']        = $this->input->post('daftar_ptpp_ditujukan_kepada');
		$data['diajukan_oleh']        = $this->input->post('daftar_ptpp_diajukan_oleh');
		$data['no_ptpp']        = $this->input->post('daftar_ptpp_no_ptpp');
		$data['tgl_ptpp']        = $this->input->post('daftar_ptpp_tgl_ptpp') ? $this->input->post('daftar_ptpp_tgl_ptpp') : '0000-00-00';
		$data['referensi']        = $this->input->post('daftar_ptpp_referensi');
		$data['kategori']        = $this->input->post('daftar_ptpp_kategori');
		$data['deskripsi_ketidaksesuaian']        = $this->input->post('daftar_ptpp_deskripsi_ketidaksesuaian');
		$data['tanggal_pengusulan']        = $this->input->post('daftar_ptpp_tanggal_pengusulan') ? $this->input->post('daftar_ptpp_tanggal_pengusulan') : '0000-00-00';
		$data['tanggal_tandatangan_auditi']        = $this->input->post('daftar_ptpp_tanggal_tandatangan_auditi') ? $this->input->post('daftar_ptpp_tanggal_tandatangan_auditi') : '0000-00-00';
		$data['hasil_investigasi']        = $this->input->post('daftar_ptpp_hasil_investigasi');
		$data['tgl_tandatangan_hasil']        = $this->input->post('daftar_ptpp_tgl_tandatangan_hasil') ? $this->input->post('daftar_ptpp_tgl_tandatangan_hasil') : '0000-00-00';
		$data['tindakan_koreksi']        = $this->input->post('daftar_ptpp_tindakan_koreksi');
		$data['tindakan_korektif']        = $this->input->post('daftar_ptpp_tindakan_korektif');
		$data['tgl_penyelesaian']        = $this->input->post('daftar_ptpp_tgl_penyelesaian') ? $this->input->post('daftar_ptpp_tgl_penyelesaian') : '0000-00-00';
		$data['disetujui_oleh']        = $this->input->post('daftar_ptpp_disetujui_oleh');
		$data['tanggal_disetujui']        = $this->input->post('daftar_ptpp_tanggal_disetujui') ? $this->input->post('daftar_ptpp_tanggal_disetujui') : '0000-00-00';
		$data['tinjauan_tindakan_perbaikan']        = $this->input->post('daftar_ptpp_tinjauan_tindakan_perbaikan');
		$data['kesimpulan']        = $this->input->post('daftar_ptpp_kesimpulan');

		if ($type == 'insert')
		{
			$id = $this->daftar_ptpp_model->insert($data);

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
			$return = $this->daftar_ptpp_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}