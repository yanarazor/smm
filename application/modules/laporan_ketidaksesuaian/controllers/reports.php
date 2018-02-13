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

		$this->auth->restrict('Laporan_Ketidaksesuaian.Reports.View');
		$this->load->model('laporan_ketidaksesuaian_model', null, true);
		$this->lang->load('laporan_ketidaksesuaian');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');

		Assets::add_module_js('laporan_ketidaksesuaian', 'laporan_ketidaksesuaian.js');
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
					$result = $this->laporan_ketidaksesuaian_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('laporan_ketidaksesuaian_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('laporan_ketidaksesuaian_delete_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
				}
			}
		}

		$records = $this->laporan_ketidaksesuaian_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Laporan Ketidaksesuaian');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Laporan Ketidaksesuaian object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Laporan_Ketidaksesuaian.Reports.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_laporan_ketidaksesuaian())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('laporan_ketidaksesuaian_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'laporan_ketidaksesuaian');

				Template::set_message(lang('laporan_ketidaksesuaian_create_success'), 'success');
				redirect(SITE_AREA .'/reports/laporan_ketidaksesuaian');
			}
			else
			{
				Template::set_message(lang('laporan_ketidaksesuaian_create_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
			}
		}
		Assets::add_module_js('laporan_ketidaksesuaian', 'laporan_ketidaksesuaian.js');

		Template::set('toolbar_title', lang('laporan_ketidaksesuaian_create') . ' Laporan Ketidaksesuaian');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Laporan Ketidaksesuaian data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('laporan_ketidaksesuaian_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/laporan_ketidaksesuaian');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Laporan_Ketidaksesuaian.Reports.Edit');

			if ($this->save_laporan_ketidaksesuaian('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('laporan_ketidaksesuaian_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'laporan_ketidaksesuaian');

				Template::set_message(lang('laporan_ketidaksesuaian_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('laporan_ketidaksesuaian_edit_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Laporan_Ketidaksesuaian.Reports.Delete');

			if ($this->laporan_ketidaksesuaian_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('laporan_ketidaksesuaian_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'laporan_ketidaksesuaian');

				Template::set_message(lang('laporan_ketidaksesuaian_delete_success'), 'success');

				redirect(SITE_AREA .'/reports/laporan_ketidaksesuaian');
			}
			else
			{
				Template::set_message(lang('laporan_ketidaksesuaian_delete_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
			}
		}
		Template::set('laporan_ketidaksesuaian', $this->laporan_ketidaksesuaian_model->find($id));
		Template::set('toolbar_title', lang('laporan_ketidaksesuaian_edit') .' Laporan Ketidaksesuaian');
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
	private function save_laporan_ketidaksesuaian($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nomor']        = $this->input->post('laporan_ketidaksesuaian_nomor');
		$data['kegiatan']        = $this->input->post('laporan_ketidaksesuaian_kegiatan');
		$data['penanggung_jawab']        = $this->input->post('laporan_ketidaksesuaian_penanggung_jawab');
		$data['tanggal_penemuan']        = $this->input->post('laporan_ketidaksesuaian_tanggal_penemuan') ? $this->input->post('laporan_ketidaksesuaian_tanggal_penemuan') : '0000-00-00';
		$data['bidang_bagian']        = $this->input->post('laporan_ketidaksesuaian_bidang_bagian');
		$data['ketidaksesuaian']        = $this->input->post('laporan_ketidaksesuaian_ketidaksesuaian');
		$data['seharusnya']        = $this->input->post('laporan_ketidaksesuaian_seharusnya');
		$data['status_evaluasi_swm']        = $this->input->post('laporan_ketidaksesuaian_status_evaluasi_swm');
		$data['tgl_persetujuan_swm']        = $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_swm') ? $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_swm') : '0000-00-00';
		$data['tgl_persetujuan_kabid']        = $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_kabid') ? $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_kabid') : '0000-00-00';
		$data['keterangan']        = $this->input->post('laporan_ketidaksesuaian_keterangan');
		$data['tgl_close']        = $this->input->post('laporan_ketidaksesuaian_tgl_close') ? $this->input->post('laporan_ketidaksesuaian_tgl_close') : '0000-00-00';

		if ($type == 'insert')
		{
			$id = $this->laporan_ketidaksesuaian_model->insert($data);

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
			$return = $this->laporan_ketidaksesuaian_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}