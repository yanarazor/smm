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

		$this->auth->restrict('Rekapitulasi_Laporan_Audit.Audit.View');
		$this->lang->load('rekapitulasi_laporan_audit');
		$this->load->model('daftar_ptpp/daftar_ptpp_model');
		Template::set_block('sub_nav', 'audit/_sub_nav');
		$this->load->model('status_ptpp/status_ptpp_model');
		$status = $this->status_ptpp_model->find_all();
		Template::set('statuss', $status);
		
		$this->load->model('user/user_model', null, true);
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		$this->load->model('bidang/bidang_model', null, true);
		$bidangs = $this->bidang_model->find_all();
		Template::set('bidangs', $bidangs);

		Assets::add_module_js('rekapitulasi_laporan_audit', 'rekapitulasi_laporan_audit.js');
		
		$this->load->model('audit_internal/audit_internal_model', null, true);
		$audit_internals = $this->audit_internal_model->find_all();
		Template::set('audit_internals', $audit_internals);
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$status = $this->input->get('status');
		$ai = $this->input->get('ai');
		$bidang = $this->input->get('bidang');
		$this->load->library('pagination');
		
		$total = count($this->daftar_ptpp_model->find_all_audit($status,"",$ai,$bidang));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?status='.$status.'&ai='.$ai.'&bidang='.$bidang;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		 
		$records = $this->daftar_ptpp_model->limit($limit, $offset)->find_all_audit($status,"",$ai,$bidang);
		Template::set('total', $total);
		Template::set('status_ptpp', $status);
		Template::set('records', $records);
		Template::set('ai', $ai);
		Template::set('id_bidang', $bidang);
		Template::set('link', "listprint/?mode=print");
		Template::set('toolbar_title', 'Rekapitulasi Laporan Audit');
		Template::render();
	}
	public function listprint()
	{
		$status = $this->input->get('status');
		$ai = $this->input->get('ai');
		$bidang = $this->input->get('bidang');
		$total = count($this->daftar_ptpp_model->find_all_audit($status,"",$ai,$bidang));
		 
		 
		$records = $this->daftar_ptpp_model->find_all_audit($status,"",$ai,$bidang);
		Template::set('total', $total);
		Template::set('status_ptpp', $status);
		Template::set('records', $records);
		Template::set('ai', $ai);
		Template::set('id_bidang', $bidang);
		Template::set('toolbar_title', 'Rekapitulasi Laporan Audit');

		Template::set_theme('print');
		Template::render();
	}
	//--------------------------------------------------------------------


	/**
	 * Creates a Rekapitulasi Laporan Audit object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Rekapitulasi_Laporan_Audit.Audit.Create');

		Assets::add_module_js('rekapitulasi_laporan_audit', 'rekapitulasi_laporan_audit.js');

		Template::set('toolbar_title', lang('rekapitulasi_laporan_audit_create') . ' Rekapitulasi Laporan Audit');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Rekapitulasi Laporan Audit data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('rekapitulasi_laporan_audit_invalid_id'), 'error');
			redirect(SITE_AREA .'/audit/rekapitulasi_laporan_audit');
		}

		Template::set('toolbar_title', lang('rekapitulasi_laporan_audit_edit') .' Rekapitulasi Laporan Audit');
		Template::render();
	}

	//--------------------------------------------------------------------



}