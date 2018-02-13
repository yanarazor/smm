<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * audit controller
 */
class audit extends Admin_Controller
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

		
		$this->load->model('daftar_periksa_audit_model', null, true);
		$this->lang->load('daftar_periksa_audit');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'audit/_sub_nav');
		$this->load->model('audit_internal/audit_internal_model', null, true);
		$audit_internals = $this->audit_internal_model->find_all();
		Template::set('audit_internals', $audit_internals);
		$this->load->model('bidang/bidang_model', null, true);
		$bidangs = $this->bidang_model->find_all();
		Template::set('bidangs', $bidangs);

		Assets::add_module_js('daftar_periksa_audit', 'daftar_periksa_audit.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
	$this->auth->restrict('Daftar_Periksa_Audit.Audit.View');
	
	$ai = $this->input->get('ai');
		$bidang = $this->input->get('bidang');
		$total = $this->daftar_periksa_audit_model->count_all($ai,$bidang);
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->daftar_periksa_audit_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('daftar_periksa_audit_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('daftar_periksa_audit_delete_failure') . $this->daftar_periksa_audit_model->error, 'error');
				}
			}
		}
		Template::set('link', "listprint/?mode=print");
		$records = $this->daftar_periksa_audit_model->find_all($ai,$bidang);
		Template::set('ai', $ai);
		Template::set('id_bidang', $bidang);
		Template::set('total', $total);
		Template::set('records', $records);
		Template::set('toolbar_title', 'Kelola Daftar Periksa Audit');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Daftar Periksa Audit object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Daftar_Periksa_Audit.Audit.Create');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_daftar_periksa_audit())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_periksa_audit_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'daftar_periksa_audit');

				Template::set_message(lang('daftar_periksa_audit_create_success'), 'success');
				redirect(SITE_AREA .'/audit/daftar_periksa_audit');
			}
			else
			{
				Template::set_message(lang('daftar_periksa_audit_create_failure') . $this->daftar_periksa_audit_model->error, 'error');
			}
		}
		Assets::add_module_js('daftar_periksa_audit', 'daftar_periksa_audit.js');

		Template::set('toolbar_title', lang('daftar_periksa_audit_create') . ' Daftar Periksa Audit');
		Template::render();
	}
	public function listprint()
	{
		$this->auth->restrict('Daftar_Periksa_Audit.Audit.Create');
		$ai = $this->input->get('ai');
		$bidang = $this->input->get('bidang');
		$total = $this->daftar_periksa_audit_model->count_all($ai,$bidang);
		
		$records = $this->daftar_periksa_audit_model->find_all($ai,$bidang);
		Template::set('records', $records);
		Template::set('link', "listprint/?mode=print");
		Template::set('ai', $ai);
		Template::set('bidang', $bidang);
		Template::set_theme('print');

		Template::set('toolbar_title', lang('daftar_periksa_audit_create') . ' Daftar Periksa Audit');
		Template::render();
	}
	//--------------------------------------------------------------------


	/**
	 * Allows editing of Daftar Periksa Audit data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('daftar_periksa_audit_invalid_id'), 'error');
			redirect(SITE_AREA .'/audit/daftar_periksa_audit');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Daftar_Periksa_Audit.Audit.Edit');

			if ($this->save_daftar_periksa_audit('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_periksa_audit_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_periksa_audit');

				Template::set_message(lang('daftar_periksa_audit_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('daftar_periksa_audit_edit_failure') . $this->daftar_periksa_audit_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Daftar_Periksa_Audit.Audit.Delete');

			if ($this->daftar_periksa_audit_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_periksa_audit_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_periksa_audit');

				Template::set_message(lang('daftar_periksa_audit_delete_success'), 'success');

				redirect(SITE_AREA .'/audit/daftar_periksa_audit');
			}
			else
			{
				Template::set_message(lang('daftar_periksa_audit_delete_failure') . $this->daftar_periksa_audit_model->error, 'error');
			}
		}
		Template::set('daftar_periksa_audit', $this->daftar_periksa_audit_model->find($id));
		Template::set('toolbar_title', lang('daftar_periksa_audit_edit') .' Daftar Periksa Audit');
		Template::render();
	}
	public function addchecklist()
	{
		$this->auth->restrict('Daftar_Periksa_Audit.Audit.Create');
		$idai = $this->uri->segment(5);
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($idai))
		{
			Template::set_message("Silahkan Tentukan Audit Internal Terlebih dahulu", 'error');
			redirect(SITE_AREA .'/audit/addchecklist');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Daftar_Periksa_Audit.Audit.Edit');

			if ($this->save_daftar_periksa_audit('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_periksa_audit_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_periksa_audit');

				Template::set_message(lang('daftar_periksa_audit_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('daftar_periksa_audit_edit_failure') . $this->daftar_periksa_audit_model->error, 'error');
			}
		}
		
		//Template::set('daftar_periksa_audit', $this->daftar_periksa_audit_model->find($id));
		Template::set('toolbar_title','Tambah Daftar Periksa Audit');
		Template::set('idai', $idai); 
		Template::set_theme('simple');
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
	private function save_daftar_periksa_audit($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['id_jadwal_audit']        = $this->input->post('daftar_periksa_audit_id_jadwal_audit');
		$data['deskripsi']        = $this->input->post('daftar_periksa_audit_deskripsi');
		$data['klausul_iso']        = $this->input->post('daftar_periksa_audit_klausul_iso');
		$data['bukti_obyektif']        = $this->input->post('daftar_periksa_audit_bukti_obyektif');
		$data['kesesuaian']        = $this->input->post('daftar_periksa_audit_kesesuaian') ? $this->input->post('daftar_periksa_audit_kesesuaian'):"";
		$data['id_bidang']        = $this->input->post('daftar_periksa_audit_id_bidang');
		$data['tanggal']        = date("Y-m-d");
		$data['auditor']        = $this->current_user->id;
		if ($type == 'insert')
		{
			$id = $this->daftar_periksa_audit_model->insert($data);

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
			$return = $this->daftar_periksa_audit_model->update($id, $data);
		}

		return $return;
	}
	public function delete_checklist_ajax()
	{
		$kode = $this->input->get('id'); 
		$result = $this->daftar_periksa_audit_model->delete($kode);
		exit();
	}
	public function saveajax()
	{
		 
		$insert_id = $this->save_daftar_periksa_audit();
		die();
	}
	//--------------------------------------------------------------------


}