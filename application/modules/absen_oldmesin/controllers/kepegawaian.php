<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * kepegawaian controller
 */
class kepegawaian extends Admin_Controller
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

		$this->auth->restrict('Absen.Kepegawaian.View');
		$this->load->model('absen_model', null, true);
		$this->lang->load('absen');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');

		$this->load->model('roles/role_model', null, true);
		$roles = $this->role_model->find_all();
		Template::set('roles', $roles);
		//print_r($roles);
		//die();
		Assets::add_module_js('absen', 'absen.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		
 
		$nip = $this->input->get('nip');
		$nama = $this->input->get('nama');
		$tgl = $this->input->get('tgl');
		$bulan = $this->input->get('bulan');
		$tahun = $this->input->get('tahun');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->absen_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('absen_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('absen_delete_failure') . $this->absen_model->error, 'error');
				}
			}
		}

		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->absen_model->where('nik',$this->current_user->nip);
		$total = $this->absen_model->count_all($nip,$nama,$tgl,$bulan,$tahun);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?nip=".$nip."&nama=".$nama."&tgl=".$tgl."&bulan=".$bulan."&tahun=".$tahun;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->absen_model->where('nik',$this->current_user->nip);
		$records = $this->absen_model->limit($limit, $offset)->find_all($nip,$nama,$tgl,$bulan,$tahun);
		Template::set('total', $total); 

		Template::set('records', $records);
		
		Template::set('nip', $nip); 
		Template::set('nama', $nama); 
		Template::set('tgl', $tgl); 
		Template::set('bulan', $bulan); 
		Template::set('tahun', $tahun); 
		Template::set('toolbar_title', 'Manage Absen');
		Template::render();
	}
	public function rekap()
	{
		$this->auth->restrict('Absen.Kepegawaian.Rekap');
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');
		$bulan 	= $this->input->post('bulan') != "" ? $this->input->post('bulan') : date("m");
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : date("Y");
		$role 	= $this->input->post('role');
		
		Template::set('bulan', $bulan);
		Template::set('role', $role);
		Template::set('tahun', $tahun);
		Template::set('toolbar_title', 'Rekap Absen');
		Template::render();
	}
	public function rekapum()
	{
		$this->auth->restrict('Absen.Kepegawaian.Rekap');
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');
		$bulan 	= $this->input->post('bulan') != "" ? $this->input->post('bulan') : date("m");
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : date("Y");
		$role 	= $this->input->post('role');
		
		Template::set('bulan', $bulan);
		Template::set('role', $role);
		Template::set('tahun', $tahun);
		Template::set('toolbar_title', 'Rekap Absen');
		Template::render();
	}
	function returnBetweenDates( $startDate, $endDate ){
    $startStamp = strtotime(  $startDate );
    $endStamp   = strtotime(  $endDate );

    if( $endStamp > $startStamp ){
        while( $endStamp >= $startStamp ){

            $dateArr[] = date( 'Y-m-d', $startStamp );

            $startStamp = strtotime( ' +1 day ', $startStamp );

        }
        return $dateArr;    
    }else{
        return $startDate;
    }

}
	public function rekap_content()
	{
		$nip 	= $this->input->post('nip');
		$nama 	= $this->input->post('nama');
		$bulan 	= $this->input->post('bulan') != "" ? $this->input->post('bulan') : date("m");
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : date("Y");
		$role 	= $this->input->post('role');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$nip = $this->current_user->nip;
		$recordabsen = $this->absen_model->rekap($nip,$nama,$bulan,$tahun);

		$jammasuk = "07:30:00";
		$jamtoleransi = $this->settings_lib->item('site.maxmasuk') != "" ? $this->settings_lib->item('site.maxmasuk') : "08:30:00";
		$jamplg = $this->settings_lib->item('site.maxpulang') != "" ? $this->settings_lib->item('site.maxpulang') : "16:00:00";
		
		//die($tahun);
		//get data izin
		$dataharilibur 		= array(); 
		$dataizin 		= array(); 
		$dataabsen 		= array(); 
		$datasppd 		= array(); 
		$datangterlambat1 		= array(); 
		$pulangcepat	 		= array(); 
		$arddk	 		= array(); 
		//hari libur
		$this->load->model('hari_libur/hari_libur_model', null, true);
		$recordhariliburs  	= $this->hari_libur_model->find_rekap($bulan,$tahun);
		if(isset($recordhariliburs) && is_array($recordhariliburs) && count($recordhariliburs)):
			foreach ($recordhariliburs as $record) :
					$dataharilibur[$record->tanggal] = $record->keterangan; 
					//echo $record->keterangan." data<br>";
			endforeach;
		endif;
		// end hari libur
		$this->load->model('surat_izin/surat_izin_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('user',$this->current_user->id);
		$recordsuratizin  	= $this->surat_izin_model->find_rekap($bulan,$tahun,$nip,$nama);
		//print_r($recordsuratizin); 
		if(isset($recordsuratizin) && is_array($recordsuratizin) && count($recordsuratizin)):
			foreach ($recordsuratizin as $record) :
				// looping date jika datenya dari sampai diisi
				if($record->tanggal != "" and $record->tanggal_selesai != "" and $record->tanggal != "0000-00-00" and $record->tanggal_selesai != "0000-00-00" and ($record->tanggal !=$record->tanggal_selesai))
				{
					//echo $record->tanggal." > < ".$record->tanggal_selesai."<br>";
					$tanggaldarisampai =  $this->returnBetweenDates($record->tanggal, $record->tanggal_selesai);
					$arrlength = count($tanggaldarisampai);
					//print_r($tanggaldarisampai);
					for($x = 0; $x < $arrlength; $x++) {
						if($record->izin=="1"){ // izin tidak masuk
							$hari = date('l', strtotime($tanggaldarisampai[$x]));
							if($hari != "Saturday" and $hari != "Sunday")  // jika bukan sabtu minggu
							{
								$dataabsen['M_'.$tanggaldarisampai[$x]."_".$record->nip] = "IZN";
								$dataabsen['P_'.$tanggaldarisampai[$x]."_".$record->nip] = "IZN";
					
								$dataizin['izin_'.$tanggaldarisampai[$x]."_".$record->nip] = "IZN";
								$dataizin['izinp_'.$tanggaldarisampai[$x]."_".$record->nip] = "IZN";
							
								$datangterlambat1['PT_'.$tanggaldarisampai[$x]."_".$record->nip] = 1.5; // potongan datang
								$pulangcepat['PP_'.$tanggaldarisampai[$x]."_".$record->nip] = 1.5;// potongan pulang 
								//echo "saturday ". $record->tanggal."_".$record->nip;
							}
						} 
						else if($record->izin=="4"){ // izin sakit
							$hari = date('l', strtotime($tanggaldarisampai[$x]));
							if($hari != "Saturday" and $hari != "Sunday")  // jika bukan sabtu minggu
							{
								$dataabsen['M_'.$tanggaldarisampai[$x]."_".$record->nip] = "SKT";
								$dataabsen['P_'.$tanggaldarisampai[$x]."_".$record->nip] = "SKT";
					
								$dataizin['izin_'.$tanggaldarisampai[$x]."_".$record->nip] = "SKT";
								$dataizin['izinp_'.$tanggaldarisampai[$x]."_".$record->nip] = "SKT";
								$datangterlambat1['PT_'.$tanggaldarisampai[$x]."_".$record->nip] = 0; // potongan datang
								$pulangcepat['PP_'.$tanggaldarisampai[$x]."_".$record->nip] = 0;// potongan pulang 
							//	echo "izin sakit ". $record->tanggal."_".$record->nip;
							}
							
					
						}else if($record->izin=="2"){ // izin pulang sebelum waktunya
							$hari = date('l', strtotime($tanggaldarisampai[$x]));
							 
							$dataabsen['P_'.$tanggaldarisampai[$x]."_".$record->nip] = $record->kode;
							//echo "izin pulang sebelum waktunya ". $record->tanggal."_".$record->nip;
					
						} else if($record->izin=="3"){ // izin datang terlambat
							$hari = date('l', strtotime($tanggaldarisampai[$x]));
							$dataabsen['M_'.$tanggaldarisampai[$x]."_".$record->nip] = $record->kode;
							//echo "izin datang terlambat ". $record->tanggal."_".$record->nip;
					
						} else{
							$hari = date('l', strtotime($tanggaldarisampai[$x]));
							if($hari != "Saturday" and $hari != "Sunday")  // jika bukan sabtu minggu
							{
								 $dataabsen['M_'.$tanggaldarisampai[$x]."_".$record->nip] = $record->kode;
								 $dataabsen['P_'.$tanggaldarisampai[$x]."_".$record->nip] = $record->kode;
								 //echo "saturday ". $record->tanggal."_".$record->nip;
							}
							
							
						}
						//echo $tanggaldarisampai[$x];
						//echo "<br>";
					}
					//print_r($tanggaldarisampai);
				}else // jika tanggal keluar tidak ada isinya
				{
					if($record->izin=="2"){ // izin pulang sebelum waktunya
						$dataabsen['P_'.$record->tanggal."_".$record->nip] = $record->kode;
						//echo 'P_'.$record->tanggal."_".$record->nip."<br>";	
						//echo $dataabsen['P_2016-02-09_198203262009111001']." masuk"; 
					} else if($record->izin=="3"){ // izin datang terlambat
							//$hari = date('l', strtotime($tanggaldarisampai[$x]));
							$dataabsen['M_'.$record->tanggal."_".$record->nip] = $record->kode;
							//echo "izin datang terlambat ". $record->tanggal."_".$record->nip;
					
						} else{
					   //echo "izin pulang sebelum waktunya ". $record->tanggal."_".$record->nip."<br>";	 
					   $dataabsen['M_'.$record->tanggal."_".$record->nip] = $record->kode;
					   $dataabsen['P_'.$record->tanggal."_".$record->nip] = $record->kode;
					}
				}
				//die();
				if($record->izin=="2"){ // izin pulang sebelum waktunya
					$dataizin['izinp_'.$record->tanggal."_".$record->nip] = "PC";
					$pulangcepat['PC_'.$record->tanggal."_".$record->nip] = 0;
				} 
				if($record->izin=="3"){ // izin dateng telat
					$dataizin['izin_'.$record->tanggal."_".$record->nip] = "TH";
				} 
				if($record->izin=="1"){ // izin tidak masuk
					$dataabsen['M_'.$record->tanggal."_".$record->nip] = "IZN";
					$dataabsen['P_'.$record->tanggal."_".$record->nip] = "IZN";
					
					$dataizin['izin_'.$record->tanggal."_".$record->nip] = "IZN";
					$dataizin['izinp_'.$record->tanggal."_".$record->nip] = "IZN";
					
					$datangterlambat1['PT_'.$record->tanggal."_".$record->nip] = 1.5; // potongan datang
					$pulangcepat['PP_'.$record->tanggal."_".$record->nip] = 1.5;// potongan pulang 
					//echo "izin tidakmasuk ". $record->tanggal."_".$record->nip;
				} 
				if($record->izin=="4"){ // izin sakit
					$dataabsen['M_'.$record->tanggal."_".$record->nip] = "SKT";
					$dataabsen['P_'.$record->tanggal."_".$record->nip] = "SKT";
					
					$dataizin['izin_'.$record->tanggal."_".$record->nip] = "SKT";
					$dataizin['izinp_'.$record->tanggal."_".$record->nip] = "SKT";
					$datangterlambat1['PT_'.$record->tanggal."_".$record->nip] = 0; // potongan datang
					$pulangcepat['PP_'.$record->tanggal."_".$record->nip] = 0;// potongan pulang 
					//echo "izin sakit ". $record->tanggal."_".$record->nip;
					
				} 
			endforeach;
		endif;
		// end data izin
		// data sppd
		$this->load->model('sppd_jabodetabek/sppd_jabodetabek_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12"){
			$this->sppd_jabodetabek_model->where('pegawai',$this->current_user->id);
		}
		$recordsppd_jabodetabek  	= $this->sppd_jabodetabek_model->find_rekap($bulan,$tahun,$nip,$nama);
		
		if(isset($recordsppd_jabodetabek) && is_array($recordsppd_jabodetabek) && count($recordsppd_jabodetabek)):
			foreach ($recordsppd_jabodetabek as $record) :
					//$datasppd['TL_'.$record->tanggal_berangkat."_".$record->nip] = "TL";
					$dataabsen['M_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$dataabsen['P_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$arddk['M_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$arddk['P_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					//echo "Jabodetabek  ". $record->tanggal_berangkat."_".$record->nip;
					//echo 'P_'.$record->tanggal_berangkat."_".$record->nip." data<br>";
			endforeach;
		endif;
		
		
		
		$this->load->model('sppd_jabodetabek/sppd_pengikut_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
		{
			$this->sppd_pengikut_model->where('id_user',$this->current_user->id);
		}
		$recordsppd_pengikut  	= $this->sppd_pengikut_model->find_rekap($bulan,$tahun,$nip,$nama);
		if(isset($recordsppd_pengikut) && is_array($recordsppd_pengikut) && count($recordsppd_pengikut)):
			foreach ($recordsppd_pengikut as $record) :
					//$datasppd['TL_'.$record->tanggal_berangkat."_".$record->nip] = "TL";
					$dataabsen['M_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$dataabsen['P_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$arddk['M_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$arddk['P_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					//echo "Pengikut ". $record->tanggal_berangkat."_".$record->nip;
			endforeach;
		endif;
		
		//print_r($recordsppd_pengikut);
		//get data lupatimer
	 
		$this->load->model('lupa_timer/lupa_timer_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->lupa_timer_model->where('user',$this->current_user->id);
		$recordlupatimer  	= $this->lupa_timer_model->find_rekap($bulan,$tahun,$nip,$nama);
		 
		if(isset($recordlupatimer) && is_array($recordlupatimer) && count($recordlupatimer)):
			foreach ($recordlupatimer as $record) :
			
				if($record->absen=="Pulang"){
					$dataizin['izinPt_'.$record->tanggal_absen."_".$record->nip] = substr($record->jam_sebenarnya,0, 5); 
				}else{
					//echo $record->jam_sebenarnya;
					$dataizin['izinMt_'.$record->tanggal_absen."_".$record->nip] = substr($record->jam_sebenarnya,0, 5);
				}
			endforeach;
		endif;
		// end data izin
		$this->load->model('user/user_model', null, true);
		$output 		= "";
		//if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
		//	$this->absen_model->where('nik',$this->current_user->nip);
		//$recordabsen  	= $this->absen_model->rekap($nip,$nama,$bulan,$tahun);
		
		
		if(isset($recordabsen) && is_array($recordabsen) && count($recordabsen)):
			foreach ($recordabsen as $record) :
				//echo 'Pa_'.$record->tanggal."_".$record->nik."_".$record->model." data<br>";
				//if(isset($dataabsen['P_'.$record->tanggal."_".$record->nik]))
				//{
					//echo $record->tanggal.$record->model." jam : ".$record->jam." ".$dataabsen['M_'.$record->tanggal."_".$record->nik]."<br>";
				//}
				if($record->model=="Scan Masuk" and (!isset($dataabsen['M_'.$record->tanggal."_".$record->nik]) or isset($arddk['M_'.$record->tanggal."_".$record->nik]))){
					//echo 'M_'.$record->tanggal."<br>";
					if(isset($dataizin['izin_'.$record->tanggal."_".$record->nik]))
					{
						$dataabsen['M_'.$record->tanggal."_".$record->nik] = $dataizin['izin_'.$record->tanggal."_".$record->nik];
					}else{
						//echo 'M_'.$record->tanggal."<br>";
						$dataabsen['M_'.$record->tanggal."_".$record->nik] = substr($record->jam,0, 5);
						//$datetime1 = strtotime($record->tanggal ." 08:30:00");
						$datetime1 = strtotime($record->tanggal ." ".$jamtoleransi);
						$datetime2 = strtotime($record->tanggal." ".$record->jam);
						if($datetime2>$datetime1)
							$interval  = abs($datetime2 - $datetime1);
						else
							$interval = 0;
							
						$datetimemasuk = strtotime($record->tanggal ." ".$jammasuk);
						if(($datetime1 > $datetimemasuk) and ($datetime2 > $datetimemasuk))
						{
							//die($datetime1." > ".$datetimemasuk);
							$glading  = abs($datetime2 - $datetimemasuk);
							$minuteglading = round($glading / 60);
							if($minuteglading > 60)
								$minuteglading = 60;
							$dataabsen['G_'.$record->tanggal."_".$record->nik] = $minuteglading; 
						}
						$minutes   = round($interval / 60);
						//echo $record->tanggal." ".$record->jam." = ".$minutes."<br>";
						if((int)$minutes > 0)
						{
							$potongan = 0;
							$datangterlambat1['DT_'.$record->tanggal."_".$record->nik] = $minutes;
							
							if($minutes < 31 and $minutes > 9)
								$potongan = 0.5;
							if($minutes>=31 and $minutes <=60)
								$potongan = 1;
							if($minutes>=61 and $minutes <=90)
								$potongan = 1.5;
							if($minutes>=91)
								$potongan = 2;
							
							//echo $record->tanggal."_".$record->nik."<br>";
							$datangterlambat1['PT_'.$record->tanggal."_".$record->nik] = $potongan;
						}
					}
					
				}else{
					if(isset($dataizin['izin_'.$record->tanggal."_".$record->nik])){
						$dataabsen['M_'.$record->tanggal."_".$record->nik] = $dataizin['izin_'.$record->tanggal."_".$record->nik];		 
						
					}
				}
				//echo 'Pa_'.$record->tanggal."_".$record->nik."_".$record->model." data<br>";
				if($record->model=="Scan Keluar" and (!isset($dataabsen['P_'.$record->tanggal."_".$record->nik]) or isset($arddk['P_'.$record->tanggal."_".$record->nik])))
				{
					
					if(isset($dataizin['izinp_'.$record->tanggal."_".$record->nik])){
						$dataabsen['P_'.$record->tanggal."_".$record->nik] = $dataizin['izinp_'.$record->tanggal."_".$record->nik];
					}else
					{
						$dataabsen['P_'.$record->tanggal."_".$record->nik] = substr($record->jam,0, 5);
						 
						$minutes   = 0;
						
						
						
						// hitung pulang cepat
						$menitglading = isset($dataabsen['G_'.$record->tanggal."_".$record->nik]) ? $dataabsen['G_'.$record->tanggal."_".$record->nik] : 0;
						$detilglading = $menitglading * 60;
						$hari = date('l', strtotime($record->tanggal));
						if($hari == "Friday"){
							$pulangseharusnya = strtotime($record->tanggal ." ".$jamplg) + $detilglading + 1800; //jam pulang normal ditambah glading
							//echo $detilglading;
						}else
							$pulangseharusnya = strtotime($record->tanggal ." ".$jamplg) + $detilglading; //jam pulang normal ditambah glading
						$pulangreal = strtotime($record->tanggal." ".$record->jam);
						
						if($pulangreal < $pulangseharusnya)
							$interval  = abs($pulangseharusnya - $pulangreal);
						else
							$interval = 0;
							 
						$minutes   = round($interval / 60);
						//echo $minutes."<br>";
						//echo $record->nik." ".$record->model.$record->tanggal." ".$record->jam." = ".$minutes."<br>";
						if((int)$minutes > 0)
						{
							$potongan = 0;
							//$pulangcepat['PPC_'.$record->tanggal."_".$record->nik] = $minutes;
							
							if($minutes < 31 and $minutes > 9)
								$potongan = 0.5;
							if($minutes>=31 and $minutes <=60)
								$potongan = 1;
							if($minutes>=61 and $minutes <=90)
								$potongan = 1.5;
							if($minutes>=91)
								$potongan = 2;
							
							//echo  $potongan."<br>";
							$pulangcepat['PP_'.$record->tanggal."_".$record->nik] = $potongan;
							$pulangcepat['PM_'.$record->tanggal."_".$record->nik] = $minutes;						
						}
							//tambahan 23 juni 2016
							if($pulangseharusnya > $pulangreal)
							{
								$gladingpulang  = abs($pulangseharusnya - $pulangreal);
								$gladingpulang = round($gladingpulang / 60);
								$dataabsen['GP_'.$record->tanggal."_".$record->nik] = $gladingpulang; 
							}
							if($pulangseharusnya < $pulangreal)
							{
								$kelebihanpulang  = abs($pulangreal - $pulangseharusnya);
								//echo $kelebihanpulang;
								$menitlebih = round($kelebihanpulang / 60);
								$dataabsen['ML_'.$record->tanggal."_".$record->nik] = $menitlebih; 
							}
							//end tambahan
					}
				}else{
					if(isset($dataizin['izinp_'.$record->tanggal."_".$record->nik])){
						$dataabsen['P_'.$record->tanggal."_".$record->nik] = $dataizin['izinp_'.$record->tanggal."_".$record->nik];
					} 
				}
					
					
			endforeach;
		endif;
		
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->user_model->where('nip',$this->current_user->nip);
		if($nip!=""){
			$this->user_model->where('nip like "%'.$nip.'%"');
		}
		if($nama!=""){
			$this->user_model->where('display_name like "%'.$nama.'%"');
		}
		if($role != ""){
			//die("masuk".$role);
			$this->user_model->where('users.role_id',$role);
		}
		$this->user_model->where("nip != ''");
		$recorduser  =$this->user_model->find_withnip();
		$output .= $this->load->view('kepegawaian/rekap_content',array("recorduser"=>$recorduser,"dataabsen"=>$dataabsen,"nip"=>$nip,"nama"=>$nama,"bulan"=>$bulan,"tahun"=>$tahun,"datangterlambat1"=>$datangterlambat1,"pulangcepat"=>$pulangcepat,"dataharilibur"=>$dataharilibur,"dataizin"=>$dataizin),true);	
		 
		echo $output;
		die();
	}
	public function rekap_contentum()
	{
		
		$nip 	= $this->input->post('nip');
		$nama 	= $this->input->post('nama');
		$bulan 	= $this->input->post('bulan') != "" ? $this->input->post('bulan') : date("m");
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : date("Y");
		$role 	= $this->input->post('role');
		// jumlah per izin
		$dataizin 		= array(); 
		$this->load->model('surat_izin/surat_izin_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('user',$this->current_user->id);
			
		$recordsuratizin  	= $this->surat_izin_model->sum_rekap($bulan,$tahun,$nip,$nama);
		//print_r($recordsuratizin);
		if(isset($recordsuratizin) && is_array($recordsuratizin) && count($recordsuratizin)):
			foreach ($recordsuratizin as $record) :
				//echo $record->nip." : ".$record->jumlah."<br>";
				$dataizin['izin_'.$record->izin."_".$record->nip] = $record->jumlah;
			endforeach;
		endif;
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->user_model->where('nip',$this->current_user->nip);
		if($nip!=""){
			$this->user_model->where('nip like "%'.$nip.'%"');
		}
		if($nama!=""){
			$this->user_model->where('display_name like "%'.$nama.'%"');
		}
		if($role != ""){
			//die("masuk".$role);
			$this->user_model->where('users.role_id',$role);
		}
		$this->user_model->where("nip != ''");
		$recorduser  =$this->user_model->find_withnip();
		$output = $this->load->view('kepegawaian/rekap_contentum',array("recorduser"=>$recorduser,"nip"=>$nip,"nama"=>$nama,"bulan"=>$bulan,"tahun"=>$tahun,"dataizin"=>$dataizin),true);	
		 
		echo $output;
		die();
	}
	public function create_rekap()
	{
		$jammasuk = "07:30:00";
		$jamtoleransi = $this->settings_lib->item('site.maxmasuk') != "" ? $this->settings_lib->item('site.maxmasuk') : "08:30:00";
		$jamplg = $this->settings_lib->item('site.maxpulang') != "" ? $this->settings_lib->item('site.maxpulang') : "16:00:00";
		
		$this->auth->restrict('Absen.Kepegawaian.Rekap');
		$this->load->library('Convert');
		$Class_Convert = new Convert;
		$nip 	= $this->input->get('nip');
		$nama 	= $this->input->get('nama');
		$bulan 	= $this->input->get('bulan');
		$tahun 	= $this->input->get('tahun');
		
		$datangterlambat1 		= array(); 
		//include PHPExcel library
		$this->load->library('Excel');
		//require_once "Classes/PHPExcel/IOFactory.php";
		$objTpl = PHPExcel_IOFactory::load($this->settings_lib->item('site.pathuploaded').'excell-absen/templaterekaptukin.xls');
		 
		//load Excel template file
		//$objTpl = PHPExcel_IOFactory::load("template.xls");
		$objTpl->setActiveSheetIndex(0);  //set first sheet as active
		
		$recordabsen  = $this->absen_model->rekap($nip,$nama,$bulan,$tahun);
		$namabulan = $Class_Convert->getmonth($bulan);
		$objTpl->getActiveSheet()->setCellValue('A5', "BULAN  : ".$namabulan);
		$objTpl->getActiveSheet()->setCellValue('A6', "HARI KERJA :  Hari  : ");
		//get data izin
		$dataharilibur 		= array(); 
		$dataizin 		= array(); 
		$dataabsen 		= array(); 
		$datasppd 		= array(); 
		$datangterlambat1 		= array(); 
		$pulangcepat	 		= array(); 
		$arddk	 		= array(); 
		
		//hari libur
		$this->load->model('hari_libur/hari_libur_model', null, true);
		$recordhariliburs  	= $this->hari_libur_model->find_rekap($bulan,$tahun);
		if(isset($recordhariliburs) && is_array($recordhariliburs) && count($recordhariliburs)):
			foreach ($recordhariliburs as $record) :
					$dataharilibur[$record->tanggal] = $record->keterangan; 
					//echo $record->keterangan." data<br>";
			endforeach;
		endif;
		// end hari libur
		
		$this->load->model('surat_izin/surat_izin_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('user',$this->current_user->id);
		$recordsuratizin  	= $this->surat_izin_model->find_rekap($bulan,$tahun,$nip,$nama);
		//print_r($recordsuratizin); 
		if(isset($recordsuratizin) && is_array($recordsuratizin) && count($recordsuratizin)):
			foreach ($recordsuratizin as $record) :
				
				// looping date jika datenya dari sampai diisi
				if($record->tanggal != "" and $record->tanggal_selesai != "" and $record->tanggal != "0000-00-00" and $record->tanggal_selesai != "0000-00-00" and ($record->tanggal !=$record->tanggal_selesai))
				{
					//echo $record->tanggal." > < ".$record->tanggal_selesai."<br>";
					$tanggaldarisampai =  $this->returnBetweenDates($record->tanggal, $record->tanggal_selesai);
					$arrlength = count($tanggaldarisampai);
					//print_r($tanggaldarisampai);
					for($x = 0; $x < $arrlength; $x++) {
						if($record->izin=="1"){ // izin tidak masuk
							$hari = date('l', strtotime($tanggaldarisampai[$x]));
							if($hari != "Saturday" and $hari != "Sunday")  // jika bukan sabtu minggu
							{
								$dataabsen['M_'.$tanggaldarisampai[$x]."_".$record->nip] = "IZN";
								$dataabsen['P_'.$tanggaldarisampai[$x]."_".$record->nip] = "IZN";
					
								$dataizin['izin_'.$tanggaldarisampai[$x]."_".$record->nip] = "IZN";
								$dataizin['izinp_'.$tanggaldarisampai[$x]."_".$record->nip] = "IZN";
							
								$datangterlambat1['PT_'.$tanggaldarisampai[$x]."_".$record->nip] = 1.5; // potongan datang
								$pulangcepat['PP_'.$tanggaldarisampai[$x]."_".$record->nip] = 1.5;// potongan pulang 
							}
						} 
						else if($record->izin=="4"){ // izin sakit
							$hari = date('l', strtotime($tanggaldarisampai[$x]));
							if($hari != "Saturday" and $hari != "Sunday")  // jika bukan sabtu minggu
							{
								$dataabsen['M_'.$tanggaldarisampai[$x]."_".$record->nip] = "SKT";
								$dataabsen['P_'.$tanggaldarisampai[$x]."_".$record->nip] = "SKT";
					
								$dataizin['izin_'.$tanggaldarisampai[$x]."_".$record->nip] = "SKT";
								$dataizin['izinp_'.$tanggaldarisampai[$x]."_".$record->nip] = "SKT";
								$datangterlambat1['PT_'.$tanggaldarisampai[$x]."_".$record->nip] = 0; // potongan datang
								$pulangcepat['PP_'.$tanggaldarisampai[$x]."_".$record->nip] = 0;// potongan pulang 
								///echo "izin sakit ". $record->tanggal."_".$record->nip;
							}
							
					
						} else{
							$hari = date('l', strtotime($tanggaldarisampai[$x]));
							if($hari != "Saturday" and $hari != "Sunday")  // jika bukan sabtu minggu
							{
								//echo $tanggaldarisampai[$x]."<br>";
								$dataabsen['M_'.$tanggaldarisampai[$x]."_".$record->nip] = $record->kode;
								$dataabsen['P_'.$tanggaldarisampai[$x]."_".$record->nip] = $record->kode;
							}
							
							
						}
						//echo $tanggaldarisampai[$x];
						//echo "<br>";
					}
					//print_r($tanggaldarisampai);
				}else // jika tanggal keluar tidak ada isinya
				{
					if($record->izin=="2"){ // izin pulang sebelum waktunya
						$dataabsen['P_'.$record->tanggal."_".$record->nip] = $record->kode;
					}else if($record->izin=="3"){ // izin datang terlambat
							$dataabsen['M_'.$record->tanggal."_".$record->nip] = $record->kode;
					}else{
					   //echo "izin pulang sebelum waktunya ". $record->tanggal."_".$record->nip."<br>";	 
					   $dataabsen['M_'.$record->tanggal."_".$record->nip] = $record->kode;
					   $dataabsen['P_'.$record->tanggal."_".$record->nip] = $record->kode;
					}
				}
				//die();
				if($record->izin=="2"){ // izin pulang sebelum waktunya
					$dataizin['izinp_'.$record->tanggal."_".$record->nip] = "PC";
					$pulangcepat['PC_'.$record->tanggal."_".$record->nip] = 0;
				} 
				if($record->izin=="3"){ // izin dateng telat
					$dataizin['izin_'.$record->tanggal."_".$record->nip] = "TH";
				} 
				if($record->izin=="1"){ // izin tidak masuk
					$dataabsen['M_'.$record->tanggal."_".$record->nip] = "IZN";
					$dataabsen['P_'.$record->tanggal."_".$record->nip] = "IZN";
					
					$dataizin['izin_'.$record->tanggal."_".$record->nip] = "IZN";
					$dataizin['izinp_'.$record->tanggal."_".$record->nip] = "IZN";
					
					$datangterlambat1['PT_'.$record->tanggal."_".$record->nip] = 1.5; // potongan datang
					$pulangcepat['PP_'.$record->tanggal."_".$record->nip] = 1.5;// potongan pulang 
				} 
				if($record->izin=="4"){ // izin sakit
					$dataabsen['M_'.$record->tanggal."_".$record->nip] = "SKT";
					$dataabsen['P_'.$record->tanggal."_".$record->nip] = "SKT";
					
					$dataizin['izin_'.$record->tanggal."_".$record->nip] = "SKT";
					$dataizin['izinp_'.$record->tanggal."_".$record->nip] = "SKT";
					$datangterlambat1['PT_'.$record->tanggal."_".$record->nip] = 0; // potongan datang
					$pulangcepat['PP_'.$record->tanggal."_".$record->nip] = 0;// potongan pulang 
					///echo "izin sakit ". $record->tanggal."_".$record->nip;
					
				} 
			endforeach;
		endif;
		// end data izin
		// data sppd
		$this->load->model('sppd_jabodetabek/sppd_jabodetabek_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
		{
			$this->sppd_jabodetabek_model->where('pegawai',$this->current_user->id);
		}
		$recordsppd_jabodetabek  	= $this->sppd_jabodetabek_model->find_rekap($bulan,$tahun,$nip,$nama);
		
		if(isset($recordsppd_jabodetabek) && is_array($recordsppd_jabodetabek) && count($recordsppd_jabodetabek)):
			foreach ($recordsppd_jabodetabek as $record) :
					//$datasppd['TL_'.$record->tanggal_berangkat."_".$record->nip] = "TL";
					$dataabsen['M_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$dataabsen['P_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$arddk['M_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$arddk['P_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					
					//echo 'P_'.$record->tanggal_berangkat."_".$record->nip." data<br>";
			endforeach;
		endif;
		
		
		
		$this->load->model('sppd_jabodetabek/sppd_pengikut_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
		{
			$this->sppd_pengikut_model->where('id_user',$this->current_user->id);
		}
		$recordsppd_pengikut  	= $this->sppd_pengikut_model->find_rekap($bulan,$tahun,$nip,$nama);
		if(isset($recordsppd_pengikut) && is_array($recordsppd_pengikut) && count($recordsppd_pengikut)):
			foreach ($recordsppd_pengikut as $record) :
					//$datasppd['TL_'.$record->tanggal_berangkat."_".$record->nip] = "TL";
					$dataabsen['M_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$dataabsen['P_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$arddk['M_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
					$arddk['P_'.$record->tanggal_berangkat."_".$record->nip] = "DDK"; 
			endforeach;
		endif;
		
		//print_r($recordsppd_pengikut);
		//get data lupatimer
	 
		$this->load->model('lupa_timer/lupa_timer_model', null, true);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->lupa_timer_model->where('user',$this->current_user->id);
		$recordlupatimer  	= $this->lupa_timer_model->find_rekap($bulan,$tahun,$nip,$nama);
		 
		if(isset($recordlupatimer) && is_array($recordlupatimer) && count($recordlupatimer)):
			foreach ($recordlupatimer as $record) :
			
				if($record->absen=="Pulang"){
					$dataizin['izinPt_'.$record->tanggal_absen."_".$record->nip] = substr($record->jam_sebenarnya,0, 5); 
				}else{
					//echo $record->jam_sebenarnya;
					$dataizin['izinMt_'.$record->tanggal_absen."_".$record->nip] = substr($record->jam_sebenarnya,0, 5);
				}
			endforeach;
		endif;
		// end data izin
		
		$this->load->model('user/user_model', null, true);
		$output 		= "";
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20" and $this->current_user->role_id != "12")
			$this->absen_model->where('nik',$this->current_user->nip);
		$recordabsen  	= $this->absen_model->rekap($nip,$nama,$bulan,$tahun);
		
		
		if(isset($recordabsen) && is_array($recordabsen) && count($recordabsen)):
			foreach ($recordabsen as $record) :
				//echo 'Pa_'.$record->tanggal."_".$record->nik."_".$record->model." data<br>";
				if($record->model=="Scan Masuk" and (!isset($dataabsen['M_'.$record->tanggal."_".$record->nik]) or isset($arddk['M_'.$record->tanggal."_".$record->nik]))){
					if(isset($dataizin['izin_'.$record->tanggal."_".$record->nik])){
					 	
					 	
						$dataabsen['M_'.$record->tanggal."_".$record->nik] = $dataizin['izin_'.$record->tanggal."_".$record->nik];
					}else{
						//echo 'M_'.$record->tanggal."<br>";
						$dataabsen['M_'.$record->tanggal."_".$record->nik] = substr($record->jam,0, 5);
						//$datetime1 = strtotime($record->tanggal ." 08:30:00");
						$datetime1 = strtotime($record->tanggal ." ".$jamtoleransi);
						$datetime2 = strtotime($record->tanggal." ".$record->jam);
						if($datetime2>$datetime1)
							$interval  = abs($datetime2 - $datetime1);
						else
							$interval = 0;
							
						$datetimemasuk = strtotime($record->tanggal ." ".$jammasuk);
						if(($datetime1 > $datetimemasuk) and ($datetime2 > $datetimemasuk))
						{
							//die($datetime1." > ".$datetimemasuk);
							$glading  = abs($datetime2 - $datetimemasuk);
							$minuteglading = round($glading / 60);
							if($minuteglading > 60)
								$minuteglading = 60;
							$dataabsen['G_'.$record->tanggal."_".$record->nik] = $minuteglading; 
						}
						$minutes   = round($interval / 60);
						//echo $record->tanggal." ".$record->jam." = ".$minutes."<br>";
						if((int)$minutes > 0)
						{
							$potongan = 0;
							$datangterlambat1['DT_'.$record->tanggal."_".$record->nik] = $minutes;
							
							if($minutes < 31 and $minutes > 9)
								$potongan = 0.5;
							if($minutes>=31 and $minutes <=60)
								$potongan = 1;
							if($minutes>=61 and $minutes <=90)
								$potongan = 1.5;
							if($minutes>=91)
								$potongan = 2;
							
							//echo $record->tanggal."_".$record->nik."<br>";
							$datangterlambat1['PT_'.$record->tanggal."_".$record->nik] = $potongan;
						}
					}
					
				}else{
					if(isset($dataizin['izin_'.$record->tanggal."_".$record->nik])){
						$dataabsen['M_'.$record->tanggal."_".$record->nik] = $dataizin['izin_'.$record->tanggal."_".$record->nik];		 
						
					}
				}
				//echo 'Pa_'.$record->tanggal."_".$record->nik."_".$record->model." data<br>";
				if($record->model=="Scan Keluar" and (!isset($dataabsen['P_'.$record->tanggal."_".$record->nik]) or isset($arddk['P_'.$record->tanggal."_".$record->nik])))
				{
					
					if(isset($dataizin['izinp_'.$record->tanggal."_".$record->nik])){
						$dataabsen['P_'.$record->tanggal."_".$record->nik] = $dataizin['izinp_'.$record->tanggal."_".$record->nik];
					}else
					{
						$dataabsen['P_'.$record->tanggal."_".$record->nik] = substr($record->jam,0, 5);
						 
						$minutes   = 0;
						
						
						
						// hitung pulang cepat
						$menitglading = isset($dataabsen['G_'.$record->tanggal."_".$record->nik]) ? $dataabsen['G_'.$record->tanggal."_".$record->nik] : 0;
						$detilglading = $menitglading * 60;
						$hari = date('l', strtotime($record->tanggal));
						if($hari == "Friday"){
							$pulangseharusnya = strtotime($record->tanggal ." ".$jamplg) + $detilglading + 1800; //jam pulang normal ditambah glading ditambah 30 menit kalo jumat
							//echo $detilglading;
						}else
							$pulangseharusnya = strtotime($record->tanggal ." ".$jamplg) + $detilglading; //jam pulang normal ditambah glading
						$pulangreal = strtotime($record->tanggal." ".$record->jam);
						
						if($pulangreal < $pulangseharusnya)
							$interval  = abs($pulangseharusnya - $pulangreal);
						else
							$interval = 0;
							 
						$minutes   = round($interval / 60);
						//echo $minutes."<br>";
						//echo $record->nik." ".$record->model.$record->tanggal." ".$record->jam." = ".$minutes."<br>";
						if((int)$minutes > 0)
						{
							$potongan = 0;
							//$pulangcepat['PPC_'.$record->tanggal."_".$record->nik] = $minutes;
							
							if($minutes < 31 and $minutes > 9)
								$potongan = 0.5;
							if($minutes>=31 and $minutes <=60)
								$potongan = 1;
							if($minutes>=61 and $minutes <=90)
								$potongan = 1.5;
							if($minutes>=91)
								$potongan = 2;
							
							//echo  $potongan."<br>";
							$pulangcepat['PP_'.$record->tanggal."_".$record->nik] = $potongan;
							$pulangcepat['PM_'.$record->tanggal."_".$record->nik] = $minutes;						
						}
							//tambahan 23 juni 2016
							if($pulangseharusnya > $pulangreal)
							{
								$gladingpulang  = abs($pulangseharusnya - $pulangreal);
								$gladingpulang = round($gladingpulang / 60);
								$dataabsen['GP_'.$record->tanggal."_".$record->nik] = $gladingpulang; 
							}
							
							//end tambahan
					}
				}else{
					if(isset($dataizin['izinp_'.$record->tanggal."_".$record->nik])){
						$dataabsen['P_'.$record->tanggal."_".$record->nik] = $dataizin['izinp_'.$record->tanggal."_".$record->nik];
					} 
				}
					
					
			endforeach;
		endif;
		$this->user_model->where("users.role_id != '22'");
		$this->user_model->where("nip != ''");
		$recorduser  =$this->user_model->find_withnip();
		if (isset($recorduser) && is_array($recorduser) && count($recorduser)) :
			$no=1;
			$row = 11;
			$col = 2;
			$total = 0;
			$totalblmbayar =0;
			$jmlpotongan = 0;
			$jmlmenit = 0;
			$jmlhari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); // 31
			$jmlhari = $jmlhari +1;
			foreach ($recorduser as $record) :
				$kolmasuk = 0;
				$kolkeluar = 1;
			
				$objTpl->getActiveSheet()->setCellValueByColumnAndRow(0, $row,$no);
				$objTpl->getActiveSheet()->setCellValueByColumnAndRow(1, $row,$record->display_name);
				$objTpl->getActiveSheet()->setCellValueByColumnAndRow(1, $row+1,"'".$record->nip);
				//$objTpl->getActiveSheet()->setCellValue('B11', $record->display_name."\n".$record->nip);
				
				for($i=1;$i<$jmlhari;$i++){
				   if($i<10)
					   $numtgl = "0".$i;
				   else
					   $numtgl = $i;
					
					  $mydate = $tahun.'-'.$bulan.'-'.$numtgl;
					  $hari = date('l', strtotime($mydate));
				  	$today = date("Y-m-d");

					 $today_time = strtotime($today);
					 $expire_time = strtotime($mydate);
					 
					  if(isset($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
					  		//$objTpl->getActiveSheet()->setCellValueByColumnAndRow(5, 5,"test yanarazor");
					  		 
					  		$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row,substr($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip],0, 5));  
					  		if(isset($datangterlambat1['PT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
								 //echo $datangterlambat1['PT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
								 $objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row+1,$datangterlambat1['PT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]);  
							 }
							 else{
							  	$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row+1,0);  
							 }
					  		
					  		if(isset($datangterlambat1['DT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
								 //echo $datangterlambat1['DT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
								$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row+2,$datangterlambat1['DT_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]);
							 }else{
							  	$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row+2,0);
							 }
					  		  
					   }else{
							if(!isset($dataharilibur[$tahun."-".$bulan."-".$numtgl]) and ($hari != "Saturday" and $hari != "Sunday")) {
								if ($expire_time < $today_time)
								{
								   $objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row,"M");  
								   //echo "M";
							   }
							}
						   
						   if ($expire_time < $today_time and ($hari != "Saturday" and $hari != "Sunday") and !isset($dataharilibur[$tahun."-".$bulan."-".$numtgl]))
						   {
							   $potongan = 2;
							   if(!isset($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and !isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]))
								   $potongan = 2.5;
							   
							   //echo $potongan;	
							   $objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row+1,$potongan);  
							   $jmlpotongan = $jmlpotongan + $potongan;
						   }
							if ($expire_time < $today_time and ($hari != "Saturday" and $hari != "Sunday") and !isset($dataharilibur[$tahun."-".$bulan."-".$numtgl]))
							{
								$menitpotongan = 225;
								$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row+2,$menitpotongan);  
								//echo $menitpotongan;	
							}  
					   		//$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row+1,0);  
					  		//$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolmasuk+2, $row+2,0);    
					   }
					 
					  if(isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
						  $objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolkeluar+2, $row,substr($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip],0,5));    
						  if(isset($pulangcepat['PP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
						  	$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolkeluar+2, $row+1,$pulangcepat['PP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]);
							//echo $datangterlambat1['PP_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
						  }
						  else{
								$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolkeluar+2, $row+1,0); // potongan pulang
						  }
						  if(isset($pulangcepat['PM_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip])){
						  		$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolkeluar+2, $row+2,$pulangcepat['PM_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]);
							   //echo $pulangcepat['PM_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
							   //$jmlmenit = $jmlmenit + (double)$pulangcepat['PM_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip];
						   }else{
								$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolkeluar+2, $row+2,0); // kekurangn menit pulang
						   }
						   
					   }else{
					   		if(!isset($dataharilibur[$tahun."-".$bulan."-".$numtgl]) and ($hari != "Saturday" and $hari != "Sunday")) {
								if ($expire_time < $today_time)
									$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolkeluar+2, $row,"M");  
									//echo "M";
							}
					   		if(!isset($dataharilibur[$tahun."-".$bulan."-".$numtgl])){
								 if ($expire_time < $today_time and ($hari != "Saturday" and $hari != "Sunday"))
								 {
									   $potongan = 2;
									   if(!isset($dataabsen['M_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]) and !isset($dataabsen['P_'.$tahun."-".$bulan."-".$numtgl."_".$record->nip]))
										   $potongan = 2.5;
							 
									  // echo $potongan;
										$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolkeluar+2, $row+1,$potongan);
									   $jmlpotongan = $jmlpotongan + $potongan;
								   }
							 } 
							 
							if ($expire_time < $today_time and ($hari != "Saturday" and $hari != "Sunday") and !isset($dataharilibur[$tahun."-".$bulan."-".$numtgl]))
							{
								$menitpotongan = 225;
								//echo $menitpotongan;	
								$objTpl->getActiveSheet()->setCellValueByColumnAndRow($kolkeluar+2, $row+2,$menitpotongan);
							}
						 
						  
					   }
					$kolmasuk = $kolmasuk+2;
					$kolkeluar = $kolkeluar+2;
				}
			$no++;
			$row = $row+3;
			endforeach;
		endif;
		/*
		$objTpl->getActiveSheet()->setCellValue('C2', date('Y-m-d'));  //set C1 to current date
		$objTpl->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); //C1 is right-justified

		$objTpl->getActiveSheet()->setCellValue('C3', "test yanarazor");
		$objTpl->getActiveSheet()->setCellValue('C5', "test yanarazor");

		$objTpl->getActiveSheet()->getStyle('C4')->getAlignment()->setWrapText(true);  //set wrapped for some long text message

		//$objTpl->getActiveSheet()->getColumnDimension('C')->setWidth(40);  //set column C width
		//$objTpl->getActiveSheet()->getRowDimension('4')->setRowHeight(120);  //set row 4 height
		//$objTpl->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); //A4 until C4 is vertically top-aligned
*/
		//prepare download
		$filename = "RekapAbsen_".mt_rand(1,100000).'.xls'; //just some random filename
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
		$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!

		exit; //done.. exiting!
	}
	public function upload()
	{
		$this->auth->restrict('Absen.Kepegawaian.Upload');
		Assets::add_css('uploadify.css');
		Assets::add_js('jquery.uploadify.js');
		Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		if (isset($_POST['save']))
		{
			
			 $this->load->helper('handle_upload');
			 $uploadData = array();
			 $upload = true;
				
			 if (isset($_FILES['Filedata']) && is_array($_FILES['Filedata']) && $_FILES['Filedata']['error'] != 4)
			 {
		
				 $uploadData = handle_upload('Filedata',$this->settings_lib->item('site.pathuploaded'));
				 //die($uploadData);
				 //print_r($uploadData);
				 if (isset($uploadData['error']) && !empty($uploadData['error']))
				 {
					 $upload = false;
				 }else{
					 //$kodeimport = $this->save_log_import($uploadData['data']['file_name'],$user_id,$provinsi);
					 //die($kodeimport." $kodeimport");
					 $this->runexport($this->settings_lib->item('site.pathuploaded').$uploadData['data']['file_name']);
				 }
			 } 	
		}
		
		Template::set('toolbar_title', 'Upload Absen');
		Template::render();
	}
	public function runexport($namafile)
	{
		
		$sudahada = 0;
		$success = 0;
		
		// handle upload
		$this->load->helper('handle_upload');
		$uploadData = array();
		$upload = true;
		  
		// end handle upload
		$this->load->library('Convert');
		$Class_Convert = new Convert;
		//$file = $this->settings_lib->item('site.pathuploaded').'excell-absen/absenmaret.xlsx';
		if($namafile)
			$file = $this->settings_lib->item('site.pathuploaded').'excell-absen/'.$namafile;
		else
			$file ="";
		$this->load->library('Excel');
		$objPHPExcel = PHPExcel_IOFactory::load($namafile);

		//  Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		//die($highestRow);
		//  Loop through each row of the worksheet in turn
		for ($row = 2; $row <= $highestRow; $row++){ 
			//echo $row."<br>";
			//  Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
											NULL,
											TRUE,
											FALSE);
			//  Insert row data array into your database of choice here
			 $tanggal = $Class_Convert->fmtDate2($rowData[0][3],"yyyy-mm-dd");
			 //echo $tanggal."<br>";
			  $nip =  preg_replace("/\s+/", "",$rowData[0][1]);
			  if(!$this->absen_model->cekuniq($nip,$tanggal,$rowData[0][8]))
			  {
				$success++;
				$this->generate_save($nip,$rowData[0][2],$tanggal,$rowData[0][4],$rowData[0][5],$rowData[0][7],$rowData[0][8]);
			  }else{
				$sudahada++;
			  }
		  }
		  
		$msgsudahada = "";
		$msgsuccess = "";
		if($sudahada>0)
			$msgsudahada .= "Duplikasi data : ".$sudahada." data";
		if($success>0)
			$msgsuccess .= "Berhasil : ".$success." data";
		echo $msgsuccess.$msgsudahada."\nUpload Selesai";
	   //send the data in an array format
	 	exit;
		 
	}

	 
	 
	public function import_data()
	{
		$this->auth->restrict('Absen.Kepegawaian.Upload');
		// handle upload
		$this->load->helper('handle_upload');
		$uploadData = array();
		$upload = true;
		  if (isset($_FILES['Filedata']) && is_array($_FILES['Filedata']) && $_FILES['Filedata']['error'] != 4)
		  {
			  $uploadData = handle_upload('Filedata',$this->settings_lib->item('site.pathuploaded').'excell-absen/');
			  //die($uploadData);
			  //print_r($uploadData);
			  if (isset($uploadData['error']) && !empty($uploadData['error']))
			  {
				  $upload = false;
			  }else{
				  // end handle upload
				  $this->load->library('Convert');
				  $Class_Convert = new Convert;
				  //$file = $this->settings_lib->item('site.pathuploaded').'excell-absen/absenmaret.xlsx';
				  if(isset($uploadData['data']['file_name']))
					  $file = $this->settings_lib->item('site.pathuploaded').'excell-absen/'.$uploadData['data']['file_name'];
				  else
					  $file ="";
				  $this->load->library('Excel');
				  $objPHPExcel = PHPExcel_IOFactory::load($file);
		 
				  //  Get worksheet dimensions
				  $sheet = $objPHPExcel->getSheet(0); 
				  $highestRow = $sheet->getHighestRow(); 
				  $highestColumn = $sheet->getHighestColumn();

				  //  Loop through each row of the worksheet in turn
				  for ($row = 2; $row <= $highestRow; $row++){ 
				  	echo $rowData[0][3]."<br>";
					  //  Read a row of data into an array
					  $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
													  NULL,
													  TRUE,
													  FALSE);
					  //  Insert row data array into your database of choice here
					  $tanggal = $Class_Convert->fmtDate2($rowData[0][3],"yyyy-mm-dd");
			 
					  $nip =  preg_replace("/\s+/", "",$rowData[0][1]);
			
					  $nomor =  $this->generate_save($nip,$rowData[0][2],$tanggal,$rowData[0][4],$rowData[0][5],$rowData[0][7],$rowData[0][8]);
					  //echo $nomor;	
			  }
		  } 	
		
		}

	   //send the data in an array format
	 	exit;
		 
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Absen object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Absen.Kepegawaian.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_absen())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('absen_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'absen');

				Template::set_message(lang('absen_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/absen');
			}
			else
			{
				Template::set_message(lang('absen_create_failure') . $this->absen_model->error, 'error');
			}
		}
		Assets::add_module_js('absen', 'absen.js');

		Template::set('toolbar_title', lang('absen_create') . ' Absen');
		Template::render();
	}
	
	//--------------------------------------------------------------------


	/**
	 * Allows editing of Absen data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('absen_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/absen');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Absen.Kepegawaian.Edit');

			if ($this->save_absen('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('absen_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'absen');

				Template::set_message(lang('absen_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('absen_edit_failure') . $this->absen_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Absen.Kepegawaian.Delete');

			if ($this->absen_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('absen_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'absen');

				Template::set_message(lang('absen_delete_success'), 'success');

				redirect(SITE_AREA .'/kepegawaian/absen');
			}
			else
			{
				Template::set_message(lang('absen_delete_failure') . $this->absen_model->error, 'error');
			}
		}
		Template::set('absen', $this->absen_model->find($id));
		Template::set('toolbar_title', lang('absen_edit') .' Absen');
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
	private function save_absen($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nik']        = $this->input->post('absen_nik');
		$data['nama']        = $this->input->post('absen_nama');
		$data['tanggal']        = $this->input->post('absen_tanggal') ? $this->input->post('absen_tanggal') : '0000-00-00';
		$data['jam']        = $this->input->post('absen_jam');
		$data['sn_mesin']        = $this->input->post('absen_sn_mesin');
		$data['verifikasi']        = $this->input->post('absen_verifikasi');
		$data['model']        = $this->input->post('absen_model');

		if ($type == 'insert')
		{
			$id = $this->absen_model->insert($data);

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
			$return = $this->absen_model->update($id, $data);
		}

		return $return;
	}
	private function generate_save($nik="",$nama="",$tanggal="",$jam="",$snmesin="",$verifikasi="",$model="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nik']        = $nik;
		$data['nama']        = $nama;
		$data['tanggal']        = $tanggal ? $tanggal : '0000-00-00';
		$data['jam']        = $jam;
		$data['sn_mesin']        = $snmesin;
		$data['verifikasi']        = $verifikasi;
		$data['model']        = $model;

		if ($type == 'insert')
		{
			$id = $this->absen_model->insert($data);

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
			$return = $this->absen_model->update($id, $data);
		}

		return $return;
	}
	//--------------------------------------------------------------------


}