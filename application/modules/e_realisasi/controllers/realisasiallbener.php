<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * realisasi controller
 */
class realisasi extends Admin_Controller
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

		$this->auth->restrict('E_Realisasi.Realisasi.View');
		$this->lang->load('e_realisasi');
		
		Template::set_block('sub_nav', 'realisasi/_sub_nav');

		Assets::add_module_js('e_realisasi', 'e_realisasi.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatan = $this->kegiatan_model->getdistinct();
		Template::set('masterkegiatans', $masterkegiatan);
		//print_r($masterkegiatan);
		//die();
		Template::set('toolbar_title', 'Manage e Realisasi');
		Template::render();
	}
	public function realisasisas()
	{
		$kegiatan 	= $this->input->post('kegiatan');
		$tahun 	= $this->input->post('tahun');
		$kdkmpnen = "";
		$kdskmpnen = "";
		if($kegiatan!=""){
			$arkegiatan = explode("-",$kegiatan);
			$kdkmpnen = $arkegiatan[0];
			$kdskmpnen = $arkegiatan[1];
		}
		
		
		//print_r($arkegiatan);
		$this->load->model('e_realisasi/rkakl_model', null, true);
		$rekappermak = $this->rkakl_model->getrekappermak($kdkmpnen,$kdskmpnen);
		
		$this->load->model('e_realisasi/dd_drpp_dt_model', null, true);
		$dd_drpp_dt = $this->dd_drpp_dt_model->getrealisasi();
		
		$datarealisasi 		= array(); 
		if (isset($dd_drpp_dt) && is_array($dd_drpp_dt) && count($dd_drpp_dt)) :
			foreach ($dd_drpp_dt as $record) :
				$datarealisasi[$record->kdakun.""."".$record->kdkmpnen."".$record->kdskmpnen] = $record->jumlah;
				//echo $record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."<br>";
			endforeach;
		endif;
		
		// realisasi kuitansi
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		$kuitansirealisasi = $this->d_kuitansi_model->getrealisasi();
		
		$datarealisasikuitansi 		= array(); 
		if (isset($kuitansirealisasi) && is_array($kuitansirealisasi) && count($kuitansirealisasi)) :
			foreach ($kuitansirealisasi as $record) :
				$datarealisasikuitansi[$record->kdakun.""."".$record->kdkmpnen."".$record->kdskmpnen] = $record->jumlah;
				//echo $record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."<br>";
			endforeach;
		endif;
		
		
		//print_r($dd_drpp_dt);
		$output = "";
		$output .= $this->load->view('realisasi/realisasisas',array("rekappermak"=>$rekappermak,"datarealisasi"=>$datarealisasi,"datarealisasikuitansi"=>$datarealisasikuitansi),true);	
		echo $output;
		die();
	}
	//--------------------------------------------------------------------


	/**
	 * Creates a e Realisasi object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('E_Realisasi.Realisasi.Create');

		Assets::add_module_js('e_realisasi', 'e_realisasi.js');

		Template::set('toolbar_title', lang('e_realisasi_create') . ' e Realisasi');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of e Realisasi data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('e_realisasi_invalid_id'), 'error');
			redirect(SITE_AREA .'/realisasi/e_realisasi');
		}

		Template::set('toolbar_title', lang('e_realisasi_edit') .' e Realisasi');
		Template::render();
	}

	//--------------------------------------------------------------------



}