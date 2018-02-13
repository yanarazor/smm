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

		$this->auth->restrict('Jadwal_Audit.Audit.View');
		$this->load->model('jadwal_audit_model', null, true);
		$this->lang->load('jadwal_audit');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		

		Assets::add_module_js('jadwal_audit', 'jadwal_audit.js');
		$this->load->model('audit_internal/audit_internal_model', null, true);
		$audit_internals = $this->audit_internal_model->find_all();
		Template::set('audit_internals', $audit_internals);
		
		$this->load->model('bidang/bidang_model', null, true);
		$bidangs = $this->bidang_model->find_all();
		Template::set('bidangs', $bidangs);
		$this->load->model('user/user_model', null, true);
		$users = $this->user_model->find_all();
		Template::set('users', $users);
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		Template::set_block('sub_nav', 'audit/_sub_nav');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->jadwal_audit_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('jadwal_audit_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('jadwal_audit_delete_failure') . $this->jadwal_audit_model->error, 'error');
				}
			}
		}
		$this->load->library('pagination');
		$total = $this->jadwal_audit_model->count_all();
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		 
		$records = $this->jadwal_audit_model->limit($limit, $offset)->find_all();
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		 
		Template::set('records', $records);
		
		Template::set('records', $records);
		Template::set('toolbar_title', 'Kelola Jadwal Audit');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Jadwal Audit object.
	 *
	 * @return void
	 */
	public function create()
	{
		Template::set_block('sub_nav', 'audit/_sub_nav');
		$this->auth->restrict('Jadwal_Audit.Audit.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_jadwal_audit())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jadwal_audit_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'jadwal_audit');

				Template::set_message(lang('jadwal_audit_create_success'), 'success');
				redirect(SITE_AREA .'/audit/jadwal_audit');
			}
			else
			{
				Template::set_message(lang('jadwal_audit_create_failure') . $this->jadwal_audit_model->error, 'error');
			}
		}
		Assets::add_module_js('jadwal_audit', 'jadwal_audit.js');

		Template::set('toolbar_title', lang('jadwal_audit_create') . ' Jadwal Audit');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Jadwal Audit data.
	 *
	 * @return void
	 */
	public function edit()
	{
		Template::set_block('sub_nav', 'audit/_sub_nav');
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('jadwal_audit_invalid_id'), 'error');
			redirect(SITE_AREA .'/audit/jadwal_audit');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Jadwal_Audit.Audit.Edit');

			if ($this->save_jadwal_audit('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jadwal_audit_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'jadwal_audit');

				Template::set_message(lang('jadwal_audit_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('jadwal_audit_edit_failure') . $this->jadwal_audit_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Jadwal_Audit.Audit.Delete');

			if ($this->jadwal_audit_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jadwal_audit_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'jadwal_audit');

				Template::set_message(lang('jadwal_audit_delete_success'), 'success');

				redirect(SITE_AREA .'/audit/jadwal_audit');
			}
			else
			{
				Template::set_message(lang('jadwal_audit_delete_failure') . $this->jadwal_audit_model->error, 'error');
			}
		}
		Template::set('jadwal_audit', $this->jadwal_audit_model->find($id));
		Template::set('toolbar_title', lang('jadwal_audit_edit') .' Jadwal Audit');
		Template::render();
	}
	public function addjadwal()
	{
		$idai = $this->uri->segment(5);
		if (empty($idai))
		{
			Template::set_message("Silahkan Tentukan Audit Internal Terlebih dahulu", 'error');
			redirect(SITE_AREA .'/audit/jadwal_audit/addjadwal');
		}
		Template::set('idai', $idai);
		Template::set('toolbar_title','Tambah Jadwal Audit');
		Template::set_theme('simple');
		Template::render();
	}
	public function listjadwal()
	{
		$idai = $this->uri->segment(5);
		 
		$records =	$this->jadwal_audit_model->find_all($idai,"");
		$total =	count($this->jadwal_audit_model->find_all($idai,""));
		if(isset($records) && is_array($records) && count($records))
			$total = $total;
		else
			$total = 0;
		 
		$output = "";
			$output .= $this->load->view('audit/listjadwal',array('records'=>$records,'idai'=>$idai,'total'=>$total),true);	
		echo $output;
		die();
	}
	public function saveajax()
	{
		$insert_id = $this->save_jadwal_audit();
		die();
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
	private function save_jadwal_audit($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['id_audit']        = $this->input->post('jadwal_audit_id_audit');
		$data['id_bidang']        = $this->input->post('jadwal_audit_id_bidang');
		$data['pm']        = $this->input->post('jadwal_audit_pm');
		$data['klausul']        = $this->input->post('jadwal_audit_klausul');
		$data['tanggal']        = $this->input->post('jadwal_audit_tanggal') ? $this->input->post('jadwal_audit_tanggal') : '0000-00-00';
		$data['auditor_kepala']        = $this->input->post('jadwal_audit_auditor_kepala');
		$data['auditor']        = $this->input->post('jadwal_audit_auditor');
		if ($type == 'insert')
		{
			$id = $this->jadwal_audit_model->insert($data);

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
			$return = $this->jadwal_audit_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}