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
	public function get_ditem()
	{
		$this->load->model('e_realisasi/sas_model', null, true);
		$recorditems = $this->sas_model->get_data();
		print_r($recorditems);
		exit();
	}
	public function index()
	{
	
		$tahun = $this->input->post('tahun') ? $this->input->post('tahun') : "2018";
		$this->load->model('e_realisasi/sasd_item_model', null, true);
		 
		// pagu kegiatan
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatan = $this->kegiatan_model->getdistinctkegiatan("","","",$tahun);
		Template::set('masterkegiatan', $masterkegiatan);
		
		$this->load->model('e_realisasi/rkakl_model', null, true);
		$rekappermak = $this->rkakl_model->rekappermakkegiatan($tahun);
		$datapagu 		= array(); 
		//print_r($rekappermak);
		$no = 1;
		if (isset($rekappermak) && is_array($rekappermak) && count($rekappermak)) :
			foreach ($rekappermak as $record) :
					$datapagu[trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput)."-".trim($record->kdkmpnen)."-".trim($record->kdskmpnen)] = $record->pagu;
				$no++;
			endforeach;
		endif;
		Template::set('datapagu', $datapagu);
		
		$this->load->model('e_realisasi/Sasdd_spmmak_model', null, true);
		$this->load->model('e_realisasi/Sasmm_spmmak_model', null, true);
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		$realisasils = $this->Sasdd_spmmak_model->getrealisasilsperkegiatan($tahun);
		$datarealisasilskegiatan		= array(); 
		$datarealisasikegiatan		= array();
		if (isset($realisasils) && is_array($realisasils) && count($realisasils)) :
			foreach ($realisasils as $record) :
				//echo trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput) . " = ".$record->jumlah."<br>";
				$datarealisasilskegiatan[trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput)."-".trim($record->kdkmpnen)."-".trim($record->kdskmpnen)] 	= $record->jumlah;
				$datarealisasikegiatan[trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput)."-".trim($record->kdkmpnen)."-".trim($record->kdskmpnen)] 		= $record->jumlah;
			endforeach;
		endif;
		//die();
		$realisasispm = $this->d_kuitansi_model->getrealisasiperkegiatan($tahun);
		
		if (isset($realisasispm) && is_array($realisasispm) && count($realisasispm)) :
			foreach ($realisasispm as $record) :
				if(isset($datarealisasilskegiatan[trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput)."-".trim($record->kdkmpnen)."-".trim($record->kdskmpnen)]))
				{
					//echo trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput) . " = ".$record->jumlah."<br>";
					$datarealisasikegiatan[trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput)]  = (double)$datarealisasilskegiatan[trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput)."-".trim($record->kdkmpnen)."-".trim($record->kdskmpnen)] + $record->jumlah;
				}else{
					//echo trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput)."-".trim($record->kdkmpnen)."-".trim($record->kdskmpnen)." = ".$record->jumlah."<br>";
					$datarealisasikegiatan[trim($record->kdgiat)."-".trim($record->kdoutput)."-".trim($record->kdsoutput)."-".trim($record->kdkmpnen)."-".trim($record->kdskmpnen)] = $record->jumlah;
				}
			endforeach;
		endif;
		Template::set('datarealisasikegiatan', $datarealisasikegiatan);
		
		$this->load->model('e_realisasi/Sasdd_spmmak_model', null, true);
		$realisasispm =  $this->Sasdd_spmmak_model->getrealisasiperbulanall($tahun);
	//	print_r($realisasispm);
	//	die();
		// data realisasi yang sebelumnya dari drp sekarang dari SPM
		$datarealisasi 			= array(); 
		$datarealisasils		= array(); 
		
		for($i=1;$i<13;$i++){
			$datarealisasi[$i] = 0;
		}
		
		$jumlah = 0;
		if (isset($realisasispm) && is_array($realisasispm) && count($realisasispm)) :
			foreach ($realisasispm as $record) :
				$datarealisasi[trim($record->month)] = $record->jumlah;
			endforeach;
		endif;
		
		$this->load->model('e_realisasi/Sasmm_spmmak_model', null, true);
		$realisasils =  $this->Sasmm_spmmak_model->getrealisasiperbulanall($tahun);
		if (isset($realisasils) && is_array($realisasils) && count($realisasils)) :
			foreach ($realisasils as $record) :
				$datarealisasi[trim($record->month)] = $datarealisasi[trim($record->month)] + $record->jumlah; 
			endforeach;
		endif;
		
		$nilai = "[".$datarealisasi[1].",".$datarealisasi[2].",".$datarealisasi[3].",".$datarealisasi[4].",".$datarealisasi[5].",".$datarealisasi[6].",".$datarealisasi[7].",".$datarealisasi[8].",".$datarealisasi[9].",".$datarealisasi[10].",".$datarealisasi[11].",".$datarealisasi[12]."]";
		Template::set('datarealisasiperbulan', $nilai);
		
		// pagu per akun
		// akun 51 belanja pegawai
			$rekappermak = $this->rkakl_model->rekapperkdakun($tahun,"51");
			$jmlmak51 = isset($rekappermak[0]->pagu) ? $rekappermak[0]->pagu : 0;
			Template::set('jmlmak51', $jmlmak51);
			
		// akun 52
			$rekappermak = $this->rkakl_model->rekapperkdakun($tahun,"52");
			$jmlmak52 = isset($rekappermak[0]->pagu) ? $rekappermak[0]->pagu : 0;
			Template::set('jmlmak52', $jmlmak52);
		// akun 53
			$rekappermak = $this->rkakl_model->rekapperkdakun($tahun,"53");
			$jmlmak53 = isset($rekappermak[0]->pagu) ? $rekappermak[0]->pagu : 0;
			Template::set('jmlmak53', $jmlmak53);
		// realisasi per akun
		// akun 51
			$real = $this->Sasdd_spmmak_model->rekapperkdakun($tahun,"51");
			$realmak51 = isset($real[0]->jumlah) ? $real[0]->jumlah : 0;
			Template::set('realmak51', $realmak51);
		// akun 52
			$real = $this->Sasdd_spmmak_model->rekapperkdakun($tahun,"52");
			$realmak52 = isset($real[0]->jumlah) ? $real[0]->jumlah : 0;
			Template::set('realmak52', $realmak52);
		// akun 53
			$real = $this->Sasdd_spmmak_model->rekapperkdakun($tahun,"53");
			$realmak53 = isset($real[0]->jumlah) ? $real[0]->jumlah : 0;
			Template::set('realmak53', $realmak53);
		
			
		Template::set('toolbar_title', 'Realisasi Keuangan');
		Template::render();
	}
	public function realkegiatan()
	{
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		
		$this->load->model('e_realisasi/output_model', null, true);
		$masteroutput = $this->output_model->find_all();
		Template::set('masteroutput', $masteroutput);
		
		$masterkegiatan = $this->kegiatan_model->getdistinct();
		Template::set('masterkegiatans', $masterkegiatan);
		//print_r($masterkegiatan);
		//die();
		Template::set('toolbar_title', 'Realisasi Perkegiatan');
		Template::render();
	}
	public function rkakl()
	{
		$this->load->model('e_realisasi/output_model', null, true);
		$masteroutput = $this->output_model->find_all();
		Template::set('masteroutput', $masteroutput);
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatan = $this->kegiatan_model->getkegiatans();
		Template::set('masterkegiatans', $masterkegiatan);
		//print_r($masterkegiatan);
		//die();
		Template::set('toolbar_title', 'Manage e RKAKL');
		Template::render();
	}
	public function realisasiperkegiatan()
	{
		$kegiatan 	= $this->input->post('kegiatan');
		$valoutput 	= $this->input->post('output');
		$kdkmpnen = "";
		$kdskmpnen = "";
		$kdgiat = "";
		$kdoutput = "";
		$kdsoutput = "";
		//die($valoutput);
		if($valoutput !=""){
			$aroutput = explode("-",$valoutput);
			$kdgiat = $aroutput[0];
			$kdoutput = $aroutput[1];
			$kdsoutput = $aroutput[2];
		}
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatans = $this->kegiatan_model->kegiatans($kdgiat,$kdoutput,$kdsoutput,$kdkmpnen,$kdskmpnen);
		
		// realisasi kuitansi
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		$kuitansirealisasi = $this->d_kuitansi_model->getrealisasiperkegiatan($kdgiat,$kdoutput,$kdsoutput,$kdkmpnen,$kdskmpnen);
		
		$datarealisasikuitansi 		= array(); 
		if (isset($kuitansirealisasi) && is_array($kuitansirealisasi) && count($kuitansirealisasi)) :
			foreach ($kuitansirealisasi as $record) :
				$datarealisasikuitansi[$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput] = $record->jumlah;
				//echo $record->kdakun."".$record->kdkmpnen."".$record->kdskmpnen."<br>";
			endforeach;
		endif;
		// realisasi pak jana
		$this->load->model('e_realisasi/rkakl_model', null, true);
		$rekappermak = $this->rkakl_model->getrekappermakperprogram($kdkmpnen,$kdskmpnen);
		// data realisasi yang sebelumnya dari drp sekarang dari SPM
		$datapagu 		= array(); 
		if (isset($rekappermak) && is_array($rekappermak) && count($rekappermak)) :
			foreach ($rekappermak as $record) :
				
				if(isset($datapagu[$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput]))
					echo $record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput."<br>";
					
				$datapagu[$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput] = $record->pagu;
				//echo $record->kdoutput."<br>";
			endforeach;
		endif;
		// end pagu
		$this->load->model('e_realisasi/Sasdd_spmmak_model', null, true);
		$realisasispm = $this->Sasdd_spmmak_model->getrealisasiperkegiatan($kdgiat,$kdoutput,$kdsoutput,$kdkmpnen,$kdskmpnen);
		// data realisasi yang sebelumnya dari drp sekarang dari SPM
		$datarealisasi 		= array(); 
		$datarealisasils		= array(); 
		if (isset($realisasispm) && is_array($realisasispm) && count($realisasispm)) :
			foreach ($realisasispm as $record) :
				$datarealisasi[$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput] = $record->jumlah;
			endforeach;
		endif;
		
		// realisasi LS
		$realisasils = $this->Sasdd_spmmak_model->getrealisasilsperkegiatan($kdkmpnen,$kdskmpnen);
		$datarealisasils		= array(); 
		if (isset($realisasils) && is_array($realisasils) && count($realisasils)) :
			foreach ($realisasils as $record) :
					$datarealisasils[$record->kdkmpnen."".$record->kdskmpnen."".$record->kdoutput] = $record->jumlah;
			endforeach;
		endif;
		
		//print_r($datarealisasispm);
		$display = "";
		$display .= $this->load->view('realisasi/realisasiperkegiatan',array("output"=>$kdoutput,"masterkegiatans"=>$masterkegiatans,"datarealisasi"=>$datarealisasi,"datarealisasils"=>$datarealisasils,"datapagu"=>$datapagu,"datarealisasikuitansi"=>$datarealisasikuitansi),true);	
		echo $display;
		die();
	}
	public function realisasisascon()
	{
		$this->load->model('e_realisasi/Sasmm_spmmak_model', null, true);
		$kegiatan 	= $this->input->post('kegiatan');
		$varmak 	= $this->input->post('varmak');
		$valoutput 	= $this->input->post('output');
		$tahun 		= $this->input->post('tahun') != "" ? $this->input->post('tahun') : "2018";
		
		$key 	= "";//$this->input->post('key');
		$output = "";
		if($kegiatan=="" and $this->input->get('key') != "" or $this->input->get('output') != ""){
			$kegiatan = $this->input->get('kegiatan');
			$valoutput 	= $this->input->get('output');
			$key 	= $this->input->get('key');
			
			$mode = $this->uri->segment(5);
		}
		$kdkmpnen = "";
		$kdskmpnen = "";
		$kdgiat = "";
		$kdoutput = "";
		$kdsoutput = "";
		if($valoutput !=""){
			$aroutput = explode("-",$valoutput);
			$kdgiat = $aroutput[0];
			$kdoutput = $aroutput[1];
			$kdsoutput = $aroutput[2];
		}
		$this->load->model('e_realisasi/output_model', null, true);
		$masterkegiatans = $this->output_model->tayangkegiatan($tahun,$kdoutput,$kdsoutput,$key,$kdgiat);
		//print_r($masterkegiatans);
		$datarealisasi 			= array(); 
		$this->load->model('e_realisasi/dd_drpp_dt_model', null, true);
		$dd_drpp_dt = $this->dd_drpp_dt_model->getrealisasi($tahun);
		$datarealisasi = array(); 
		if (isset($dd_drpp_dt) && is_array($dd_drpp_dt) && count($dd_drpp_dt)) :
			foreach ($dd_drpp_dt as $record) :
				//$datarealisasi[$record->kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun] = $record->jumlah;
				//echo $record->kdgiat.$record->kdoutput.$record->kdsoutput.$record->kdkmpnen.$record->kdskmpnen.$record->kdakun." = ".$record->jumlah."<br>";
			endforeach;
		endif;
		
		// realisasi kuitansi
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		$kuitansirealisasi = $this->d_kuitansi_model->getrealisasi($tahun,$kdkmpnen,$kdskmpnen,$output);
		//print_r($kuitansirealisasi);
		$datarealisasikuitansi 		= array(); 
		if (isset($kuitansirealisasi) && is_array($kuitansirealisasi) && count($kuitansirealisasi)) :
			foreach ($kuitansirealisasi as $record) :
				$datarealisasikuitansi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $record->jumlah;
				//echo trim($record->kdgiat)."".trim($record->kdoutput)." SO ".trim($record->kdsoutput)." ".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun).": ". $record->jumlah."<br>";
			endforeach;
		endif;
		// realisasi pak jana
		
		$this->load->model('e_realisasi/Sasdd_spmmak_model', null, true);
		$realisasispm =  $this->Sasdd_spmmak_model->getrealisasi($tahun,$kdkmpnen,$kdskmpnen,$output);
		//print_r($realisasispm);
		// data realisasi yang sebelumnya dari drp sekarang dari SPM
		
		$datarealisasils		= array(); 
		if (isset($realisasispm) && is_array($realisasispm) && count($realisasispm)) :
			foreach ($realisasispm as $record) :
				//echo trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)." = ".$record->jumlah."<br>";
				$datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $record->jumlah;
			endforeach;
		endif;
		
		$realisasispm = $this->Sasmm_spmmak_model->getrealisasils($tahun,$kdkmpnen,$kdskmpnen,$output);
		if (isset($realisasispm) && is_array($realisasispm) && count($realisasispm)) :
			foreach ($realisasispm as $record) :
				if(isset($datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)])){
					$datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] + $record->jumlah;
				}else{
					$datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $record->jumlah;
				}
			endforeach;
		endif;
		
		//print_r($datarealisasi);
		// realisasi LS
		$realisasils = $this->Sasdd_spmmak_model->getrealisasils($tahun,$kdkmpnen,$kdskmpnen,$output);
		$datarealisasils		= array(); 
		if (isset($realisasils) && is_array($realisasils) && count($realisasils)) :
			foreach ($realisasils as $record) :
				$datarealisasils[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $record->jumlah;
				//$datarealisasils[$record->kdakun.""."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdsoutput] = $record->jumlah;
			endforeach;
		endif;
		
		
		
		//print_r($datarealisasispm);
		$display = "";
		$display .= $this->load->view('realisasi/realisasisas',array("tahun"=>$tahun,"kegiatan"=>$kegiatan,"masterkegiatans"=>$masterkegiatans,"datarealisasi"=>$datarealisasi,"datarealisasils"=>$datarealisasils,"datarealisasikuitansi"=>$datarealisasikuitansi,"output"=>$valoutput,"key"=>$key,"varmak"=>$varmak),true);	
		echo $display;
		die();
	}
	public function realisasisas()
	{
		$mode = "";
		$kegiatan 	= $this->input->post('kegiatan');
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : "2018";
		
		$mode = $this->uri->segment(5);
		$this->load->model('e_realisasi/Sasmm_spmmak_model', null, true);
		$kegiatan 	= $this->input->post('kegiatan');
		$varmak 	= $this->input->post('varmak');
		$valoutput 	= $this->input->post('output');
		$tahun 		= $this->input->post('tahun') != "" ? $this->input->post('tahun') : "2018";
		
		$key 	= "";//$this->input->post('key');
		$output = "";
		if($kegiatan=="" and $this->input->get('key') != "" or $this->input->get('output') != ""){
			$kegiatan = $this->input->get('kegiatan');
			$valoutput 	= $this->input->get('output');
			$key 	= $this->input->get('key');
			
			$mode = $this->uri->segment(5);
		}
		$kdkmpnen = "";
		$kdskmpnen = "";
		$kdgiat = "";
		$kdoutput = "";
		$kdsoutput = "";
		if($valoutput !=""){
			$aroutput = explode("-",$valoutput);
			$kdgiat = $aroutput[0];
			$kdoutput = $aroutput[1];
			$kdsoutput = $aroutput[2];
		}
		$this->load->model('e_realisasi/output_model', null, true);
		$masterkegiatans = $this->output_model->tayangkegiatan($tahun,$kdoutput,$kdsoutput,$key,$kdgiat);
		//print_r($masterkegiatans);
		$datarealisasi 			= array(); 
		$this->load->model('e_realisasi/dd_drpp_dt_model', null, true);
		$dd_drpp_dt = $this->dd_drpp_dt_model->getrealisasi($tahun);
		$datarealisasi = array(); 
		if (isset($dd_drpp_dt) && is_array($dd_drpp_dt) && count($dd_drpp_dt)) :
			foreach ($dd_drpp_dt as $record) :
				//$datarealisasi[$record->kdgiat."".$record->kdoutput."".$record->kdsoutput."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdakun] = $record->jumlah;
				//echo $record->kdgiat.$record->kdoutput.$record->kdsoutput.$record->kdkmpnen.$record->kdskmpnen.$record->kdakun." = ".$record->jumlah."<br>";
			endforeach;
		endif;
		
		// realisasi kuitansi
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		$kuitansirealisasi = $this->d_kuitansi_model->getrealisasi($tahun,$kdkmpnen,$kdskmpnen,$output);
		//print_r($kuitansirealisasi);
		$datarealisasikuitansi 		= array(); 
		if (isset($kuitansirealisasi) && is_array($kuitansirealisasi) && count($kuitansirealisasi)) :
			foreach ($kuitansirealisasi as $record) :
				$datarealisasikuitansi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $record->jumlah;
				//echo trim($record->kdgiat)."".trim($record->kdoutput)." SO ".trim($record->kdsoutput)." ".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun).": ". $record->jumlah."<br>";
			endforeach;
		endif;
		// realisasi pak jana
		
		$this->load->model('e_realisasi/Sasdd_spmmak_model', null, true);
		$realisasispm =  $this->Sasdd_spmmak_model->getrealisasi($tahun,$kdkmpnen,$kdskmpnen,$output);
		//print_r($realisasispm);
		// data realisasi yang sebelumnya dari drp sekarang dari SPM
		
		$datarealisasils		= array(); 
		if (isset($realisasispm) && is_array($realisasispm) && count($realisasispm)) :
			foreach ($realisasispm as $record) :
				//echo trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)." = ".$record->jumlah."<br>";
				$datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $record->jumlah;
			endforeach;
		endif;
		
		$realisasispm = $this->Sasmm_spmmak_model->getrealisasils($tahun,$kdkmpnen,$kdskmpnen,$output);
		if (isset($realisasispm) && is_array($realisasispm) && count($realisasispm)) :
			foreach ($realisasispm as $record) :
				if(isset($datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)])){
					$datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] + $record->jumlah;
				}else{
					$datarealisasi[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $record->jumlah;
				}
			endforeach;
		endif;
		
		//print_r($datarealisasi);
		// realisasi LS
		$realisasils = $this->Sasdd_spmmak_model->getrealisasils($tahun,$kdkmpnen,$kdskmpnen,$output);
		$datarealisasils		= array(); 
		if (isset($realisasils) && is_array($realisasils) && count($realisasils)) :
			foreach ($realisasils as $record) :
				$datarealisasils[trim($record->kdgiat)."".trim($record->kdoutput)."".trim($record->kdsoutput)."".trim($record->kdkmpnen)."".trim($record->kdskmpnen)."".trim($record->kdakun)] = $record->jumlah;
				//$datarealisasils[$record->kdakun.""."".$record->kdkmpnen."".$record->kdskmpnen."".$record->kdsoutput] = $record->jumlah;
			endforeach;
		endif;
		
		if($mode == "print")
			Template::set_theme('print');
		
		$this->load->model('e_realisasi/output_model', null, true);
		$masterkegiatans = $this->output_model->tayangkegiatan($tahun,$kdoutput,$kdsoutput,$key,$kdgiat);
		Template::set('masterkegiatans', $masterkegiatans);
		
		Template::set('datarealisasikuitansi', $datarealisasikuitansi);
		Template::set('datarealisasi', $datarealisasi);
		Template::set('datarealisasils', $datarealisasils);
		Template::set('kegiatan', $kegiatan);
		Template::set('output', $output);
		Template::set('varmak', $varmak);
		
		Template::set('key', $key);
		Template::set('toolbar_title', 'Print Realisasi');
		Template::render();
	}
	public function getrkakl()
	{
		
		$kegiatan 	= $this->input->post('kegiatan');
		$output 	= $this->input->post('output');
		$kdkmpnen = "";
		$kdskmpnen = "";
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : "2018";
		if($kegiatan!=""){
			$arkegiatan = explode("-",$kegiatan);
			$kdkmpnen = $arkegiatan[0];
			$kdskmpnen = $arkegiatan[1];
		}
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatans = $this->kegiatan_model->tayangkegiatanrkakl($tahun,$kdkmpnen,$kdskmpnen,$output);
		 
		//print_r($masterkegiatans);
	 
		$display = $this->load->view('realisasi/datarkakl',array("masterkegiatans"=>$masterkegiatans,"tahun"=>$tahun),true);	
		echo $display;
		die();
	}
	public function realperbulan()
	{
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatan = $this->kegiatan_model->getdistinct();
		Template::set('masterkegiatans', $masterkegiatan);
		//print_r($masterkegiatan);
		Template::set('toolbar_title', 'Realisasi Perkegiatan');
		Template::render();
	}
	public function getrealisasiperbulan()
	{
		$kegiatan 	= $this->input->post('kegiatan');
		$valoutput 	= $this->input->post('output');
		$tahun = $this->input->post('tahun') ? $this->input->post('tahun') : "2018";
		$kdkmpnen = "";
		$kdskmpnen = "";
		$kdgiat = "";
		$kdoutput = "";
		$kdsoutput = "";
		//die($valoutput);
		// echo $tahun;
		if($valoutput !=""){
			$aroutput = explode("-",$valoutput);
			$kdgiat = $aroutput[0];
			$kdoutput = isset($aroutput[1]) ? $aroutput[1] : "";
			$kdsoutput = isset($aroutput[2]) ? $aroutput[2] : "";
		}
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatan = $this->kegiatan_model->getdistinctkegiatan("","","",$tahun);
		if (isset($masterkegiatan) && is_array($masterkegiatan) && count($masterkegiatan)) :
			foreach ($masterkegiatan as $record) :
				//	echo $record->kdgiat. "-".$record->kdoutput. "-".$record->kdsoutput."<br>";
			endforeach;
		endif;
		// pagu
		$this->load->model('e_realisasi/rkakl_model', null, true);
		$rekappermak = $this->rkakl_model->rekappermakkegiatan($tahun);
		$datapagu 		= array(); 
		//print_r($rekappermak);
		$no = 1;
		if (isset($rekappermak) && is_array($rekappermak) && count($rekappermak)) :
			foreach ($rekappermak as $record) :
					$datapagu[$record->kdgiat."-".$record->kdoutput."-".$record->kdsoutput."-".$record->kdkmpnen."-".$record->kdskmpnen] = $record->pagu;
					//echo $no. "-".$record->kdgiat. "-".$record->kdoutput. "-".$record->kdsoutput." = ".$record->pagu."<br>";
				$no++;
			endforeach;
		endif;
		// end pagu
		$this->load->model('e_realisasi/Sasdd_spmmak_model', null, true);
		$realisasispm =  $this->Sasdd_spmmak_model->getrealisasiperbulan($tahun,$kdkmpnen,$kdskmpnen,$kdoutput);
		//print_r($realisasispm);
		// data realisasi yang sebelumnya dari drp sekarang dari SPM
		$datarealisasi 			= array(); 
		$datarealisasils		= array(); 
		$jumlah = 0;
		if (isset($realisasispm) && is_array($realisasispm) && count($realisasispm)) :
			foreach ($realisasispm as $record) :
				$datarealisasi[$record->kdgiat."-".$record->kdoutput."-".$record->kdsoutput."-".$record->kdkmpnen."-".$record->kdskmpnen."-".trim($record->year)."-".trim($record->month)] = $record->jumlah;
			endforeach;
		endif;
		//echo $jumlah;
		$display = "";
		$display .= $this->load->view('realisasi/realperbulancontent',array("masterkegiatan"=>$masterkegiatan,"tahun"=>$tahun,"output"=>$kdoutput,"datapagu"=>$datapagu,"datarealisasi"=>$datarealisasi),true);	
		echo $display;
		die();
	}
	//--------------------------------------------------------------------


	/**
	 * Creates a e Realisasi object.
	 *
	 * @return void
	 */
	public function ambildata()
	{
		$this->auth->restrict('E_Realisasi.Realisasi.Create');

		Assets::add_module_js('e_realisasi', 'e_realisasi.js');

		Template::set('toolbar_title', 'e Realisasi');
		Template::render();
	}
	public function generatedata()
	{
		$this->auth->restrict('E_Realisasi.Realisasi.Create');
		$this->load->library('apiservicesas');
		// get data kuitansi
		$result = $this->apiservicesas->getdatadd_kuitansi("323232");
		$datakuitansirecord = json_decode($result);
		//print_r($result);
		//die("masuk");
		if(!isset($datakuitansirecord->records[0])){
			
			die("Terjadi Kesalahan pada koneksi aplikasi SAS, silahkan pastikan komputer aplikasi SAS sudah menyala.");
		}
		// data awal
		
		
		//print_r($datakuitansirecord);
		$index = 1;
		//print_r($datadecode);
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		$datadel = array('thang '=>"2018");
		$this->d_kuitansi_model->delete_where($datadel);
		foreach ($datakuitansirecord->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				$data['kdbpp']        = $dat->kdbpp;
				$data['nokwt']        = $dat->nokwt;
				$data['tglkwt']        = $dat->tglkwt;
				$data['code_id']        = trim($dat->code_id);
				$data['thang']        = $dat->thang;
				$data['kdjendok']        = $dat->kdjendok;
				$data['kddept']        = $dat->kddept;
				$data['kdunit']        = $dat->kdunit;
				$data['kdsatker']        = $dat->kdsatker;
				$data['kddekon']        = $dat->kddekon;
				$data['nokarwas']        = $dat->nokarwas;
				$data['kdkppn']        = $dat->kdkppn;
				$data['kdlokasi']        = $dat->kdlokasi;
				$data['kdkabkota']        = $dat->kdkabkota;
				$data['kdjnsban']        = $dat->kdjnsban;
				
				$data['kdbeban']        = $dat->kdbeban;
				$data['kdctarik']        = $dat->kdctarik;
				$data['kdsdana']        = $dat->kdsdana;
				$data['thbeban']        = $dat->thbeban;
				$data['kdkelbay']        = $dat->kdkelbay;
				$data['kdpinjam']        = $dat->kdpinjam;
				$data['noregis']        = $dat->noregis;
				$data['kdprogram']        = $dat->kdprogram;
				$data['kdgiat']        = $dat->kdgiat;
				$data['kdoutput']        = $dat->kdoutput;
				$data['kdsoutput']        = $dat->kdsoutput;
				$data['kdkmpnen']        = $dat->kdkmpnen;
				$data['kdskmpnen']        = $dat->kdskmpnen;
				
				$data['kdbkpk']        = $dat->kdbkpk;
				$data['kdakun']        = $dat->kdakun;
				$data['rupiah']        = $dat->rupiah;
				$data['uraian']        = $dat->uraian;
				$data['nipppk']        = $dat->nipppk;
				$data['nmppk']        = $dat->nmppk;
				$data['jabtrim']        = $dat->jabtrim;
				$data['nmtrim']        = $dat->nmtrim;
				$data['niptgjwb']        = $dat->niptgjwb;
				$data['nmtgjwb']        = $dat->nmtgjwb;
				$data['kota']        = $dat->kota;
				$data['notran']        = $dat->notran;
				$data['tgltran']        = $dat->tgltran;
				$data['nopjk']        = $dat->nopjk;
				
				$data['nosp2d']        = $dat->nosp2d;
				$data['nokwt2']        = $dat->nokwt2;
				$data['npwp']        = $dat->npwp;
				$data['nodrpp']        = $dat->nodrpp;
				$data['tgcreate']        = $dat->tgcreate;
				$data['usernip']        = $dat->usernip;
				$data['register']        = $dat->register;
				$id = $this->d_kuitansi_model->insert($data);
				$index++;
			}
			 
		}
		//die("masuk");
		// getdata drp dt
		$this->load->model('e_realisasi/dd_drpp_dt_model', null, true);
		$datadel = array('thang '=>"2018");
		$this->dd_drpp_dt_model->delete_where($datadel);
		
		$resultdddrp = $this->apiservicesas->getdatadd_drpp_dt("323232","drp");
		//print_r($resultdddrp);
		$datadrpdt = json_decode($resultdddrp);
		//print_r($datadrpdt);
		//die();
		$index = 1;
		$sasdd_drpp_dt = $this->db->list_fields('sasdd_drpp_dt');
		foreach ($datadrpdt->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasdd_drpp_dt as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->dd_drpp_dt_model->insert($data);
				$index++;
			}
			 
		}
		
		
		// data d spm
		$result = $this->apiservicesas->getdatad_spm("323232");
		$dataspmrecord = json_decode($result);
		//print_r($datakuitansirecord);
		//die();
		$index = 1;
		//print_r($datadecode);
		$this->load->model('e_realisasi/sasd_spmmak_model', null, true);
		$datadel = array('thang '=>"2018");
		$this->sasd_spmmak_model->delete_where($datadel);
		
		$sasd_spmindfield = $this->db->list_fields('sasd_spmmak');
		foreach ($dataspmrecord->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->sasd_spmmak_model->insert($data);
				$index++;
			}
			 
		}
		
		// get data dd spm
		$result = $this->apiservicesas->getdatadspm("323232");
		$dataspmrecord = json_decode($result);
		//print_r($datakuitansirecord);
		$index = 1;
		//print_r($datadecode);
		$this->load->model('e_realisasi/sasdd_spmmak_model', null, true);
		$datadel = array('thang '=>"2018");
		$this->sasdd_spmmak_model->delete_where($datadel);
		
		$sasd_spmindfield = $this->db->list_fields('sasdd_spmmak');
		foreach ($dataspmrecord->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->sasdd_spmmak_model->insert($data);
				$index++;
			}
			 
		}
		// end data PSM
		
		// get data spmid
		$result = $this->apiservicesas->getdatadspmid("323232");
		$dataspmrecord = json_decode($result);
		//print_r($datakuitansirecord);
		//die();
		$index = 1;
		//print_r($datadecode);
		$this->load->model('e_realisasi/sasd_spmind_model', null, true);
		$datadel = array('thang '=>"2018");
		$this->sasd_spmind_model->delete_where($datadel);
		
		$sasd_spmindfield = $this->db->list_fields('sasd_spmind');
		foreach ($dataspmrecord->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->sasd_spmind_model->insert($data);
				$index++;
			}
			 
		}
		// end data PSM ID
		
		// getdata mm spm (gaji ls dll)
		$this->load->model('e_realisasi/sasmm_spmmak_model', null, true);
		$datadel = array('thang '=>"2018");
		$this->sasmm_spmmak_model->delete_where($datadel);
		
		$resultdddrp = $this->apiservicesas->getdatadasar("323232","mmspm");
		//print_r($resultdddrp);
		$datadrpdt = json_decode($resultdddrp);
		//print_r($datadrpdt);
		//die();
		$index = 1;
		$sasdd_drpp_dt = $this->db->list_fields('sasmm_spmmak');
		foreach ($datadrpdt->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasdd_drpp_dt as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->sasmm_spmmak_model->insert($data);
				$index++;
			}
			 
		}
		
		// dd_tranbend
		$this->load->model('e_realisasi/dd_tranbend_model', null, true);
		$datadel = array('thang '=>"2018");
		$this->dd_tranbend_model->delete_where($datadel);
		
		$resultdddrp = $this->apiservicesas->getdatadasar("323232","dd_tranbend");
		//print_r($resultdddrp);
		$datadrpdt = json_decode($resultdddrp);
		print_r($datadrpdt);
		die();
		$index = 1;
		$sasdd_drpp_dt = $this->db->list_fields('sasdd_tranbend');
		foreach ($datadrpdt->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasdd_drpp_dt as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->dd_tranbend_model->insert($data);
				$index++;
			}
			 
		}
		
		
		Template::set_message("Generate data DRP Selesai", 'error');
		die("Generate data DRP Selesai");
		exit();
	}
	public function generatedatatransaksi()
	{
		$this->auth->restrict('E_Realisasi.Realisasi.Create');
		$this->load->library('apiservicesas');
		$indexkuitansi = 0;
		$indexdrpdt 	= 0;
		$indexdspmmak = 0;
		$indexddspmmak = 0;
		$indexspmid	= 0;
		$indextranbendahara = 0;
		$this->load->model('e_realisasi/sas_model', null, true);
		// data item RKAKL
		$recorddatakuitansi = $this->sas_model->get_kuitansi();
		if(isset($recorddatakuitansi) && is_array($recorddatakuitansi) && count($recorddatakuitansi)):

			$this->load->model('e_realisasi/d_kuitansi_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->d_kuitansi_model->delete_where($datadel);

			foreach ($recorddatakuitansi as $record) :
				//print_r($record);
				$data = array();
				 //die($record->kdbpp." ini");
					$data['kdbpp']        = $record->kdbpp;
					$data['nokwt']        = $record->nokwt;
					$data['tglkwt']        = $record->tglkwt;
					$data['code_id']        = trim($record->code_id);
					$data['thang']        = $record->thang;
					$data['kdjendok']        = $record->kdjendok;
					$data['kddept']        = $record->kddept;
					$data['kdunit']        = $record->kdunit;
					$data['kdsatker']        = $record->kdsatker;
					$data['kddekon']        = $record->kddekon;
					$data['nokarwas']        = $record->nokarwas;
					$data['kdkppn']        = $record->kdkppn;
					$data['kdlokasi']        = $record->kdlokasi;
					$data['kdkabkota']        = $record->kdkabkota;
					$data['kdjnsban']        = $record->kdjnsban;
					
					$data['kdbeban']        = $record->kdbeban;
					$data['kdctarik']        = $record->kdctarik;
					$data['kdsdana']        = $record->kdsdana;
					$data['thbeban']        = $record->thbeban;
					$data['kdkelbay']        = $record->kdkelbay;
					$data['kdpinjam']        = $record->kdpinjam;
					$data['noregis']        = $record->noregis;
					$data['kdprogram']        = $record->kdprogram;
					$data['kdgiat']        = $record->kdgiat;
					$data['kdoutput']        = $record->kdoutput;
					$data['kdsoutput']        = $record->kdsoutput;
					$data['kdkmpnen']        = $record->kdkmpnen;
					$data['kdskmpnen']        = $record->kdskmpnen;
					
					$data['kdbkpk']        = $record->kdbkpk;
					$data['kdakun']        = $record->kdakun;
					$data['rupiah']        = $record->rupiah;
					$data['uraian']        = $record->uraian;
					$data['nipppk']        = $record->nipppk;
					$data['nmppk']        = $record->nmppk;
					$data['jabtrim']        = $record->jabtrim;
					$data['nmtrim']        = $record->nmtrim;
					$data['niptgjwb']        = $record->niptgjwb;
					$data['nmtgjwb']        = $record->nmtgjwb;
					$data['kota']        = $record->kota;
					$data['notran']        = $record->notran;
					$data['tgltran']        = $record->tgltran;
					$data['nopjk']        = $record->nopjk;
					
					$data['nosp2d']        = $record->nosp2d;
					$data['nokwt2']        = $record->nokwt2;
					$data['npwp']        = $record->npwp;
					$data['nodrpp']        = $record->nodrpp;
					$data['tgcreate']        = $record->tgcreate;
					$data['usernip']        = $record->usernip;
					$data['register']        = $record->register;
				 
				$id = $this->d_kuitansi_model->insert($data);
				$indexkuitansi++;
			endforeach;
		endif;
		//
		// data DRP DT
		$recorddrpdt = $this->sas_model->get_dd_drpp_dt();
		if(isset($recorddrpdt) && is_array($recorddrpdt) && count($recorddrpdt)):
			// hapus datalama
			$this->load->model('e_realisasi/dd_drpp_dt_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->dd_drpp_dt_model->delete_where($datadel);
			
			$sasdd_drpp_dt = $this->db->list_fields('sasdd_drpp_dt');
			foreach ($recorddrpdt as $record) :
				$data = array();
				foreach($sasdd_drpp_dt as $field)
				{
					$data[$field]        = $record->$field;
				}
				$id = $this->dd_drpp_dt_model->insert($data);
				$indexdrpdt++;
			endforeach;
		endif;
		
		// data D SPM MAK
		$record_spm_mak = $this->sas_model->get_d_spm_mak();
		if(isset($record_spm_mak) && is_array($record_spm_mak) && count($record_spm_mak)):
			// hapus datalama
			$this->load->model('e_realisasi/sasd_spmmak_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->sasd_spmmak_model->delete_where($datadel);
			
			$sasd_spmindfield = $this->db->list_fields('sasd_spmmak');
			foreach ($record_spm_mak as $record) :
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
					$data[$field]        = $record->$field;
				}
				$id = $this->sasd_spmmak_model->insert($data);
				$indexdspmmak++;
			endforeach;
		endif;

		// data DD SPM MAK
		$record_dd_spm_mak = $this->sas_model->get_dd_spm_mak();
		if(isset($record_dd_spm_mak) && is_array($record_dd_spm_mak) && count($record_dd_spm_mak)):
			// hapus datalama
			$this->load->model('e_realisasi/sasdd_spmmak_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->sasdd_spmmak_model->delete_where($datadel);
			
			$sasd_spmindfield = $this->db->list_fields('sasdd_spmmak');
			foreach ($record_dd_spm_mak as $record) :
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
					$data[$field]        = $record->$field;
				}
				$id = $this->sasdd_spmmak_model->insert($data);
				$indexddspmmak++;
			endforeach;
		endif;

		// data SPM ID
		$record_spmid = $this->sas_model->get_d_spm_id();
		if(isset($record_spmid) && is_array($record_spmid) && count($record_spmid)):
			// hapus datalama
			$this->load->model('e_realisasi/sasd_spmind_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->sasd_spmind_model->delete_where($datadel);
			
			$sasd_spmindfield = $this->db->list_fields('sasd_spmind');
			foreach ($record_spmid as $record) :
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
					$data[$field]        = $record->$field;
				}
				$id = $this->sasd_spmind_model->insert($data);
				$indexspmid++;
			endforeach;
		endif;

		// data Transaksi bendahara
		/*
		$record_d_tranbend = $this->sas_model->get_t_tranbend();
		if(isset($record_d_tranbend) && is_array($record_d_tranbend) && count($record_d_tranbend)):
			// hapus datalama
			$this->load->model('e_realisasi/t_tranbend_model', null, true);
			$datadel = array('idtran'=>"1");
			$this->t_tranbend_model->delete_where($datadel);
			
			$sasdd_tranbendfield = $this->db->list_fields('sast_tranbend');
			foreach ($record_d_tranbend as $record) :
				$data = array();
				foreach($sasdd_tranbendfield as $field)
				{
					$data[$field]        = $record->$field;
				}
				$id = $this->t_tranbend_model->insert($data);
				$indextranbendahara++;
			endforeach;
		endif;
		*/
		die("Generate data Selesai, Jumlah data kuitansi : ".$indexkuitansi.", DRP : ".$indexdrpdt.", D SPM : ".$indexdspmmak.", DD SPM : ".$indexddspmmak.", SPM ID : ".$indexspmid);
		exit();
	}
	public function generatepagu()
	{
		$this->auth->restrict('E_Realisasi.Realisasi.Create');
		$this->load->library('apiservicesas');
		$indexitem = 0;
		$indexd_output = 0;
		$indexd_soutput = 0;
		$indexd_kmpnen = 0;
		$indexd_skmpnen = 0;
		$this->load->model('e_realisasi/sas_model', null, true);
		// data item RKAKL
		$recorditems = $this->sas_model->get_dataitem();
		if(isset($recorditems) && is_array($recorditems) && count($recorditems)):
			// hapus datalama
			$this->load->model('e_realisasi/rkakl_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->rkakl_model->delete_where($datadel);
			$itemfield = $this->db->list_fields('sasd_item');
			foreach ($recorditems as $record) :
				 
				$data = array();
				foreach($itemfield as $field)
				{
						$data[$field]        = $record->$field;
				}
				$id = $this->rkakl_model->insert($data);
				$indexitem++;
			endforeach;
		endif;
		// data d output
		$recordd_outputs = $this->sas_model->get_datad_output();
		if(isset($recordd_outputs) && is_array($recordd_outputs) && count($recordd_outputs)):
			// hapus datalama
			$this->load->model('e_realisasi/d_output_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->d_output_model->delete_where($datadel);

			$sasd_outputfield = $this->db->list_fields('sasd_output');
			foreach ($recordd_outputs as $record) :
				 
				$data = array();
				foreach($sasd_outputfield as $field)
				{
						$data[$field]        = $record->$field;
				}
				$id = $this->d_output_model->insert($data);
				$indexd_output++;
			endforeach;
		endif;

		// data d sub output
		$recordd_soutputs = $this->sas_model->get_datad_soutput();
		if(isset($recordd_soutputs) && is_array($recordd_soutputs) && count($recordd_soutputs)):
			// hapus datalama
			$this->load->model('e_realisasi/soutput_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->soutput_model->delete_where($datadel);

			$sasd_soutputfield = $this->db->list_fields('sasd_soutput');
			foreach ($recordd_soutputs as $record) :
				 
				$data = array();
				foreach($sasd_soutputfield as $field)
				{
						$data[$field]        = $record->$field;
				}
				$id = $this->soutput_model->insert($data);
				$indexd_soutput++;
			endforeach;
		endif;
		// data Komponen
		$recordkomponens = $this->sas_model->get_data_komponen();
		if(isset($recordkomponens) && is_array($recordkomponens) && count($recordkomponens)):
			// hapus datalama
			$this->load->model('e_realisasi/kmpnen_model', null, true);
			$datadel = array('thang '=>"2018");
			$this->kmpnen_model->delete_where($datadel);

			$sasd_kmpnenfield = $this->db->list_fields('sasd_kmpnen');
			foreach ($recordkomponens as $record) :
				 
				$data = array();
				foreach($sasd_kmpnenfield as $field)
				{
						$data[$field]        = $record->$field;
				}
				$id = $this->kmpnen_model->insert($data);
				$indexd_kmpnen++;
			endforeach;
		endif;
		// data sub Komponen
		$recordskomponens = $this->sas_model->get_data_skomponen();
		if(isset($recordskomponens) && is_array($recordskomponens) && count($recordskomponens)):
			// hapus datalama
			$this->load->model('e_realisasi/skmpnen_model', null, true);
		
			$datadel = array('thang '=>"2018");
			$this->skmpnen_model->delete_where($datadel);

			$sasd_skmpnenfield = $this->db->list_fields('sasd_skmpnen');
			foreach ($recordskomponens as $record) :
				 
				$data = array();
				foreach($sasd_skmpnenfield as $field)
				{
						$data[$field]        = $record->$field;
				}
				$id = $this->skmpnen_model->insert($data);
				$indexd_skmpnen++;
			endforeach;
		endif;
		//echo $indexd_skmpnen;

		// data sub Komponen
		$recordskomponens = $this->sas_model->get_data_skomponen();
		if(isset($recordskomponens) && is_array($recordskomponens) && count($recordskomponens)):
			// hapus datalama
			$this->load->model('e_realisasi/skmpnen_model', null, true);
		
			$datadel = array('thang '=>"2018");
			$this->skmpnen_model->delete_where($datadel);

			$sasd_skmpnenfield = $this->db->list_fields('sasd_skmpnen');
			foreach ($recordskomponens as $record) :
				 
				$data = array();
				foreach($sasd_skmpnenfield as $field)
				{
						$data[$field]        = $record->$field;
				}
				$id = $this->skmpnen_model->insert($data);
				$indexd_skmpnen++;
			endforeach;
		endif;
		
		die("Generate data Selesai, Jumlah data Item : ".$indexitem.", Output : ".$indexd_output.", Sub output : ".$indexd_soutput.", Komponen : ".$indexd_kmpnen.", Sub Komponen : ".$indexd_skmpnen);
		exit();
	}
	// generate data revisi fungsi dari luar
	public function generatedatarevisi()
	{
		$this->auth->restrict('E_Realisasi.Realisasi.Create');
		$this->load->library('apiservicesas');
		 
		// get data item
		$result = $this->apiservicesas->getdataditem("323232");
		$dataitemrecords = json_decode($result);
		//print_r($result);
		//die("masuk");
		if(!isset($dataitemrecords->records[0])){
			
			die("Terjadi Kesalahan pada koneksi aplikasi SAS, silahkan pastikan komputer aplikasi SAS sudah menyala.");
		}
		
		//output
		$result = $this->apiservicesas->getdatadasar("323232","output");
		$dataspmrecord = json_decode($result);
		//print_r($datakuitansirecord);
		//die();
		$index = 1;
		//die("msuk");
		//print_r($dataspmrecord);
		$this->load->model('e_realisasi/d_output_model', null, true);
		
		$datadel = array('thang '=>"2018");
		$this->d_output_model->delete_where($datadel);
		
		$sasd_spmindfield = $this->db->list_fields('sasd_output');
		foreach ($dataspmrecord->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->d_output_model->insert($data);
				$index++;
			}
			 
		}
		// sub ourput
		$result = $this->apiservicesas->getdatadasar("323232","soutput");
		$dataspmrecord = json_decode($result);
		$this->load->model('e_realisasi/soutput_model', null, true);
		
		$datadel = array('thang '=>"2018");
		$this->soutput_model->delete_where($datadel);
		
		$sasd_spmindfield = $this->db->list_fields('sasd_soutput');
		foreach ($dataspmrecord->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->soutput_model->insert($data);
				$index++;
			}
			 
		}
		
		// Komponen
		$result = $this->apiservicesas->getdatadasar("323232","kmpnen");
		$dataspmrecord = json_decode($result);
		$this->load->model('e_realisasi/kmpnen_model', null, true);
		
		$datadel = array('thang '=>"2018");
		$this->kmpnen_model->delete_where($datadel);
		
		$sasd_spmindfield = $this->db->list_fields('sasd_kmpnen');
		foreach ($dataspmrecord->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->kmpnen_model->insert($data);
				$index++;
			}
			 
		}
		// Komponen
		$result = $this->apiservicesas->getdatadasar("323232","skmpnen");
		$dataspmrecord = json_decode($result);
		$this->load->model('e_realisasi/skmpnen_model', null, true);
		
		$datadel = array('thang '=>"2018");
		$this->skmpnen_model->delete_where($datadel);
		
		$sasd_spmindfield = $this->db->list_fields('sasd_skmpnen');
		foreach ($dataspmrecord->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($sasd_spmindfield as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->skmpnen_model->insert($data);
				$index++;
			}
			 
		}
		
		//print_r($datakuitansirecord);
		$index = 1;
		//print_r($datadecode);
		$this->load->model('e_realisasi/rkakl_model', null, true);
		$datadel = array('thang '=>"2018");
		$this->rkakl_model->delete_where($datadel);
		
		$itemfield = $this->db->list_fields('sasd_item');
		foreach ($dataitemrecords->records as $record) {
			foreach ($record as $dat) {
				$data = array();
				foreach($itemfield as $field)
				{
						//echo $field;
						$data[$field]        = $dat->$field;
				}
				$id = $this->rkakl_model->insert($data);
				$index++;
			}
			 
		}
		// end data PSM ID
		
		Template::set_message("Generate data DRP Selesai", 'error');
		die("Generate data DRP Selesai");
		exit();
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
	public function kuitansi()
	{
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');
		$kegiatan 	= $this->input->get('kegiatan');
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : "2018";
		$kdkmpnen = "";
		$kdskmpnen = "";
		if($kegiatan!=""){
			$arkegiatan = explode("-",$kegiatan);
			$kdkmpnen = $arkegiatan[0];
			$kdskmpnen = $arkegiatan[1];
		}
		
		$this->load->library('pagination');
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		
		$masterkegiatan = $this->kegiatan_model->getdistinct();
		Template::set('masterkegiatans', $masterkegiatan);
		
		$total = $this->d_kuitansi_model->count_allrakakl("",$kdkmpnen,$kdskmpnen,"",$tahun);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?kegiatan=".$kegiatan;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		 
		$records = $this->d_kuitansi_model->limit($limit, $offset)->find_allrakakl("",$kdkmpnen,$kdskmpnen,"",$tahun);

		Template::set('records', $records);
		Template::set('toolbar_title', 'List Kuitansi');
		Template::render();
	}
	public function setkuitansi()
	{
		$kdkmpnen 	= $this->input->get('kdkmpnen');
		$output 	= $this->input->get('kdoutput');
		$kdakun 	= $this->input->get('kdakun');
		$kdsoutput 	= $this->input->get('kdsoutput');
		$kdskmpnen 	= $this->input->get('kdskmpnen');
		$nokwt 		= $this->input->get('nokwt');
		
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatans = $this->kegiatan_model->tayangperkwitansi($kdkmpnen,$kdskmpnen,$output,$kdsoutput);
		 
		//print_r($datarealisasispm);
		$display = "";
		Template::set_theme('simple');
		
		Template::set('kdkmpnen', $kdkmpnen);
		Template::set('output', $output);
		Template::set('kdakun', $kdakun);
		Template::set('kdsoutput', $kdsoutput);
		Template::set('kdskmpnen', $kdskmpnen);
		Template::set('nokwt', $nokwt);
		
		Template::set('masterkegiatans', $masterkegiatans);
		Template::set('toolbar_title', 'Edit Kuitansi');
		Template::render();
	}
	public function savetokuitansirkakl()
	{
		$this->auth->restrict('E_Realisasi.Realisasi.Create');
		$kdkmpnen 	= $this->input->post('kdkmpnen');
		$kdoutput 	= $this->input->post('kdoutput');
		$kdakun 	= $this->input->post('kdakun');
		$kdsoutput 	= $this->input->post('kdsoutput');
		$kdskmpnen 	= $this->input->post('kdskmpnen');
		$nokwt 	= $this->input->post('nokwt');
		$thang 	= $this->input->post('thang');
		$noitem 	= $this->input->post('noitem');
		
		//print_r($datadecode);
		$this->load->model('e_realisasi/kuitansi_rkakl_model', null, true);
		//$datadel = array('thang '=>"2018");
		//$this->dd_drpp_dt_model->delete_where($datadel);
		 
		$data = array();
		$data['nokwt']        = $nokwt;
		$data['thang']        = $thang;
		$data['kdkmpnen']        = $kdkmpnen;
		$data['kdskmpnen']        = $kdskmpnen;
		$data['kdoutput']        = $kdoutput;
		$data['kdsoutput']        = $kdsoutput;
		$data['kdakun']        = $kdakun;
		$data['noitem']        = $noitem;
		$data['kdsatker']        = "";
		if($nokwt != ""){
			if($id = $this->kuitansi_rkakl_model->insert($data))
			{
				$msg = "Sukses";
			}else{
				$msg = "Sukses";
			}
		}else{
			$msg = "Kwitansi tidak ditemukan";
		}
		die($msg);
		exit();
	}
	public function delkuitansirkakl()
	{
		$this->auth->restrict('E_Realisasi.Realisasi.Delete');
		$nokwt 	= $this->input->post('nokwt');
		
		//print_r($datadecode);
		$this->load->model('e_realisasi/kuitansi_rkakl_model', null, true);
		if($nokwt != ""){
			$datadel = array('nokwt '=>$nokwt);
			$this->kuitansi_rkakl_model->delete_where($datadel);
			$msg = "Sukses";
		}else{
			$msg = "Kwitansi tidak ditemukan";
		}
		die($msg);
		exit();
	}
	public function buatspby()
	{
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		$kdkmpnen 	= $this->input->get('kdkmpnen');
		$output 	= $this->input->get('kdoutput');
		$kdakun 	= $this->input->get('kdakun');
		$kdsoutput 	= $this->input->get('kdsoutput');
		$kdskmpnen 	= $this->input->get('kdskmpnen');
		$nokwt 		= $this->input->get('nokwt');
		$kuitansidetil = $this->d_kuitansi_model->fidndetil("nokwt",$nokwt);
		Template::set('kuitansidetil', $kuitansidetil);
		//print_r($kuitansidetil);

		$this->load->model('e_realisasi/kegiatan_model', null, true);
		$masterkegiatans = $this->kegiatan_model->tayangperkwitansi($kdkmpnen,$kdskmpnen,$output,$kdsoutput);
		 
		//print_r($datarealisasispm);
		$display = "";
		Template::set_theme('print');
		
		Template::set('kdkmpnen', $kdkmpnen);
		Template::set('output', $output);
		Template::set('kdakun', $kdakun);
		Template::set('kdsoutput', $kdsoutput);
		Template::set('kdskmpnen', $kdskmpnen);
		Template::set('nokwt', $nokwt);
		
		Template::set('masterkegiatans', $masterkegiatans);
		Template::set('toolbar_title', 'Edit Kuitansi');
		Template::render();
	}
	public function printspby()
	{
		$kegiatan 	= $this->input->get('kegiatan');
		$nokwt 	= $this->input->get('nokwt');
		$kdkmpnen = "";
		$kdskmpnen = "";
		if($kegiatan!=""){
			$arkegiatan = explode("-",$kegiatan);
			$kdkmpnen = $arkegiatan[0];
			$kdskmpnen = $arkegiatan[1];
		}
		$this->load->library('pagination');
		$this->load->model('e_realisasi/d_kuitansi_model', null, true);
		
		$this->load->model('e_realisasi/kegiatan_model', null, true);
		
		$masterkegiatan = $this->kegiatan_model->getdistinct();
		Template::set('masterkegiatans', $masterkegiatan);
		
		$total = $this->d_kuitansi_model->count_allrakakl($nokwt,$kdkmpnen,$kdskmpnen);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?kegiatan=".$kegiatan;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		 
		$records = $this->d_kuitansi_model->limit($limit, $offset)->find_allrakakl($nokwt,$kdkmpnen,$kdskmpnen);
		Template::set_theme('print');
		Template::set('records', $records);
		Template::set('toolbar_title', 'Print SPBY');
		Template::render();
	}
	//-------------------------------------------------------------------- generate data pegawai ------
	

}