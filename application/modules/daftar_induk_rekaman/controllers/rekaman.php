<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * rekaman controller
 */
class rekaman extends Admin_Controller
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

		$this->auth->restrict('Daftar_induk_rekaman.Rekaman.View');
		$this->load->model('daftar_induk_rekaman_model', null, true);
		$this->lang->load('daftar_induk_rekaman');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'rekaman/_sub_nav');

		Assets::add_module_js('daftar_induk_rekaman', 'daftar_induk_rekaman.js');
		
		$this->load->model('bidang/bidang_model', null, true);
		$bidangs = $this->bidang_model->find_all();
		Template::set('bidangs', $bidangs);
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
					$result = $this->daftar_induk_rekaman_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('daftar_induk_rekaman_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('daftar_induk_rekaman_delete_failure') . $this->daftar_induk_rekaman_model->error, 'error');
				}
			}
		}
		
		$key = $this->input->get('key');
		$pj = $this->input->get('pj');
		$this->load->library('pagination');
		$total = count($this->daftar_induk_rekaman_model->find_all($pj,$key));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?pj=".$pj."&key=".$key;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		$records = $this->daftar_induk_rekaman_model->limit($limit, $offset)->find_all($pj,$key);

		Template::set('records', $records);
		Template::set('total', $total);
		 
		Template::set('pj', $pj);
		Template::set('key', $key);

		Template::set('records', $records);
		Template::set('toolbar_title', 'Kelola Daftar induk rekaman');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Daftar induk rekaman object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Daftar_induk_rekaman.Rekaman.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_daftar_induk_rekaman())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_induk_rekaman_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'daftar_induk_rekaman');

				Template::set_message(lang('daftar_induk_rekaman_create_success'), 'success');
				redirect(SITE_AREA .'/rekaman/daftar_induk_rekaman');
			}
			else
			{
				Template::set_message(lang('daftar_induk_rekaman_create_failure') . $this->daftar_induk_rekaman_model->error, 'error');
			}
		}
		Assets::add_module_js('daftar_induk_rekaman', 'daftar_induk_rekaman.js');

		Template::set('toolbar_title', lang('daftar_induk_rekaman_create') . ' Daftar induk rekaman');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Daftar induk rekaman data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('daftar_induk_rekaman_invalid_id'), 'error');
			redirect(SITE_AREA .'/rekaman/daftar_induk_rekaman');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Daftar_induk_rekaman.Rekaman.Edit');

			if ($this->save_daftar_induk_rekaman('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_induk_rekaman_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_induk_rekaman');

				Template::set_message(lang('daftar_induk_rekaman_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('daftar_induk_rekaman_edit_failure') . $this->daftar_induk_rekaman_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Daftar_induk_rekaman.Rekaman.Delete');

			if ($this->daftar_induk_rekaman_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_induk_rekaman_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_induk_rekaman');

				Template::set_message(lang('daftar_induk_rekaman_delete_success'), 'success');

				redirect(SITE_AREA .'/rekaman/daftar_induk_rekaman');
			}
			else
			{
				Template::set_message(lang('daftar_induk_rekaman_delete_failure') . $this->daftar_induk_rekaman_model->error, 'error');
			}
		}
		Template::set('daftar_induk_rekaman', $this->daftar_induk_rekaman_model->find($id));
		Template::set('toolbar_title', lang('daftar_induk_rekaman_edit') .' Daftar induk rekaman');
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
	private function save_daftar_induk_rekaman($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('daftar_induk_rekaman_nama','Nama','required|max_length[200]');
		$this->form_validation->set_rules('daftar_induk_rekaman_nomor','Nomor','required|max_length[50]');
		$this->form_validation->set_rules('daftar_induk_rekaman_lama_simpan','Lama Simpan','required|max_length[250]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nama']        = $this->input->post('daftar_induk_rekaman_nama');
		$data['nomor']        = $this->input->post('daftar_induk_rekaman_nomor');
		$data['lama_simpan']        = $this->input->post('daftar_induk_rekaman_lama_simpan');
		$data['lama_simpan_inactive']        = $this->input->post('lama_simpan_inactive');
		$data['tempat_simpan']        = $this->input->post('daftar_induk_rekaman_tempat_simpan');
		$data['penanggung_jawab']        = $this->input->post('daftar_induk_rekaman_penanggung_jawab');
		if ($type != 'update')
		{
			$data['created_by']        = $this->current_user->id;
		}
		$data['created_date']        = date("Y-m-d");
		$data['updated_by']        = $this->current_user->id;
		$data['updated_date']        = date("Y-m-d");
		$data['penanggung_jawab_personil']        = $this->input->post('penanggung_jawab_personil');
		
		if ($type == 'insert')
		{
			$id = $this->daftar_induk_rekaman_model->insert($data);

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
			$return = $this->daftar_induk_rekaman_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}