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

		//$this->auth->restrict('Dashboard_SPD.Reports.View');
		$this->lang->load('dashboard_spd');
		
		Template::set_block('sub_nav', 'reports/_sub_nav');

		Assets::add_module_js('dashboard_spd', 'dashboard_spd.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$tahun = "2017";//date("Y");
		$this->auth->restrict('Dashboard_SPD.Reports.View');
		$anggaran = $this->input->get('anggaran');
		Template::set('anggaran', $anggaran);
		$this->load->model('sppd/propinsi_model', null, true);
		$this->load->model('sppd/sppd_model', null, true);
		$this->load->model('e_realisasi/sasd_item_model', null, true);
		$propinsis = $this->sppd_model->rekap_provinsi();
		Template::set('propinsis', $propinsis);
		
		$recspd = $this->sppd_model->rekap_tahun($tahun,$anggaran);
		$adatasppd[] = array();
		if (isset($recspd) && is_array($recspd) && count($recspd)):
			foreach($recspd as $rec):
				$adatasppd[$rec->provinsi."-".$rec->pegawai] = $rec->jumlah;
			endforeach;
		endif;
		Template::set('adatasppd', $adatasppd);
		
		$pegawais = $this->sppd_model->dispegawai($tahun,$anggaran);
		Template::set('pegawais', $pegawais);
		
		$jmlperjalanan = $this->sppd_model->count_tahun($tahun,$anggaran);
		Template::set('jmlperjalanan', $jmlperjalanan);
		
		$count_blmspj = $this->sppd_model->count_blmspj($tahun,$anggaran);
		Template::set('count_blmspj', $count_blmspj);
		
		$count_blmlaporan = $this->sppd_model->count_blmlaporan($tahun,$anggaran);
		Template::set('count_blmlaporan', $count_blmlaporan);
		
		$sumrealisasi_tahun = $this->sppd_model->sumrealisasi_tahun($tahun,$anggaran);
		$jmlrealisasiperjalanan = isset($sumrealisasi_tahun[0]->jmlrealisasi) ? $sumrealisasi_tahun[0]->jmlrealisasi : "";
		Template::set('sumrealisasi_tahun', $jmlrealisasiperjalanan);
		
		$jmlpaguperjalanan = $this->sasd_item_model->sum_akunanggaran("524111",$tahun,$anggaran);
		$jumlah_pagu = isset($jmlpaguperjalanan[0]->jumlah_pagu) ? $jmlpaguperjalanan[0]->jumlah_pagu : 0;
		$persentase = 0;
		if($jmlrealisasiperjalanan != "" and $jumlah_pagu !="0")
			$persentase = ($jmlrealisasiperjalanan/$jumlah_pagu)*100;
		
		Template::set('jumlah_pagu', round($jumlah_pagu,2));
		Template::set('jmlrealisasiperjalanan', round($jmlrealisasiperjalanan,2));
		Template::set('persentase', round($persentase,2));

		$sumrealisasi_tahun = $this->sppd_model->perjalananperbulan($tahun,$anggaran);
		//Template::set('sumrealisasi_tahun', $sumrealisasi_tahun);
		$adatasppdbulan = array();
		for($i=1;$i<13;$i++){
			$adatasppdbulan[$i] = 0;
		}
		if (isset($sumrealisasi_tahun) && is_array($sumrealisasi_tahun) && count($sumrealisasi_tahun)):
			foreach($sumrealisasi_tahun as $rec):
				$adatasppdbulan[$rec->month] = $rec->jumlah;
			endforeach;
		endif;
		$nilai = "[".$adatasppdbulan[1].",".$adatasppdbulan[2].",".$adatasppdbulan[3].",".$adatasppdbulan[4].",".$adatasppdbulan[5].",".$adatasppdbulan[6].",".$adatasppdbulan[7].",".$adatasppdbulan[8].",".$adatasppdbulan[9].",".$adatasppdbulan[10].",".$adatasppdbulan[11].",".$adatasppdbulan[12]."]";
		//$output = $this->load->view('reports/dash',array('jumlah_pagu'=>$jumlah_pagu,'jmlrealisasiperjalanan'=>$jmlrealisasiperjalanan,'persentase'=>$persentase,'sumrealisasi_tahun'=>$sumrealisasi_tahun,'count_blmlaporan'=>$count_blmlaporan,'count_blmspj'=>$count_blmspj,'jmlperjalanan'=>$jmlperjalanan,'pegawais'=>$pegawais,'adatasppd'=>$adatasppd,'propinsis'=>$propinsis,'adatasppdbulan'=>$nilai),true);	
		// get belum laporan
		$reclaporan = $this->sppd_model->rekap_laporan($tahun,$anggaran);
		$adatalaporan[] = array();
		if (isset($reclaporan) && is_array($reclaporan) && count($reclaporan)):
			foreach($reclaporan as $rec):
				$adatalaporan[$rec->pegawai] = $rec->jumlah;
			endforeach;
		endif;
		//print_r($adatalaporan);
		Template::set('adatalaporan', $adatalaporan);


		Template::set('adatasppdbulan', $nilai);
		 
		Template::set('toolbar_title', 'Manage Dashboard SPD');
		Template::render();
	}

	//--------------------------------------------------------------------



}