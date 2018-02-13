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

		$this->auth->restrict('Dashboard_Sdm.Reports.View');
		$this->lang->load('dashboard_sdm');
		
		Template::set_block('sub_nav', 'reports/_sub_nav');
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');
		Assets::add_module_js('dashboard_sdm', 'dashboard_sdm.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->model('surat_izin/surat_izin_model', null, true);
		$this->load->model('lupa_timer/lupa_timer_model', null, true);
		$this->surat_izin_model->where('status_atasan != ""');
		$countproses = $this->surat_izin_model->count_bystatusatasan();
		Template::set('countproses', $countproses);
		$this->surat_izin_model->where('status_atasan is null');
		$countblmproses = $this->surat_izin_model->count_bystatusatasan();
		Template::set('countblmproses', $countblmproses);
		// lupa timer
		$this->lupa_timer_model->where('status_atasan != ""');
		$countproseslupatimer = $this->lupa_timer_model->count_bystatusatasan();
		Template::set('countproseslupatimers', $countproseslupatimer);
		$this->lupa_timer_model->where('status_atasan is null');
		$countblmprosestimer = $this->lupa_timer_model->count_bystatusatasan();
		Template::set('countblmprosestimers', $countblmprosestimer);
		
		//aktifitas
		$this->load->model('activities/activity_model');
		 
		$modules = array('users');
		$activities = $this->activity_model->order_by('created_on', 'desc')->limit(10)->find_by_module($modules);
		Template::set('activities', $activities);
		
		Template::set('toolbar_title', 'Dashboard');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Dashboard Sdm object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Dashboard_Sdm.Reports.Create');

		Assets::add_module_js('dashboard_sdm', 'dashboard_sdm.js');

		Template::set('toolbar_title', lang('dashboard_sdm_create') . ' Dashboard Sdm');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Dashboard Sdm data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('dashboard_sdm_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/dashboard_sdm');
		}

		Template::set('toolbar_title', lang('dashboard_sdm_edit') .' Dashboard Sdm');
		Template::render();
	}

	//--------------------------------------------------------------------



}