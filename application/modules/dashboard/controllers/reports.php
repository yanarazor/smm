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
		$this->auth->restrict('Dashboard.Reports.View');
		$this->lang->load('dashboard');
		Template::set_block('sub_nav', 'reports/_sub_nav');
		Assets::add_module_js('dashboard', 'dashboard.js');
	}
	//--------------------------------------------------------------------
	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->model('daftar_induk_dokumen/daftar_induk_dokumen_model', null, true);
		$this->load->model('dokumen_eksternal/dokumen_eksternal_model', null, true);
		$this->load->model('daftar_ptpp/daftar_ptpp_model', null, true);
		$this->load->model('activities/activity_model');
		$this->load->model('usulan_dokumen_internal/usulan_dokumen_internal_model');
		$this->load->model('usulan_dokumen_eksternal/usulan_dokumen_eksternal_model');
		$this->load->model('laporan_ketidaksesuaian/laporan_ketidaksesuaian_model');
		$modules = array('users','audit_internal','bidang','daftar_induk_dokumen','daftar_induk_rekaman','daftar_periksa_audit','daftar_ptpp','dokumen_eksternal','jadwal_audit','jenis_dokumen','kategori_ptpp','rencana_tahunan','usulan_dokumen_eksternal','usulan_dokumen_internal','usulan_perubahan_dokumen');
		$activities = $this->activity_model->order_by('created_on', 'desc')->limit(10)->find_by_module($modules);
		$recorddoc = $this->daftar_induk_dokumen_model->distinct_jenis();
		$recorddoceks = $this->dokumen_eksternal_model->count_all();
		
		Template::set('toolbar_title', 'Dashboard');
		$recorddocbybidang = $this->daftar_induk_dokumen_model->distinct_bidang();
		$recorddokbystatus = $this->daftar_induk_dokumen_model->BygroupStatus();
		$record_usulan_periksa = $this->usulan_dokumen_internal_model->GetJumlahStatusPeriksa();
		$record_usulan_sah = $this->usulan_dokumen_internal_model->GetJumlahStatusSah();
		$totalUsulan = $this->usulan_dokumen_internal_model->GettotalUsulan();
		// usulan dokumen eksternal
		$TotalStatusSahEks = $this->usulan_dokumen_eksternal_model->GetJumlahStatusSah();
		$totalUsulanEks = $this->usulan_dokumen_eksternal_model->Count_all();
		//PTPP
		$RecordByJenisPTPP = $this->daftar_ptpp_model->GetGroupByKategori();
		$RecordByStatus = $this->daftar_ptpp_model->GetGroupByStatus();
		$RecordByStatusnBidang = $this->daftar_ptpp_model->GetGroupBybidangOpen();
		
		// ketidaksesuaian
		$RecordBykeputusan = $this->laporan_ketidaksesuaian_model->GetGroupByTindakan();
		
		//surat izin
		$this->load->model('surat_izin/surat_izin_model', null, true);
		$jumlnotifizin = $this->surat_izin_model->count_all_notif("","");// varameter bulan dan tahun
		Template::set('jumlnotifizin', (int)$jumlnotifizin);
		$totalizin = $this->surat_izin_model->count_all();
		Template::set('totalizin', (int)$totalizin);
		
		$this->load->model('lupa_timer/lupa_timer_model', null, true);
		$jmlnotiftimer = $this->lupa_timer_model->count_all_notif("","");// varameter bulan dan tahun
		$totaltimer = $this->lupa_timer_model->count_all();
		Template::set('jmlnotiftimer', (int)$jmlnotiftimer);
		Template::set('totaltimer', (int)$totaltimer);
		
		Template::set('toolbar_title', 'Dashboard');
		Template::set('recorddoc', $recorddoc);
		Template::set('recorddoceks', $recorddoceks);
		Template::set('recorddocbybidang', $recorddocbybidang);
		Template::set('recorddokbystatus', $recorddokbystatus);
		Template::set('recordactivities', $activities);
		Template::set('record_usulan_periksa', $record_usulan_periksa);
		Template::set('record_usulan_sah', $record_usulan_sah);
		Template::set('totalUsulan', $totalUsulan);
		Template::set('totalUsulanEks', $totalUsulanEks);
		Template::set('TotalStatusSahEks', $TotalStatusSahEks);
		Template::set('RecordByJenisPTPP', $RecordByJenisPTPP);
		Template::set('RecordByStatus', $RecordByStatus);
		Template::set('RecordByStatusnBidang', $RecordByStatusnBidang);
		Template::set('RecordBykeputusan', $RecordBykeputusan);
		Template::render();
	}

	//--------------------------------------------------------------------



}