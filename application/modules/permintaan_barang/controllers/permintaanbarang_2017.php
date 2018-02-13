<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * permintaanbarang controller
 */
class permintaanbarang extends Admin_Controller
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

		$this->auth->restrict('Permintaan_Barang.Permintaanbarang.View');
		$this->load->model('permintaan_barang_model', null, true);
		$this->load->model('permintaan_barang/permintaan_barang_detil_model', null, true);
		$this->lang->load('permintaan_barang');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		

		Assets::add_module_js('permintaan_barang', 'permintaan_barang.js');
		
		$this->load->model('users/user_model', null, true);
		$this->user_model->where('nip != ""');
		$this->user_model->order_by('display_name',"asc");
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		
		$this->load->model('kegiatan/kegiatan_model', null, true);
		$this->user_model->where('tahun',date("Y"));
		$kegiatans = $this->kegiatan_model->find_all();
		Template::set('kegiatans', $kegiatans);
		
		$this->load->model('status_permintaan/status_permintaan_model', null, true);
		$status_permintaan = $this->status_permintaan_model->find_all();
		Template::set('status_permintaans', $status_permintaan);
		
		$this->load->model('log_permintaan/log_permintaan_model', null, true);
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		Template::set_block('sub_nav', 'permintaanbarang/_sub_nav');
		$this->auth->restrict('Permintaan_Barang.Permintaanbarang.Delete');
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');

		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$permintaan_barang = $this->permintaan_barang_model->find($pid);
					if($permintaan_barang->status_atasan == "1")
					{
						Template::set_message("Permintaan tidak bisa di hapus karena sudah melalui proses verifikasi atasan/PJ Kegiatan.", 'error');
						redirect(SITE_AREA .'/permintaanbarang/permintaan_barang/');
						exit();
					}
			
					$result = $this->permintaan_barang_model->delete($pid);
					if($result){
						// delete pengikut
						$datadel = array('id_permintaan '=>$pid);
						$this->permintaan_barang_detil_model->delete_where($datadel);
					}
					
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('permintaan_barang_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('permintaan_barang_delete_failure') . $this->permintaan_barang_model->error, 'error');
				}
			}
		}
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$tahun 	= $this->input->get('tahun');
		$kg		= $this->input->get('kg');
		$this->load->library('pagination');
		$status		= $this->input->get('status');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->permintaan_barang_model->where('user_request',$this->current_user->id);
		}
		$total = $this->permintaan_barang_model->count_all($keyword,"",$tahun,$kg,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&pg=".$pg."&tahun=".$tahun."&status=".$status;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->permintaan_barang_model->where('user_request',$this->current_user->id);
		}
		$records = $this->permintaan_barang_model->limit($limit, $offset)->find_all($keyword,"",$tahun,$kg,$status,$pg);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('pg', $pg); 
		Template::set('tahun', $tahun); 
		Template::set('keyword', $keyword); 
		Template::set('kg', $kg); 
		Template::set('status', $status); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Permintaan Barang');
		Template::render();
	}
	


	/**
	 * Creates a Permintaan Barang object.
	 *
	 * @return void
	 */
	public function create()
	{
		
		$this->auth->restrict('Permintaan_Barang.Permintaanbarang.Create');
		$this->load->model('t_mak/t_mak_model', null, true);
		$this->t_mak_model->where("kdmak like '52%'");
		$recordtmak = $this->t_mak_model->find_all();
		Template::set('recordtmak', $recordtmak);
		//$noauto = date("y")."01";
		$noauto = date("y").sprintf( '%05d', "01" );
		// get kode terakhis pada hari ini
		$nomorpermintaan = date("Y");
		$this->permintaan_barang_model->where("tanggal_permintaan like '".$nomorpermintaan."-%'");
		$this->permintaan_barang_model->order_by("id","desc");
		$recordsst = $this->permintaan_barang_model->limit(1)->find_all();
		//print_r($recordsst);
		if(isset($recordsst) && is_array($recordsst) && count($recordsst))
		{
			$nomor = (int)$recordsst[0]->nomor + 1;
			//if($nomor <= 9)
			//	$nomor = "0".$nomor;	
			$noauto = sprintf( '%05d', $nomor );
		}
		//Template::set('recordsst', $recordsst);
		
		if (isset($_POST['save']))
		{
			$kode_kegiatan = $this->input->post('permintaan_barang_kegiatan');
			$atasan = "32";
			/*
			 $datakegiatan = $this->kegiatan_model->find_bykode($kode_kegiatan);
			 if(isset($datakegiatan))
			 {
				 $atasan = $datakegiatan[0]->pj; 
			 }
			 */
			 $atasan = $this->current_user->atasan;
			 // jika yang mita adalah anggota keltian KE
			 if($kode_kegiatan == "2.3" and $atasan == "11"){ // = qudsi
			 	$atasan = "71";
			 }
			  // jika yang mita adalah anggota keltian elmed
			 if($kode_kegiatan == "2.3" and $atasan == "49"){
			 	$atasan = "37";
			 }
			 
			//die($atasan." ini id atasan");
			if ($insert_id = $this->save_permintaan_barang($atasan))
			{
				// save to log permintaan
				$this->save_log($insert_id,"","Membuat Permintaan","Membuat Permintaan baru");
				// end save to log
				
				$this->load->helper('handle_upload');
				$nama_barang 	= $this->input->post('nama_barang');
				$spek 			= $this->input->post('spek');
				$jumlah 		= $this->input->post('jumlah');
				$satuan 		= $this->input->post('satuan');
				$harga 			= $this->input->post('harga');
				$jumlah_all    	= $this->input->post('jumlah_all');
				$mark    		= $this->input->post('mark');
				$index = 0;
				
				if(isset($_POST['nama_barang'])){
					$nomordetil = 1;
					foreach($this->input->post("nama_barang") as $value )
					{
						if($value != "")
						{
							$uploadData = array();
							$upload = true; 
							if (isset($_FILES['file_upload_'.$index]))
							{
								//die($this->settings_lib->item('site.pathphoto'));
								$uploadData = handle_upload('file_upload_'.$index,$this->settings_lib->item('site.pathuploaded'));
								//print_r($uploadData);
								//die($uploadData['data']['file_name']);
								if (isset($uploadData['error']) && !empty($uploadData['error']))
								{
									$upload = false;
								}
							} 	
							$this->save_detil_permintaan_barang($uploadData,$insert_id,$value, $spek[$index],$jumlah[$index],$satuan[$index],$harga[$index],$jumlah_all[$index],$mark[$index],$nomordetil);
							$nomordetil++;
						}
						$index++;
					}
				}
				$tambahan_email = "<br>Dari : ".$this->current_user->display_name."<br>";
				$tambahan_email .= "Nomor Permintaan : ".$this->input->post('permintaan_barang_nomor')."<br>";
				$tambahan_email .= "Anggaran : ".$this->input->post('permintaan_barang_anggaran');
				// kirim email ke atasan/PJ
				/*
				$penandatangan  = $nama_barang 	= $this->input->post('tanda_tangan');
				if($penandatangan == "1") // atasan langsung
					$atasan = $this->current_user->atasan; 
				else{
				*/
					// PJ kegiatan
					
					 
				//}			
				$resultmail = $this->sendmail($atasan,$tambahan_email ."<br/>Klik <a href='".base_url()."index.php/admin/permintaanbarang/permintaan_barang/verpj/".$insert_id."'>link</a>");
			   	if ($resultmail)
				{
					
					log_activity($this->current_user->id,"Sukses kirim email permintaan barang,". lang('permintaan_barang_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'permintaan_barang');
				}else{
					log_activity($this->current_user->id,"gagal mengirimkan email permintaan barang", 'permintaan_barang');
				}
			   	// end kirim email
		   
				// Log the activity
				

				Template::set_message(lang('permintaan_barang_create_success'), 'success');
				redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_create_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		
		Template::set('noauto', $noauto);
		Assets::add_module_js('permintaan_barang', 'permintaan_barang.js');

		Template::set('toolbar_title', lang('permintaan_barang_create') . ' Permintaan Barang');
		Template::render();
	}
	public function createbmn()
	{
		
		$this->auth->restrict('Permintaan_Barang.Permintaanbarang.Create');
		$this->load->model('t_mak/t_mak_model', null, true);
		$this->t_mak_model->where("kdmak like '53%'");
		$recordtmak = $this->t_mak_model->find_all();
		Template::set('recordtmak', $recordtmak);
		//$noauto = date("y")."01";
		$noauto = date("y").sprintf( '%05d', "01" );
		// get kode terakhis pada hari ini
		$nomorpermintaan = date("Y");
		$this->permintaan_barang_model->where("tanggal_permintaan like '".$nomorpermintaan."-%'");
		$this->permintaan_barang_model->order_by("id","desc");
		$recordsst = $this->permintaan_barang_model->limit(1)->find_all();
		//print_r($recordsst);
		if(isset($recordsst) && is_array($recordsst) && count($recordsst))
		{
			$nomor = (int)$recordsst[0]->nomor + 1;
			//if($nomor <= 9)
			//	$nomor = "0".$nomor;	
			$noauto = sprintf( '%05d', $nomor );
		}
		//Template::set('recordsst', $recordsst);
		
		if (isset($_POST['save']))
		{
			$kode_kegiatan = $this->input->post('permintaan_barang_kegiatan');
			$atasan = "32";
			/*
			 $datakegiatan = $this->kegiatan_model->find_bykode($kode_kegiatan);
			 if(isset($datakegiatan))
			 {
				 $atasan = $datakegiatan[0]->pj; 
			 }
			 */
			 $atasan = $this->current_user->atasan;
			 // jika yang mita adalah anggota keltian KE
			 if($kode_kegiatan == "2.3" and $atasan == "11"){ // = qudsi
			 	$atasan = "71";
			 }
			  // jika yang mita adalah anggota keltian elmed
			 if($kode_kegiatan == "2.3" and $atasan == "49"){
			 	$atasan = "37";
			 }
			 
			//die($atasan." ini id atasan");
			if ($insert_id = $this->save_permintaan_barang($atasan))
			{
				// save to log permintaan
				$this->save_log($insert_id,"","Membuat Permintaan","Membuat Permintaan baru");
				// end save to log
				
				$this->load->helper('handle_upload');
				$nama_barang 	= $this->input->post('nama_barang');
				$spek 			= $this->input->post('spek');
				$jumlah 		= $this->input->post('jumlah');
				$satuan 		= $this->input->post('satuan');
				$harga 			= $this->input->post('harga');
				$jumlah_all    	= $this->input->post('jumlah_all');
				$mark    		= $this->input->post('mark');
				$index = 0;
				
				if(isset($_POST['nama_barang'])){
					$nomordetil = 1;
					foreach($this->input->post("nama_barang") as $value )
					{
						if($value != "")
						{
							$uploadData = array();
							$upload = true; 
							if (isset($_FILES['file_upload_'.$index]))
							{
								//die($this->settings_lib->item('site.pathphoto'));
								$uploadData = handle_upload('file_upload_'.$index,$this->settings_lib->item('site.pathuploaded'));
								//print_r($uploadData);
								//die($uploadData['data']['file_name']);
								if (isset($uploadData['error']) && !empty($uploadData['error']))
								{
									$upload = false;
								}
							} 	
							$this->save_detil_permintaan_barang($uploadData,$insert_id,$value, $spek[$index],$jumlah[$index],$satuan[$index],$harga[$index],$jumlah_all[$index],$mark[$index],$nomordetil);
							$nomordetil++;
						}
						$index++;
					}
				}
				$tambahan_email = "<br>Dari : ".$this->current_user->display_name."<br>";
				$tambahan_email .= "Nomor Permintaan : ".$this->input->post('permintaan_barang_nomor')."<br>";
				$tambahan_email .= "Anggaran : ".$this->input->post('permintaan_barang_anggaran');
				// kirim email ke atasan/PJ
				/*
				$penandatangan  = $nama_barang 	= $this->input->post('tanda_tangan');
				if($penandatangan == "1") // atasan langsung
					$atasan = $this->current_user->atasan; 
				else{
				*/
					// PJ kegiatan
					
					 
				//}			
				$resultmail = $this->sendmail($atasan,$tambahan_email ."<br/>Klik <a href='".base_url()."index.php/admin/permintaanbarang/permintaan_barang/verpj/".$insert_id."'>link</a>");
			   	if ($resultmail)
				{
					
					log_activity($this->current_user->id,"Sukses kirim email permintaan barang,". lang('permintaan_barang_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'permintaan_barang');
				}else{
					log_activity($this->current_user->id,"gagal mengirimkan email permintaan barang", 'permintaan_barang');
				}
			   	// end kirim email
		   
				// Log the activity
				

				Template::set_message(lang('permintaan_barang_create_success'), 'success');
				redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_create_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		
		Template::set('noauto', $noauto);
		Assets::add_module_js('permintaan_barang', 'permintaan_barang.js');

		Template::set('toolbar_title', lang('permintaan_barang_create') . ' Permintaan Barang');
		Template::render();
	}
	public function createbmn1()
	{
		
		$this->auth->restrict('Permintaan_Barang.Permintaanbarang.Create');
		$this->load->model('t_mak/t_mak_model', null, true);
		$this->t_mak_model->where("kdmak like '53%'");
		$recordtmak = $this->t_mak_model->find_all();
		Template::set('recordtmak', $recordtmak);
		//$noauto = date("y")."01";
		$noauto = date("y").sprintf( '%05d', "01" );
		// get kode terakhis pada hari ini
		$nomorpermintaan = date("Y");
		$this->permintaan_barang_model->where("tanggal_permintaan like '".$nomorpermintaan."-%'");
		$this->permintaan_barang_model->order_by("id","desc");
		$recordsst = $this->permintaan_barang_model->limit(1)->find_all();
		//print_r($recordsst);
		if(isset($recordsst) && is_array($recordsst) && count($recordsst))
		{
			$nomor = (int)$recordsst[0]->nomor + 1;
			//if($nomor <= 9)
			//	$nomor = "0".$nomor;	
			$noauto = sprintf( '%05d', $nomor );
		}
		//Template::set('recordsst', $recordsst);
		
		if (isset($_POST['save']))
		{
			$kode_kegiatan = $this->input->post('permintaan_barang_kegiatan');
			$status_permintaanbarang = $this->input->post('status_permintaan');
			if ($insert_id = $this->save_persediaan($status_permintaanbarang))
			{
				// save to log permintaan
				$this->save_log($insert_id,"","Membuat Permintaan","Membuat Permintaan baru");
				// end save to log
				
				$this->load->helper('handle_upload');
				$nama_barang 	= $this->input->post('nama_barang');
				$spek 			= $this->input->post('spek');
				$jumlah 		= $this->input->post('jumlah');
				$satuan 		= $this->input->post('satuan');
				$harga 			= $this->input->post('harga');
				$jumlah_all    	= $this->input->post('jumlah_all');
				$mark    		= $this->input->post('mark');
				$index = 0;
				
				if(isset($_POST['nama_barang'])){
					$nomordetil = 1;
					foreach($this->input->post("nama_barang") as $value )
					{
						if($value != "")
						{
							$uploadData = array();
							$upload = true; 
							if (isset($_FILES['file_upload_'.$index]))
							{
								//die($this->settings_lib->item('site.pathphoto'));
								$uploadData = handle_upload('file_upload_'.$index,$this->settings_lib->item('site.pathuploaded'));
								//print_r($uploadData);
								//die($uploadData['data']['file_name']);
								if (isset($uploadData['error']) && !empty($uploadData['error']))
								{
									$upload = false;
								}
							} 	
							$this->save_detil_permintaan_barang($uploadData,$insert_id,$value, $spek[$index],$jumlah[$index],$satuan[$index],$harga[$index],$jumlah_all[$index],$mark[$index],$nomordetil);
							$nomordetil++;
						}
						$index++;
					}
				}
				 	
				$resultmail = $this->sendmail($atasan,"<br/>Klik <a href='".base_url()."index.php/admin/permintaanbarang/permintaan_barang/verpj/".$insert_id."'>link</a>");
			   	if ($resultmail)
				{
					
					log_activity($this->current_user->id,"Sukses kirim email permintaan barang,". lang('permintaan_barang_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'permintaan_barang');
				}else{
					log_activity($this->current_user->id,"gagal mengirimkan email permintaan barang", 'permintaan_barang');
				}
			   	// end kirim email
		   
				// Log the activity
				

				Template::set_message(lang('permintaan_barang_create_success'), 'success');
				redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_create_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		
		Template::set('noauto', $noauto);
		Assets::add_module_js('permintaan_barang', 'permintaan_barang.js');

		Template::set('toolbar_title', lang('permintaan_barang_create') . ' Permintaan Barang');
		Template::render();
	}
	public function createbmnold()
	{
		
		$this->auth->restrict('Permintaan_Barang.Permintaanbarang.Create');
		$this->load->model('t_mak/t_mak_model', null, true);
		$this->t_mak_model->where("kdmak like '53%'");
		$recordtmak = $this->t_mak_model->find_all();
		Template::set('recordtmak', $recordtmak);
		//$noauto = date("y")."01";
		$noauto = date("y").sprintf( '%05d', "01" );
		// get kode terakhis pada hari ini
		$nomorpermintaan = date("Y");
		$this->permintaan_barang_model->where("tanggal_permintaan like '".$nomorpermintaan."-%'");
		$this->permintaan_barang_model->order_by("id","desc");
		$recordsst = $this->permintaan_barang_model->limit(1)->find_all();
		//print_r($recordsst);
		if(isset($recordsst) && is_array($recordsst) && count($recordsst))
		{
			$nomor = (int)$recordsst[0]->nomor + 1;
			//if($nomor <= 9)
			//	$nomor = "0".$nomor;	
			$noauto = sprintf( '%05d', $nomor );
		}
		//Template::set('recordsst', $recordsst);
		
		if (isset($_POST['save']))
		{
			$kode_kegiatan = $this->input->post('permintaan_barang_kegiatan');
			$atasan = "32";
			 $datakegiatan = $this->kegiatan_model->find_bykode($kode_kegiatan);
			 if(isset($datakegiatan))
			 {
				 $atasan = $datakegiatan[0]->pj; 
			 }
			//die($atasan." ini id atasan");
			if ($insert_id = $this->save_permintaan_barang($atasan))
			{
				// save to log permintaan
				$this->save_log($insert_id,"","Membuat Permintaan","Membuat Permintaan baru");
				// end save to log
				
				$this->load->helper('handle_upload');
				$nama_barang 	= $this->input->post('nama_barang');
				$spek 			= $this->input->post('spek');
				$jumlah 		= $this->input->post('jumlah');
				$satuan 		= $this->input->post('satuan');
				$harga 			= $this->input->post('harga');
				$jumlah_all    	= $this->input->post('jumlah_all');
				$mark    		= $this->input->post('mark');
				$index = 0;
				
				if(isset($_POST['nama_barang'])){
					$nomordetil = 1;
					foreach($this->input->post("nama_barang") as $value )
					{
						if($value != "")
						{
							$uploadData = array();
							$upload = true; 
							if (isset($_FILES['file_upload_'.$index]))
							{
								//die($this->settings_lib->item('site.pathphoto'));
								$uploadData = handle_upload('file_upload_'.$index,$this->settings_lib->item('site.pathuploaded'));
								//print_r($uploadData);
								//die($uploadData['data']['file_name']);
								if (isset($uploadData['error']) && !empty($uploadData['error']))
								{
									$upload = false;
								}
							} 	
							$this->save_detil_permintaan_barang($uploadData,$insert_id,$value, $spek[$index],$jumlah[$index],$satuan[$index],$harga[$index],$jumlah_all[$index],$mark[$index],$nomordetil);
							$nomordetil++;
						}
						$index++;
					}
				}
				 	
				$resultmail = $this->sendmail($atasan,"<br/>Klik <a href='".base_url()."index.php/admin/permintaanbarang/permintaan_barang/verpj/".$insert_id."'>link</a>");
			   	if ($resultmail)
				{
					
					log_activity($this->current_user->id,"Sukses kirim email permintaan barang,". lang('permintaan_barang_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'permintaan_barang');
				}else{
					log_activity($this->current_user->id,"gagal mengirimkan email permintaan barang", 'permintaan_barang');
				}
			   	// end kirim email
		   
				// Log the activity
				

				Template::set_message(lang('permintaan_barang_create_success'), 'success');
				redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_create_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		
		Template::set('noauto', $noauto);
		Assets::add_module_js('permintaan_barang', 'permintaan_barang.js');

		Template::set('toolbar_title', lang('permintaan_barang_create') . ' Permintaan Barang');
		Template::render();
	}
	public function periksa()
	{
 
		$keyword 	= $this->input->get('keyword');
		$bulan 		= $this->input->get('bulan');
		$tahun 		= $this->input->get('tahun');
		$kg			= $this->input->get('kg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->permintaan_barang_model->where('id_atasan',$this->current_user->id);
		}
		//$this->permintaan_barang_model->where('status_permintaan',"1");
		$total = $this->permintaan_barang_model->count_all($keyword,$bulan,$tahun,$kg,$status);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&bulan=".$bulan."&tahun=".$tahun."&status=".$status;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->permintaan_barang_model->where('id_atasan',$this->current_user->id);
		}
		//$this->permintaan_barang_model->where('status_permintaan',"1");
		$records = $this->permintaan_barang_model->limit($limit, $offset)->find_all($keyword,$bulan,$tahun,$kg,$status);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('bulan', $bulan); 
		Template::set('tahun', $tahun); 
		Template::set('keyword', $keyword); 
		Template::set('kg', $kg); 
		Template::set('status', $status); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Permintaan Barang');
		Template::render();
	}
	
	public function periksakb()
	{
 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status 	= $this->input->get('status');
		$kg		= $this->input->get('kg');
		$this->load->library('pagination');
		 
		//$this->permintaan_barang_model->where('status_permintaan',"2");
		 
		$total = $this->permintaan_barang_model->count_all($keyword,"","",$kg,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&pg=".$pg."&status=".$status;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		 
		//$this->permintaan_barang_model->where('status_permintaan',"2");
		
		$records = $this->permintaan_barang_model->limit($limit, $offset)->find_all($keyword,"","",$kg,$status,$pg);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('kg', $kg); 
		Template::set('pg', $pg); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Permintaan Barang');
		Template::render();
	}
	
	public function ppk()
	{
 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status 	= $this->input->get('status');
		$kg		= $this->input->get('kg');
		$this->load->library('pagination');
		 
		//$this->permintaan_barang_model->where('status_permintaan',"2");
		$id_permintaan = isset($recpermintaan->id) ? $recpermintaan->id : "";
		if($this->current_user->id == "27"){
			$this->permintaan_barang_model->where("anggaran","Rutin");
		}else{
			$this->permintaan_barang_model->where("anggaran != 'Rutin'");
		}
		$total = $this->permintaan_barang_model->count_ppk_all($keyword,"","",$kg,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&pg=".$pg."&status=".$status;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		 
		//$this->permintaan_barang_model->where('status_permintaan',"2");
		if($this->current_user->id == "27" or $this->current_user->id == "1"){
			$this->permintaan_barang_model->where("anggaran","Rutin");
		}else{
			$this->permintaan_barang_model->where("anggaran != 'Rutin'");
		}
		$records = $this->permintaan_barang_model->limit($limit, $offset)->find_ppk_all($keyword,"","",$kg,$status,$pg);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('kg', $kg); 
		Template::set('pg', $pg); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Permintaan Barang');
		Template::render();
	}
	
	public function persediaan()
	{
 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$tahun 	= $this->input->get('tahun');
		$kg		= $this->input->get('kg');
		$this->load->library('pagination');
		 
		//$this->permintaan_barang_model->where('status_permintaan >= 3');
		$total = count($this->permintaan_barang_model->find_persediaan($keyword,"",$tahun,$kg,"",$pg));
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&pg=".$pg."&tahun=".$tahun;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		 
		//$this->permintaan_barang_model->where('status_permintaan >= 3');
		$records = $this->permintaan_barang_model->limit($limit, $offset)->find_persediaan($keyword,"",$tahun,$kg,"",$pg);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('pg', $pg); 
		Template::set('tahun', $tahun); 
		Template::set('keyword', $keyword); 
		Template::set('kg', $kg); 
		 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Permintaan Barang');
		Template::render();
	}
	public function bmn()
	{
 
		$keyword = $this->input->get('keyword');
		$bulan 	= $this->input->get('bulan');
		$tahun 	= $this->input->get('tahun');
		$kg		= $this->input->get('kg');
		$pg 	= $this->input->get('pg');
		$this->load->library('pagination');
		 
		//$this->permintaan_barang_model->where('status_permintaan >= 3');
		$total = count($this->permintaan_barang_model->find_bmn($keyword,$bulan,$tahun,$kg,"",$pg));
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&bulan=".$bulan."&tahun=".$tahun."&pg=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		 
		//$this->permintaan_barang_model->where('status_permintaan >= 3');
		$records = $this->permintaan_barang_model->limit($limit, $offset)->find_bmn($keyword,$bulan,$tahun,$kg,"",$pg);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('bulan', $bulan); 
		Template::set('tahun', $tahun); 
		Template::set('keyword', $keyword); 
		Template::set('kg', $kg); 
		Template::set('pg', $pg); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Permintaan BMN');
		Template::render();
	}
	public function pengadaan()
	{
 
		$keyword = $this->input->get('keyword');
		$bulan 	= $this->input->get('bulan');
		$tahun 	= $this->input->get('tahun');
		$kg		= $this->input->get('kg');
		$pg		= $this->input->get('pg');
		$this->load->library('pagination');
		 
		$this->permintaan_barang_detil_model->where('(status_pengadaan = "1" or status_pengadaan = "2" or status_pengadaan = "5")');
		$total = count($this->permintaan_barang_detil_model->find_pengadaan($keyword,$bulan,$tahun,$kg,$pg));
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&bulan=".$bulan."&tahun=".$tahun."&pg=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		$this->permintaan_barang_detil_model->where('(status_pengadaan = "1" or status_pengadaan = "2" or status_pengadaan = "5")');
		$records = $this->permintaan_barang_detil_model->limit($limit, $offset)->find_pengadaan($keyword,$bulan,$tahun,$kg,$pg);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('bulan', $bulan); 
		Template::set('tahun', $tahun); 
		Template::set('keyword', $keyword); 
		Template::set('kg', $kg); 
		Template::set('pg', $pg); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Permintaan Barang');
		Template::render();
	}
	public function createpengadaan()
	{
 
		$kode = $this->uri->segment(5);
		$stat = $this->uri->segment(6);
		$id = $this->uri->segment(7);
		 
		$records = $this->permintaan_barang_detil_model->find($kode);
		Template::set('permintaan_barang_detil', $records);
		
		if (empty($kode))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			//die();
		}

		if (isset($_POST['save']))
		{
			
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.persediaan');
			$nama_barang 	= $this->input->post('nama_barang');
			$spek_barang 			= $this->input->post('spek_barang');
			$jumlah 		= $this->input->post('jumlah');
			$barangdetil = $this->permintaan_barang_detil_model->find($kode);
			$nomor = $barangdetil->nomor;
			$userrequest = $barangdetil->display_name;
			$recpermintaan = $this->permintaan_barang_model->find_by("nomor",$nomor);
			// PPK rutin pak ade
			$anggaran = isset($recpermintaan->anggaran) ? $recpermintaan->anggaran : "";
			$id_permintaan = isset($recpermintaan->id) ? $recpermintaan->id : "";
			if($anggaran == "Rutin")
				$ppk = "27";
			else
				$ppk = "37"; // asep
			// PPK tematik n PNBP pak asep
			//die($stat." stat");
			if ($this->save_ppk($jumlah,"4","1","",date("Y-m-d"),'update', $kode))
			{
				// updte status permintaan
				$data = array();
				$data['status_permintaan']      	= 6; // status ppk
				$result = $this->permintaan_barang_model->update($id_permintaan,$data);
				
				// kirim email ke kasubbid KPU
				$strtambahan = "Dari : ".$userrequest."<br>";
				$strtambahan .= "Nomor Permintaan : ".$nomor."<br>";
				$strtambahan .= "Nama Barang : ".$nama_barang."<br>";
				$strtambahan .= "Spek : ".$spek_barang."<br>";
				$strtambahan .= "Jumlah : ".$jumlah."<br>";
				
				$resultmail = $this->sendmail($ppk,"<br/>".$strtambahan."Klik <a href='".base_url()."admin/permintaanbarang/permintaan_barang/ppk/?keyword=".$nomor."'>link</a>");
				// end kirim email
				// save to log permintaan
				$keterangan = "";
				$keterangan = "Dikirimkan permintaan ke PPK";
				$this->save_log($id,$kode,"Kirim PPK",$keterangan);
				// end save to log
				
				// Log the activity
				log_activity($this->current_user->id, ' Kirim ke ppk : '. $kode .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(" Kirim ke ppk sukses", 'success');
			}
			else
			{
				Template::set_message(" Kirim ke ppk ". $this->permintaan_barang_model->error, 'error');
			}
		}
		
		Template::set('toolbar_title', 'Kirim ke PPK');
		Template::set_theme('simple');
		Template::render();
	}
	public function createpengadaanold()
	{
 
		$kode = $this->uri->segment(5);
		$stat = $this->uri->segment(6);
		$id = $this->uri->segment(7);
		 
		$records = $this->permintaan_barang_detil_model->find($kode);
		Template::set('permintaan_barang_detil', $records);
		
		if (empty($kode))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			//die();
		}

		if (isset($_POST['save']))
		{
			
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.persediaan');
			$nama_barang 	= $this->input->post('nama_barang');
			$spek_barang 			= $this->input->post('spek_barang');
			$jumlah 		= $this->input->post('jumlah');
			$barangdetil = $this->permintaan_barang_detil_model->find($kode);
			$nomor = $barangdetil->nomor;
			$userrequest = $barangdetil->display_name;
			if ($this->save_pengadaan($jumlah,$stat,"1","",date("Y-m-d"),'update', $kode))
			{
				// kirim email ke kasubbid KPU
				$strtambahan = "Dari : ".$userrequest."<br>";
				$strtambahan .= "Nomor Permintaan : ".$nomor."<br>";
				$strtambahan .= "Nama Barang : ".$nama_barang."<br>";
				$strtambahan .= "Spek : ".$spek_barang."<br>";
				$strtambahan .= "Jumlah : ".$jumlah."<br>";
				$pengadaan = $this->settings_lib->item('site.pengadaan'); 
				$resultmail = $this->sendmail($pengadaan,"<br/>".$strtambahan."Klik <a href='".base_url()."admin/permintaanbarang/permintaan_barang/pengadaan/?keyword=".$nomor."'>link</a>");
				// end kirim email
				// save to log permintaan
				$keterangan = "";
				$keterangan = "Dikirimkan permintaan ke bagian pengadaan";
				$this->save_log($id,$kode,"Kirim pengadaan",$keterangan);
				// end save to log
				
				// Log the activity
				log_activity($this->current_user->id, ' Kirim ke kepengadaan : '. $kode .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(" Kirim ke kepengadaan sukses", 'success');
			}
			else
			{
				Template::set_message(" Kirim ke kepengadaan ". $this->permintaan_barang_model->error, 'error');
			}
		}
		
		Template::set('toolbar_title', 'Kirim ke pengadaan');
		Template::set_theme('simple');
		Template::render();
	}
	//--------------------------------------------------------------------
	private function sendmail($atasan,$tambahan="")
	{
	
		$user = $this->user_model->find($atasan);
		$email = "";
		if (isset($user))
		{
			$email = isset($user->email) ? $user->email : "";
		}
		//sending mail
		$subjek       		= "Notifikasi Permintaan Barang ";
		$isi        	= "Anda Perlu memeriksa Permintaan barang ".$tambahan;
		$this->load->library('emailer/emailer');
		$dataemail = array (
			'subject'	=> $subjek,
			'message'	=> $isi,
		);
		$success_count = 0;
		$resultmail = FALSE;
		 
		$dataemail['to'] = $email;
		$resultmail = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
		//$resultmail = $this->emailer->send($dataemail,true);
			 	 
		return $resultmail;
	}
	//--------------------------------------------------------------------


	/**
	 * Allows editing of Permintaan Barang data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
		}
		$this->load->model('t_mak/t_mak_model', null, true);
		$recordtmak = $this->t_mak_model->find_all();
		Template::set('recordtmak', $recordtmak);
		$permintaan_barang = $this->permintaan_barang_model->find($id);
		if (isset($_POST['save']))
		{
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.Edit');
			if($permintaan_barang->status_kabag == "1" and $this->current_user->role_id != "1" and $this->current_user->role_id != "16")
			{
				Template::set_message("Permintaan tidak bisa diubah karena sudah diverifikasi oleh atasan/PJ Kegiatan, Silahkan koordinasikan dengan atasan anda.", 'error');
				redirect(SITE_AREA .'/permintaanbarang/permintaan_barang/edit/'.$id);
			}
	 		$atasan = "32";
	 		$kode_kegiatan = $this->input->post('permintaan_barang_kegiatan');
			 $datakegiatan = $this->kegiatan_model->find_bykode($kode_kegiatan);
			 if(isset($datakegiatan))
			 {
				 $atasan = $datakegiatan[0]->pj; 
			 }
			if ($this->save_permintaan_barang($atasan,'update', $id))
			{
				 
				//delete dulu di detil
				// delete pengikut
				$datadel = array('id_permintaan '=>$id);
				$this->permintaan_barang_detil_model->delete_where($datadel);
				
				//update data
				$nama_barang 	= $this->input->post('nama_barang');
				$spek 			= $this->input->post('spek');
				$jumlah 		= $this->input->post('jumlah');
				$satuan 		= $this->input->post('satuan');
				$harga 			= $this->input->post('harga');
				$mark 			= $this->input->post('mark');
				$jumlah_all 	= $this->input->post('jumlah_all');
				$index = 0;
				if(isset($_POST['nama_barang'])){
					 $this->load->helper('handle_upload');
					 $nomordetil = 1;
					foreach($this->input->post("nama_barang") as $value )
					{
						$uploadData = array();
						$upload = true; 
						if (isset($_FILES['file_upload_'.$index]))
						{
							//die($this->settings_lib->item('site.pathphoto'));
							$uploadData = handle_upload('file_upload_'.$index,$this->settings_lib->item('site.pathuploaded'));
							//print_r($uploadData);
							//die($uploadData['data']['file_name']);
							if (isset($uploadData['error']) && !empty($uploadData['error']))
							{
								$upload = false;
							}
						} 	
						
						$this->save_detil_permintaan_barang($uploadData,$id,$value, $spek[$index],$jumlah[$index],$satuan[$index],$harga[$index],$jumlah_all[$index],$mark[$index],$nomordetil);
						$nomordetil++;
						$index++;
					}
				}
				$resultmail = $this->sendmail($atasan,"<br/>Klik <a href='".base_url()."index.php/admin/permintaanbarang/permintaan_barang/periksa/".$id."'>link</a>");
			   
				// Log the activity
				log_activity($this->current_user->id, lang('permintaan_barang_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_edit_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.Delete');
			$permintaan_barang = $this->permintaan_barang_model->find($id);
			if($permintaan_barang->status_atasan == "1")
			{
				Template::set_message("Permintaan tidak bisa di hapus karena sudah melalui proses verifikasi atasan/PJ Kegiatan.", 'error');
				redirect(SITE_AREA .'/permintaanbarang/permintaan_barang/edit/'.$id);
				exit();
			}
			
			if ($this->permintaan_barang_model->delete($id))
			{
				 
				// delete pengikut
				$datadel = array('id_permintaan '=>$id);
				$this->permintaan_barang_detil_model->delete_where($datadel);
			 
				// Log the activity
				log_activity($this->current_user->id, lang('permintaan_barang_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_delete_success'), 'success');

				redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_delete_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		$permintaan_barang = $this->permintaan_barang_model->find($id);
		$data_detil = $this->permintaan_barang_detil_model->find_byidpermintaan($id);
		if($permintaan_barang->status_kabag == "1" and $this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			Template::set_message("Permintaan tidak bisa diubah karena sudah diverifikasi oleh atasan/PJ Kegiatan", 'error');
		}
		
		Template::set('data_detil', $data_detil);
		$jumlahdetil = count($data_detil);
		Template::set('jumlahdetil', $jumlahdetil);
		//die($jumlahdetil." jumlah");
		Template::set('permintaan_barang', $permintaan_barang);
		Template::set('toolbar_title', lang('permintaan_barang_edit') .' Permintaan Barang');
		Template::render();
	}
	public function timeline()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
		}
		$logpermintaan = $this->log_permintaan_model->find_all($id,"");
		Template::set('logpermintaan', $logpermintaan);
		
		$permintaan_barang = $this->permintaan_barang_model->find($id);
		
		Template::set_theme('simple');
		Template::set('permintaan_barang', $permintaan_barang);
		Template::set('toolbar_title', ' Timeline Permintaan Barang');
		Template::render();
	}
	public function verpj()
	{
		$id = $this->uri->segment(5);
		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.atasan');

			if ($this->save_verifikasiatasan('2','update', $id))
			{ 
				// save to log permintaan
				$keterangan = "";
				if($this->input->post('status_atasan') == "1")
				{
				
					$keterangan = "Verifikasi oleh atasan langsung/PJ Kegiatan, Pengajuan diterima";	
					// kirim email ke kasubbid KPU
					$kasubkpu = $this->settings_lib->item('site.kasubkpu'); 
					$atasan = $kasubkpu; 	
					$resultmail = $this->sendmail($atasan,"<br/>Klik <a href='".base_url()."index.php/admin/permintaanbarang/permintaan_barang/periksakb/".$id."'>link</a>");
					// end kirim email
				}elseif($this->input->post('status_atasan') == "2")
				{
					// update status ke bmn/persediaan
					$datastatus = array();
					//$datastatus['status_at']   = 2; // status ppk telah disetujui
					$datastatus['status_permintaan']      = 7;// permintaanditolak
					$result = $this->permintaan_barang_model->update($id,$datastatus);
					
					$keterangan = "Verifikasi oleh atasan langsung/PJ Kegiatan, Pengajuan ditolak";	
				}
				$this->save_log($id,"","Verifikasi atasan",$keterangan);
				// end save to log
				
				// Log the activity
				log_activity($this->current_user->id, "Verifikasi atasan langsung " .': '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message("Verifikasi Sukses", 'success');
			}
			else
			{
				Template::set_message("Verifikasi gagal" . $this->permintaan_barang_model->error, 'error');
			}
		}
		 
		$data_detil = $this->permintaan_barang_detil_model->find_byidpermintaan($id);
		Template::set('data_detil', $data_detil);
		$jumlahdetil = count($data_detil);
		Template::set('jumlahdetil', $jumlahdetil);
		//die($jumlahdetil." jumlah");
		Template::set('permintaan_barang', $this->permintaan_barang_model->find($id));
		Template::set('toolbar_title', 'Verifikasi Permintaan Barang');
		Template::render();
	}
	public function verps()
	{
		Template::set_block('sub_nav', 'permintaanbarang/_sub_persediaan');
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');

		$id = $this->uri->segment(5);
		$datadetilpermintaan = $this->permintaan_barang_model->find($id);
		//print_r($datadetilpermintaan);
		//die($datadetilpermintaan->user_request);
		//die();
		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.persediaan');
			$status_permintaanbarang = $this->input->post('status_permintaan');
			if ($this->save_persediaan($status_permintaanbarang,'update', $id))
			{ 
				// save to log permintaan
				$keterangan = "";
				$keterangan = "Verifikasi persediaan, Cek barang oleh bagian persediaan";	
				$this->save_log($id,"","Verifikasi Persediaan",$keterangan);
				// end save to log
				
				//update data detil permintaan
				$kode		 	= $this->input->post('kode');
				$jumlahada 			= $this->input->post('jumlahada'); 
				$status_barang 			= $this->input->post('status_barang'); 
				$harga 			= $this->input->post('harga'); 
				$jumlah_all 			= $this->input->post('jumlah_all'); 
				
				$index = 0;
				if(isset($_POST['kode'])){
					 
					foreach($this->input->post("kode") as $value )
					{
						$this->update_detil_permintaan_barang($jumlahada[$index],$status_barang[$index],$harga[$index],$jumlah_all[$index],'update',$value);
						$index++;
					}
				}
				
					
				// Log the activity
				log_activity($this->current_user->id, 'Update Oleh persediaan: '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_edit_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		if (isset($_POST['sendmail']))
		{
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.persediaan');
			$status_permintaanbarang = $this->input->post('status_permintaan');
			if ($this->save_persediaan($status_permintaanbarang,'update', $id))
			{ 
				// save to log permintaan
				$keterangan = "";
				$keterangan = "Verifikasi persediaan, Cek barang oleh bagian persediaan";	
				$this->save_log($id,"","Verifikasi Persediaan",$keterangan);
				// end save to log
				
				//update data detil permintaan
				$kode		 	= $this->input->post('kode');
				$jumlahada 			= $this->input->post('jumlahada'); 
				$status_barang 			= $this->input->post('status_barang'); 
				$harga 			= $this->input->post('harga'); 
				$jumlah_all 			= $this->input->post('jumlah_all'); 
				
				$index = 0;
				
				// kirim notif ke yang meminta
				$keterangan = "Permintaan anda sudah diproses oleh bagian persediaan, silahkan cek";	
				$requestuser = $datadetilpermintaan->user_request; 
				$resultmail = $this->sendmail($requestuser,$keterangan."<br/>Klik <a href='".base_url()."index.php/admin/permintaanbarang/permintaan_barang/edit/".$id."'>link</a>");
				
				
				if(isset($_POST['kode'])){
					 
					foreach($this->input->post("kode") as $value )
					{
						$this->update_detil_permintaan_barang($jumlahada[$index],$status_barang[$index],$harga[$index],$jumlah_all[$index],'update',$value);
						$index++;
					}
				}
				
				// Log the activity
				log_activity($this->current_user->id, 'Update Oleh persediaan: '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_edit_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		 
		$data_detil = $this->permintaan_barang_detil_model->find_byidpermintaan($id,"52");
		Template::set('data_detil', $data_detil);
		$jumlahdetil = count($data_detil);
		Template::set('jumlahdetil', $jumlahdetil);
		Template::set('id', $id);
		Template::set('permintaan_barang', $this->permintaan_barang_model->find($id));
		Template::set('toolbar_title', 'Verifikasi Permintaan Barang');
		Template::render();
	}
	public function verbmn()
	{
		Template::set_block('sub_nav', 'permintaanbarang/_sub_persediaan');
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');

		$id = $this->uri->segment(5);
		$datadetilpermintaan = $this->permintaan_barang_model->find($id);
		//print_r($datadetilpermintaan);
		//die($datadetilpermintaan->user_request);
		//die();
		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.persediaan');
			$status_permintaanbarang = $this->input->post('status_permintaan');
			if ($this->save_persediaan($status_permintaanbarang,'update', $id))
			{ 
				// save to log permintaan
				$keterangan = "";
				$keterangan = "Verifikasi BMN, Cek barang oleh bagian BMN";	
				$this->save_log($id,"","Verifikasi Persediaan",$keterangan);
				// end save to log
				
				//update data detil permintaan
				$kode		 	= $this->input->post('kode');
				$jumlahada 			= $this->input->post('jumlahada'); 
				$status_barang 			= $this->input->post('status_barang'); 
				$harga 			= $this->input->post('harga'); 
				$jumlah_all 			= $this->input->post('jumlah_all'); 
				
				$index = 0;
				if(isset($_POST['kode'])){
					 
					foreach($this->input->post("kode") as $value )
					{
						$this->update_detil_permintaan_barang($jumlahada[$index],$status_barang[$index],$harga[$index],$jumlah_all[$index],'update',$value);
						$index++;
					}
				}
				// kirim notif ke yang meminta
				$keterangan = "Permintaan anda sudah diproses oleh bagian BMN, silahkan cek";	
				$requestuser = $datadetilpermintaan->user_request; 
				$resultmail = $this->sendmail($requestuser,"<br/>Klik <a href='".base_url()."index.php/admin/permintaanbarang/permintaan_barang/edit/".$id."'>link</a>");
				
					
				// Log the activity
				log_activity($this->current_user->id, 'Update Oleh Petugas BMN: '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_edit_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		if (isset($_POST['sendmail']))
		{
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.persediaan');
			$status_permintaanbarang = $this->input->post('status_permintaan');
			if ($this->save_persediaan($status_permintaanbarang,'update', $id))
			{ 
				// save to log permintaan
				$keterangan = "";
				$keterangan = "Verifikasi persediaan, Cek barang oleh bagian persediaan";	
				$this->save_log($id,"","Verifikasi Persediaan",$keterangan);
				// end save to log
				
				//update data detil permintaan
				$kode		 	= $this->input->post('kode');
				$jumlahada 			= $this->input->post('jumlahada'); 
				$status_barang 			= $this->input->post('status_barang'); 
				$harga 			= $this->input->post('harga'); 
				$jumlah_all 			= $this->input->post('jumlah_all'); 
				
				$index = 0;
				if(isset($_POST['kode'])){
					 
					foreach($this->input->post("kode") as $value )
					{
						$this->update_detil_permintaan_barang($jumlahada[$index],$status_barang[$index],$harga[$index],$jumlah_all[$index],'update',$value);
						$index++;
					}
				}
				
				// Log the activity
				log_activity($this->current_user->id, 'Update Oleh persediaan: '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message(lang('permintaan_barang_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('permintaan_barang_edit_failure') . $this->permintaan_barang_model->error, 'error');
			}
		}
		 
		$data_detil = $this->permintaan_barang_detil_model->find_byidpermintaan($id,"53");
		Template::set('data_detil', $data_detil);
		$jumlahdetil = count($data_detil);
		Template::set('jumlahdetil', $jumlahdetil);
		Template::set('id', $id);
		Template::set('permintaan_barang', $this->permintaan_barang_model->find($id));
		Template::set('toolbar_title', 'Verifikasi Permintaan Barang');
		Template::render();
	}
	public function printtandaterima()
	{
		Template::set_block('sub_nav', 'permintaanbarang/_sub_persediaan');
		$id = $this->uri->segment(5);
		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang/persediaan');
		}
		// save to log permintaan
		$keterangan = "";
		$keterangan = "Print Tanda Terima";	
		$this->save_log($id,"","Print",$keterangan);
		// end save to log
		
		$data_detil = $this->permintaan_barang_detil_model->find_byidpermintaan($id,"52");
		Template::set('data_detil', $data_detil);
		$jumlahdetil = count($data_detil);
		$permintaan_barang = $this->permintaan_barang_model->find($id);
		//print_r($permintaan_barang);
		 
		Template::set('jumlahdetil', $jumlahdetil);
		Template::set('id', $id);
		Template::set('permintaan_barang', $permintaan_barang);
		Template::set('toolbar_title', 'Verifikasi Permintaan Barang');
		Template::set_theme('print');
		Template::render();
	}
	public function printtandaterimabmn()
	{
		Template::set_block('sub_nav', 'permintaanbarang/_sub_persediaan');
		$id = $this->uri->segment(5);
		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang/persediaan');
		}
		// save to log permintaan
		$keterangan = "";
		$keterangan = "Print Tanda Terima";	
		$this->save_log($id,"","Print",$keterangan);
		// end save to log
		
		$data_detil = $this->permintaan_barang_detil_model->find_byidpermintaan($id,"53");
		Template::set('data_detil', $data_detil);
		$jumlahdetil = count($data_detil);
		$permintaan_barang = $this->permintaan_barang_model->find($id);
		//print_r($permintaan_barang);
		 
		Template::set('jumlahdetil', $jumlahdetil);
		Template::set('id', $id);
		Template::set('permintaan_barang', $permintaan_barang);
		Template::set('toolbar_title', 'Verifikasi Permintaan Barang');
		Template::set_theme('print');
		Template::render();
	}
	public function verkb()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Permintaan_Barang.Permintaanbarang.btu');

			if ($this->save_verifikasikb('3','update', $id))
			{ 
				// save to log permintaan
				//die($this->input->post('status_kabag')." status");
				$keterangan = "";
				if($this->input->post('status_kabag') == "1")
				{
					
					$keterangan = "Verifikasi oleh kasubbid umum dan kepegawaian, Pengajuan diterima";	
					// kirim email ke kasubbid KPU
					//cek apakah permintaan itu mak 52 atau 53
					$mak52 = $this->permintaan_barang_detil_model->check_mak($id,"52");
					$mak53 = $this->permintaan_barang_detil_model->check_mak($id,"53");
					if($mak52 > 0)
					{
						//die("persediaan");
						$emailto = $this->settings_lib->item('site.persediaan'); 
						$resultmail = $this->sendmail($emailto,"<br/>Klik <a href='".base_url()."admin/permintaanbarang/permintaan_barang/persediaan/".$id."'>link</a>");		
					}
					if($mak53 > 0)
					{
						
						$emailto = $this->settings_lib->item('site.bmn'); 
						$resultmail = $this->sendmail($emailto,"<br/>Klik <a href='".base_url()."admin/permintaanbarang/permintaan_barang/persediaan/".$id."'>link</a>");		
					}
					
					
					
					// end kirim email
				}elseif($this->input->post('status_kabag') == "2")
				{
					// update status ke bmn/persediaan
					//die("masuk");
					$datastatus = array();
					//$datastatus['status_kabag']   = 2; // status ppk telah disetujui
					$datastatus['status_permintaan']      = 7;// permintaanditolak
					$this->permintaan_barang_model->update($id,$datastatus);
					$keterangan = "Verifikasi oleh kasubbid umum dan kepegawaian, Pengajuan ditolak";	
				}
				$this->save_log($id,"","Verifikasi Kasubbid",$keterangan);
				// end save to log
				
				
				// Log the activity
				log_activity($this->current_user->id, 'Verifikasi kasubbid berhasil : '. $id .' : '. $this->input->ip_address(), 'permintaan_barang');

				Template::set_message("Verifikasi Berhasil", 'success');
			}
			else
			{
				Template::set_message("Ada kesalahan ". $this->permintaan_barang_model->error, 'error');
			}
		}
		 
		$data_detil = $this->permintaan_barang_detil_model->find_byidpermintaan($id);
		Template::set('data_detil', $data_detil);
		$jumlahdetil = count($data_detil);
		Template::set('jumlahdetil', $jumlahdetil);
		//die($jumlahdetil." jumlah");
		Template::set('permintaan_barang', $this->permintaan_barang_model->find($id));
		Template::set('toolbar_title', 'Persetujuan Permintaan Barang');
		Template::render();
	}
	public function verppk()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('permintaan_barang_invalid_id'), 'error');
			redirect(SITE_AREA .'/permintaanbarang/permintaan_barang');
		}

		if (isset($_POST['save']))
		{	
				$checked = $this->input->post('checked');
				$result = FALSE;
				if (is_array($checked) && count($checked))
				{
					$id_permintaan = "";
					foreach ($checked as $pid)
					{
						$catatan_ppk = $this->input->post('catatan_ppk_'.$pid);
						$barangdetil = $this->permintaan_barang_detil_model->find($pid);
						$nomor = $barangdetil->nomor;
						$userrequest = $barangdetil->display_name;
						$jumlah = $barangdetil->jml_barang_pengadaan;
						$spek_barang = $barangdetil->spek_barang;
						$nama_barang = $barangdetil->nama_barang;
						$id_permintaan = $barangdetil->id_permintaan;
						if ($this->save_pengadaan($jumlah,"3","1","",date("Y-m-d"),$catatan_ppk,'update', $pid))
						{
							// updte status barang
							$data = array();
							$data['status_ppk']      	= 2; // status ppk telah disetujui
							$data['status_barang']      = 4;// barang dipengadaan
							$result = $this->permintaan_barang_detil_model->update($pid,$data);
						
							// kirim email ke kasubbid KPU
							$strtambahan = "Dari : ".$userrequest."<br>";
							$strtambahan .= "Nomor Permintaan : ".$nomor."<br>";
							$strtambahan .= "Nama Barang : ".$nama_barang."<br>";
							$strtambahan .= "Spek : ".$spek_barang."<br>";
							$strtambahan .= "Jumlah : ".$jumlah."<br>";
							$pengadaan = $this->settings_lib->item('site.pengadaan'); 
							$resultmail = $this->sendmail($pengadaan,"<br/>".$strtambahan."Klik <a href='".base_url()."admin/permintaanbarang/permintaan_barang/pengadaan/?keyword=".$nomor."'>link</a>");
							// end kirim email
							// save to log permintaan
							$keterangan = "";
							$keterangan = "Dikirimkan permintaan ke bagian pengadaan";
							$this->save_log($id,$pid,"Kirim pengadaan",$keterangan);
							// end save to log
				
							// Log the activity
							log_activity($this->current_user->id, ' Kirim ke kepengadaan : '. $pid .' : '. $this->input->ip_address(), 'permintaan_barang');

							Template::set_message(" Kirim ke kepengadaan sukses", 'success');
						}
						else
						{
							Template::set_message(" Kirim ke kepengadaan ". $this->permintaan_barang_model->error, 'error');
						}
					
					}

					if ($result)
					{
						// updte status permintaan ke pengadaan
						$data = array();
						$data['status_permintaan']      	= 4; // status ppk
						$result = $this->permintaan_barang_model->update($id_permintaan,$data);
				
						Template::set_message(count($checked) .' Kirim permintaan ke pengadaan', 'success');
						redirect(SITE_AREA .'/permintaanbarang/permintaan_barang/ppk');
					}
					else
					{
						Template::set_message("Ada kesalahan". $this->permintaan_barang_model->error, 'error');
					}
				}
			
		}
		 
		$data_detil = $this->permintaan_barang_detil_model->find_byidpermintaanppk($id);
		Template::set('data_detil', $data_detil);
		$jumlahdetil = count($data_detil);
		Template::set('jumlahdetil', $jumlahdetil);
		//die($jumlahdetil." jumlah");
		Template::set('permintaan_barang', $this->permintaan_barang_model->find($id));
		Template::set('toolbar_title', 'Persetujuan Permintaan Barang');
		Template::render();
	}
	public function getbarang()
	{
		$index = $this->input->post('index');
		$this->load->model('t_mak/t_mak_model', null, true);
		$this->t_mak_model->where("kdmak like '52%'");
		$recordtmak = $this->t_mak_model->find_all();
		 
		$output="";
			$output .= $this->load->view('permintaanbarang/dinamic',array("index"=>$index,"recordtmak"=>$recordtmak),true);	
		 
		echo $output;
		die();
	}
	public function getbarangbmn()
	{
		$index = $this->input->post('index');
		$this->load->model('t_mak/t_mak_model', null, true);
		$this->t_mak_model->where("kdmak like '53%'");
		$recordtmak = $this->t_mak_model->find_all();
		 
		$output="";
			$output .= $this->load->view('permintaanbarang/dinamic',array("index"=>$index,"recordtmak"=>$recordtmak),true);	
		 
		echo $output;
		die();
	}
	public function savestatpengadaan()
	{
		$stat = $this->input->post('stat');
		$kode = $this->input->post('kode');
		$id = $this->input->post('id');
		//die($stat);
		if ($this->edit_detil_barang_topengadaan("","",$stat,"1","",'update', $kode))
		{
			
			if($stat == "3")
			{
				
					$barangdetil = $this->permintaan_barang_detil_model->find($kode);
					$nomor = $barangdetil->nomor;
					$id_permintaan = $barangdetil->id_permintaan;
					$nama_barang = $barangdetil->nama_barang;
					$spek_barang = $barangdetil->spek_barang;
					$userrequest = $barangdetil->display_name;
				
				$strtambahan = "Dari : ".$userrequest."<br>";
				$strtambahan .= "Nomor Permintaan : ".$nomor."<br>";
				$strtambahan .= "Nama Barang : ".$nama_barang."<br>";
				$strtambahan .= "Spek : ".$spek_barang."<br>";
				
				$keterangan = "Telah diubah status barang menjadi Sudah dibeli oleh bagian pengadaan";	
				 // kirim email ke persediaan
				 $persediaan = $this->settings_lib->item('site.persediaan'); 
				
				$mak52 = $this->permintaan_barang_detil_model->check_mak($kode,"52");
				$mak53 = $this->permintaan_barang_detil_model->check_mak($kode,"53");
				if($mak52 > 0)
				{
					//die("persediaan");
					$emailto = $this->settings_lib->item('site.persediaan'); 
					$resultmail = $this->sendmail($emailto,$keterangan."<br/>".$strtambahan."<br/>Klik <a href='".base_url()."admin/permintaanbarang/permintaan_barang/verps/".$id."'>link</a>");
				}
				if($mak53 > 0)
				{
				   
					$emailto = $this->settings_lib->item('site.bmn'); 
					$resultmail = $this->sendmail($emailto,$keterangan."<br/>".$strtambahan."<br/>Klik <a href='".base_url()."admin/permintaanbarang/permintaan_barang/verps/".$id."'>link</a>");
				}
			   
				 // kasih warna di persediaan
				 $datastatus = array();
				 $datastatus['persediaan_warna']    = 1;
				 $this->permintaan_barang_model->update($id_permintaan,$datastatus);
				 
				 // end kirim email	
			}
			
			// save to log permintaan
			$keterangan = "Perubahan data barang dari pengadaan menjadi ".$stat;	
			$this->save_log($id,$kode,"Update dari Pengadaan",$keterangan);
			// end save to log
			
			echo "Update Berhasil";
		}else{
			echo "Ada kesalahan";
		}
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
	private function save_permintaan_barang($atasan = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		$this->form_validation->set_rules('permintaan_barang_nomor','Nomor','required|unique[bf_permintaan_barang.nomor,bf_permintaan_barang.id]|max_length[10]');
		$this->form_validation->set_rules('permintaan_barang_anggaran','Anggaran','required|max_length[10]');
		$this->form_validation->set_rules('permintaan_barang_kegiatan','Kegiatan','required|max_length[20]');
		$this->form_validation->set_rules('permintaan_barang_tanggal_selesai','Tanggal Permintaan Selesai','required');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		$data = array();
		$data['nomor']        			= $this->input->post('permintaan_barang_nomor');
		
		$data['tanggal_permintaan']  	= date("Y-m-d");//$this->input->post('permintaan_barang_tanggal_permintaan') ? $this->input->post('permintaan_barang_tanggal_permintaan') : '0000-00-00';
		$data['anggaran']        		= $this->input->post('permintaan_barang_anggaran');
		$data['kegiatan']        		= $this->input->post('permintaan_barang_kegiatan');
		$data['tanggal_selesai']        = $this->input->post('permintaan_barang_tanggal_selesai') ? $this->input->post('permintaan_barang_tanggal_selesai') : '0000-00-00';
		if ($type != 'update')
		{
			$data['user_request']        	= $this->current_user->id;//$this->input->post('permintaan_barang_user_request');
			$data['status_permintaan']       = 1;
		}
		
		//$data['status_kabag']        	= $this->input->post('permintaan_barang_status_kabag');
		//$atasan = $this->current_user->atasan; 
		$data['id_atasan']        = $atasan;

		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_model->insert($data);

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
			$return = $this->permintaan_barang_model->update($id, $data);
		}

		return $return;
	}
	private function save_verifikasiatasan($status = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['status_atasan']        = $this->input->post('status_atasan');
		$data['catatan_atasan']        = $this->input->post('catatan_atasan');
		if($this->input->post('status_atasan') == "1")
		{
			$data['status_permintaan']        = $status;
		}else{
			$data['status_permintaan']        = "5";
		}
		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_model->insert($data);

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
			$return = $this->permintaan_barang_model->update($id, $data);
		}

		return $return;
	}
	
	private function save_verifikasikb($status = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['status_kabag']        = $this->input->post('status_kabag');
		$data['catatan_kpu']        = $this->input->post('catatan_kpu');
		if($this->input->post('status_kabag') == "1")
		{
			$data['status_permintaan']        = $status;
		}
		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_model->insert($data);

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
			$return = $this->permintaan_barang_model->update($id, $data);
		}

		return $return;
	}
	private function save_persediaan($status = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['status_permintaan']        = $status;
		$data['persediaan_warna']        = "";
		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_model->insert($data);

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
			$return = $this->permintaan_barang_model->update($id, $data);
		}

		return $return;
	}
	private function save_detil_permintaan_barang($uploadData=false,$id_permintaan = "",$nama = "", $spek = "",$jumlahbarang = "",$satuan = "",$harga = "",$jumlah = "",$mark = "",$nomordetil = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['id_permintaan']      = $id_permintaan;
		$data['nama_barang']        = $nama;
		$data['spek_barang']        = $spek;
		$data['jumlah_barang']      = $jumlahbarang != "" ? (int)$jumlahbarang : 0;
		$data['satuan']        		= $satuan;
		$data['harga_barang']       = $harga != "" ? (int)$harga : 0;
		$data['jumlah_all']       	= $jumlah != "" ? (int)$jumlah : 0;
		$data['mark']       		= $mark;
		$data['nomor_detil']       	= $nomordetil;
		if ($uploadData !== false && is_array($uploadData) && count($uploadData) > 0)
		{
			if (!isset($uploadData['error']) && empty($uploadData['error']))
			{
				//die("masuk");
				//die($uploadData['data']['file_name']);
				$data = $data + array('file_name'=>$uploadData['data']['file_name']);
			}
			
		} 
		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_detil_model->insert($data);

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
			$return = $this->permintaan_barang_detil_model->update($id, $data);
		}

		return $return;
	}
	private function update_detil_permintaan_barang($jumlahbarangada = "",$stat = "",$harga = "",$jumlah = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		if($jumlahbarangada != "")
		$data['jumlah_barang_ada']      = $jumlahbarangada;
		$data['status_barang']      	= $stat;// 3 adalah status di pengadaan
		if($harga != "")
			$data['harga_barang']       = $harga != "" ? (int)$harga : 0;
		if($jumlah!= "")
			$data['jumlah_all']       	= $jumlah != "" ? (int)$jumlah : 0;
		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_detil_model->insert($data);

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
			$return = $this->permintaan_barang_detil_model->update($id, $data);
		}

		return $return;
	}
	private function edit_detil_barang_topengadaan($jumlahbarang = "",$stat = "",$statpengadaan = "",$stat_baca = "",$tglpengadaan="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		// make sure we only pass in the fields we want
		$data = array();
		if($jumlahbarang != "")
			$data['jml_barang_pengadaan']      	= $jumlahbarang;
		if($stat != "")
			$data['status_barang']      		= $stat;// 3 adalah status di pengadaan
		//if($statpengadaan != "")	
			$data['status_pengadaan']      		= $statpengadaan != "" ?  $statpengadaan : 0;// 3 adalah status di pengadaan
			$data['stat_baca']      			= $stat_baca != "" ?  $stat_baca : 0;// 3 adalah status di pengadaan
		if($tglpengadaan != "")
		$data['tgl_kirim_pengadaan']      		= $tglpengadaan != "" ?  $tglpengadaan : "0000-00-00";// 3 adalah status di pengadaan
		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_detil_model->insert($data);
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
			$return = $this->permintaan_barang_detil_model->update($id, $data);
		}

		return $return;
	}
	private function save_ppk($jumlahbarang = "",$stat = "",$status_ppk = "",$stat_baca = "",$tglpengadaan="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
			// make sure we only pass in the fields we want
		$this->form_validation->set_rules('jumlah','Jumlah','required|max_length[10]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		// make sure we only pass in the fields we want
		$data = array();
		if($jumlahbarang != "")
			$data['jml_barang_pengadaan']      	= $jumlahbarang;
		if($stat != "")
			$data['status_barang']      		= $stat;// 4 adalah status di pengadaan
		//if($statpengadaan != "")	
			$data['status_ppk']      		= $status_ppk != "" ?  $status_ppk : 0;// 3 adalah status di pengadaan
			$data['stat_baca']      			= $stat_baca != "" ?  $stat_baca : 0;// 3 adalah status di pengadaan
		if($tglpengadaan != "")
		$data['tgl_kirim_pengadaan']      		= $tglpengadaan != "" ?  $tglpengadaan : "0000-00-00";// 3 adalah status di pengadaan
		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_detil_model->insert($data);
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
			$return = $this->permintaan_barang_detil_model->update($id, $data);
		}

		return $return;
	}
	private function save_pengadaan($jumlahbarang = "",$stat = "",$statpengadaan = "",$stat_baca = "",$tglpengadaan="",$catatan_ppk = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
			// make sure we only pass in the fields we want
		//$this->form_validation->set_rules('jumlah','Jumlah','required|max_length[10]');
		///if ($this->form_validation->run() === FALSE)
		//{
			//return FALSE;
		//}
		
		// make sure we only pass in the fields we want
		$data = array();
		if($jumlahbarang != "")
			$data['jml_barang_pengadaan']      	= $jumlahbarang;
		if($stat != "")
			$data['status_barang']      		= $stat;// 3 adalah status di pengadaan
		//if($statpengadaan != "")	
			$data['status_pengadaan']      		= $statpengadaan != "" ?  $statpengadaan : 0;// 3 adalah status di pengadaan
			$data['stat_baca']      			= $stat_baca != "" ?  $stat_baca : 0;// 3 adalah status di pengadaan
		if($tglpengadaan != "")
		$data['tgl_kirim_pengadaan']      		= $tglpengadaan != "" ?  $tglpengadaan : "0000-00-00";// 3 adalah status di pengadaan
		$data['catatan_ppk']      		= $catatan_ppk; 
		if ($type == 'insert')
		{
			$id = $this->permintaan_barang_detil_model->insert($data);
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
			$return = $this->permintaan_barang_detil_model->update($id, $data);
		}

		return $return;
	}
	private function save_log($kode_permintaan = "",$kode_detil_permintaan = "",$aksi = "",$keterangan = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		$this->log_permintaan_model->skip_validation(true);
		$data = array();
		$data['kode_permintaan']      	= $kode_permintaan;
		$data['kode_detil_permintaan']  = $kode_detil_permintaan;
		$data['aksi']  					= $aksi;
		$data['keterangan']  			= $keterangan;
		$data['user_id']       			= $this->current_user->id;
		$data['tanggal_jam']       		= date("Y-m-d");
		 
		if ($type == 'insert')
		{
			$id = $this->log_permintaan_model->insert($data);

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
			$return = $this->log_permintaan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}