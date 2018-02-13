<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * dokumen controller
 */
class dokumen extends Admin_Controller
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

		$this->auth->restrict('Usulan_Perubahan_Dokumen_Eksternal.Dokumen.View');
		$this->load->model('usulan_perubahan_dokumen_eksternal_model', null, true);
		$this->lang->load('usulan_perubahan_dokumen_eksternal');
		$this->load->model('dokumen_eksternal/dokumen_eksternal_model', null, true);
		 	
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'dokumen/_sub_nav');

		Assets::add_module_js('usulan_perubahan_dokumen', 'usulan_perubahan_dokumen.js');
		$indukdokumens = $this->dokumen_eksternal_model->find_all();
		Template::set('indukdokumens', $indukdokumens);
		 
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		//Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
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
					$result = $this->usulan_perubahan_dokumen_eksternal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('usulan_perubahan_dokumen_eksternal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('usulan_perubahan_dokumen_eksternal_delete_failure') . $this->usulan_perubahan_dokumen_eksternal_model->error, 'error');
				}
			}
		}
		$this->load->library('pagination');
		$keyword 	= $this->input->get('keyword');
		$bidang 	= $this->input->get('bidang');
		$jenis_dokumen 	= $this->input->get('jenis_dokumen');
		 
		
		// jika admin maka tampilkan semua data
		if($this->current_user->role_id != "1")
			$this->usulan_perubahan_dokumen_eksternal_model->where('pengusul',$this->current_user->id);
		$total = count($this->usulan_perubahan_dokumen_eksternal_model->find_all($keyword,$bidang,$jenis_dokumen));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		if($this->current_user->role_id != "1")
			$this->usulan_perubahan_dokumen_eksternal_model->where('pengusul',$this->current_user->id);
		$records = $this->usulan_perubahan_dokumen_eksternal_model->limit($limit, $offset)->find_all($keyword,$bidang,$jenis_dokumen); 
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('records', $records);
		Template::set('bidang', $bidang);
		Template::set('jenis_dokumen', $jenis_dokumen);
		
		Template::set('filter_type', "all");
		Template::set('action', "edit");
		  
		Template::set('toolbar_title', 'Kelola Usulan Perubahan Dokumen');
		Template::render();
	}
	public function list_periksa()
	{
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		//Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
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
					$result = $this->usulan_perubahan_dokumen_eksternal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('usulan_perubahan_dokumen_eksternal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('usulan_perubahan_dokumen_eksternal_delete_failure') . $this->usulan_perubahan_dokumen_eksternal_model->error, 'error');
				}
			}
		}
		$this->load->library('pagination');
		$keyword 	= $this->input->get('keyword');
		$bidang 	= $this->input->get('bidang');
		$jenis_dokumen 	= $this->input->get('jenis_dokumen');
		// jika bukan admin diset hanya user tersebut yang melihat Pemeriksaannya sendiri
		if($this->current_user->role_id != "1"){
			$this->usulan_perubahan_dokumen_eksternal_model->where('usulan_perubahan_dokumen_eks.pemeriksa',$this->current_user->id);
		}	
		$total = count($this->usulan_perubahan_dokumen_eksternal_model->find_all($keyword,$bidang,$jenis_dokumen));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		if($this->current_user->role_id != "1")
			$this->usulan_perubahan_dokumen_eksternal_model->where('usulan_perubahan_dokumen_eks.pemeriksa',$this->current_user->id);
		$records = $this->usulan_perubahan_dokumen_eksternal_model->limit($limit, $offset)->find_all($keyword,$bidang,$jenis_dokumen); 
		Template::set('records', $records);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
		
		//die($bidang);
		Template::set('total', $total);
		Template::set('bidang', $bidang);
		Template::set('jenis_dokumen', $jenis_dokumen);
		
		Template::set('filter_type', "periksa");
		Template::set('action', "periksa");
		Template::set('toolbar_title', 'Manage Usulan Perubahan Dokumen (Verifikasi)');
		Template::set_view('dokumen/index');
		Template::render();
	}
	public function list_pengesahan()
	{
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		//Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
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
					$result = $this->usulan_perubahan_dokumen_eksternal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('usulan_perubahan_dokumen_eksternal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('_delete_failure') . $this->usulan_perubahan_dokumen_eksternal_model->error, 'error');
				}
			}
		}
		$this->load->library('pagination');
		$keyword 	= $this->input->get('keyword');
		$bidang 	= $this->input->get('bidang');
		$jenis_dokumen 	= $this->input->get('jenis_dokumen');
		
		if($this->current_user->role_id != "1")
			$this->usulan_perubahan_dokumen_eksternal_model->where('penyetuju',$this->current_user->id);
		$this->usulan_perubahan_dokumen_eksternal_model->where('status_periksa',"1");
		$total = count($this->usulan_perubahan_dokumen_eksternal_model->find_all($keyword,$bidang,$jenis_dokumen));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		if($this->current_user->role_id != "1")
			$this->usulan_perubahan_dokumen_eksternal_model->where('penyetuju',$this->current_user->id);
		$this->usulan_perubahan_dokumen_eksternal_model->where('status_periksa',"1");
		$records = $this->usulan_perubahan_dokumen_eksternal_model->limit($limit, $offset)->find_all($keyword,$bidang,$jenis_dokumen); 
		Template::set('records', $records);
		
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
		
		//die($bidang);
		Template::set('total', $total);
		Template::set('bidang', $bidang);
		Template::set('jenis_dokumen', $jenis_dokumen);
		
		Template::set('filter_type', "pengesahan");
		Template::set('action', "pengesahan");
		  
		Template::set('toolbar_title', 'Manage Usulan Perubahan Dokumen (Pengesahan)');
		Template::set_view('dokumen/index');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Usulan Perubahan Dokumen object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Usulan_Perubahan_Dokumen_Eksternal.Dokumen.Create');
		
		Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (isset($_POST['save']))
		{
			
			$this->load->helper('handle_upload');
			
			$uploadData = array();
			$upload = true; 
			if (isset($_FILES['file_upload']) && is_array($_FILES['file_upload']) && $_FILES['file_upload']['error'] != 4)
			{
				//die($this->settings_lib->item('site.pathphoto'));
				$uploadData = handle_upload('file_upload',$this->settings_lib->item('site.pathuploaded'));
				//print_r($uploadData);
				if (isset($uploadData['error']) && !empty($uploadData['error']))
				{
					$upload = false;
				}
			} 
			//set pemeriksa 
			$detilindukdokumen = $this->dokumen_eksternal_model->find($this->input->post('usulan_perubahan_dokumen_kode_dokumen'));
			//$jenis_doc = $detilindukdokumen->jenis_dokumen; 	
			 
			$pemeriksa = "";
			$pengesah = "";
			  
				
				$this->load->model('user/user_model', null, true);
				$this->user_model->where('users.role_id',"7");
				$users = $this->user_model->find_all();
				if(isset($users) && is_array($users) && count($users)){
					foreach ($users as $recorduser) :
						$pemeriksa = $recorduser->id;
					endforeach;
				}
			 
			 
			if ($insert_id = $this->save_usulan_perubahan_dokumen($uploadData,$pemeriksa,""))
			{
				//kirim email
				$email = "";
				$user = $this->user_model->find($pemeriksa);
				if (isset($user))
				{
					if(isset($user->email))
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Usulan Perubahan Dokumen Eksternal";
				$isi        	= "Anda Perlu memeriksa usulan Perubahan dokumen Eksternal dari ".$this->current_user->display_name;
				
				$this->load->library('emailer/emailer');
				$dataemail = array (
					'subject'	=> $subjek,
					'message'	=> $isi,
				);
				$success_count = 0;
				$resultmail = FALSE;
				 
				$dataemail['to'] = $email;
				$resultmail = $this->emailer->send($dataemail,true);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
			 
				if ($resultmail)
				{
					log_activity($this->current_user->id, 'Sending email to sender from Usulan Dokumen, ID : ' . $insert_id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
				}else{
					log_activity($this->current_user->id, ' Sending email to sender from Usulan Dokumen Failed, ID : ' . $insert_id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
				}
				
				// Log the activity
				log_activity($this->current_user->id, ' Save Usulan Perubahan dokumen, ID : '. $insert_id .' : '. $this->input->ip_address(), 'usulan_perubahan_dokumen_eksternal');

				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_create_success'), 'success');
				redirect(SITE_AREA .'/dokumen/usulan_perubahan_dokumen_eksternal');
			}
			else
			{
				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_create_failure') . $this->usulan_perubahan_dokumen_eksternal_model->error, 'error');
			}
		}
		// load Daftar Induk dokumen
			
		Assets::add_module_js('usulan_perubahan_dokumen_eksternal', 'usulan_perubahan_dokumen_eksternal.js');

		Template::set('toolbar_title', lang('usulan_perubahan_dokumen_eksternal_create') . ' Usulan Perubahan Dokumen');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Usulan Perubahan Dokumen data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
			Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('usulan_perubahan_dokumen_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/usulan_perubahan_dokumen');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Usulan_Perubahan_Dokumen_Eksternal.Dokumen.Edit');
			 
			$this->load->helper('handle_upload');
			$uploadData = array();
			$upload = true; 
			if (isset($_FILES['file_upload']) && is_array($_FILES['file_upload']) && $_FILES['file_upload']['error'] != 4)
			{
				//die($this->settings_lib->item('site.pathphoto'));
				$uploadData = handle_upload('file_upload',$this->settings_lib->item('site.pathuploaded'));
				 
				if (isset($uploadData['error']) && !empty($uploadData['error']))
				{
					$upload = false;
				}
				else{
					// Delete file photo jika ada photo baru
					$recordresult = $this->usulan_perubahan_dokumen_eksternal_model->find($id);
					if (isset($recordresult) && isset($recordresult->filename))
					{
						deletefile ($recordresult->filename,$this->settings_lib->item('site.pathuploaded'));
					}
				
				}
			}
			//set pemeriksa 
			$detilindukdokumen = $this->dokumen_eksternal_model->find($this->input->post('usulan_perubahan_dokumen_kode_dokumen'));
			$jenis_doc = $detilindukdokumen->jenis_dokumen; 	
			 
			$pemeriksa = "";
			$pengesah = ""; 
			$this->load->model('user/user_model', null, true);
			$this->user_model->where('users.role_id',"7");
			$users = $this->user_model->find_all();
			if(isset($users) && is_array($users) && count($users)){
				foreach ($users as $recorduser) :
					$pemeriksa = $recorduser->id;
				endforeach;
			}
			 
			if ($this->save_usulan_perubahan_dokumen($uploadData,$pemeriksa,$pengesah,'update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, 'Update Usulan Perubahan Dokumen, ID: '. $id .' : '. $this->input->ip_address(), 'usulan_perubahan_dokumen_eksternal');

				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_edit_failure') . $this->usulan_perubahan_dokumen_eksternal_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Usulan_Perubahan_Dokumen_Eksternal.Dokumen.Delete');

			if ($this->usulan_perubahan_dokumen_eksternal_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_perubahan_dokumen_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_perubahan_dokumen_eksternal');

				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_delete_success'), 'success');

				redirect(SITE_AREA .'/dokumen/usulan_perubahan_dokumen');
			}
			else
			{
				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_delete_failure') . $this->usulan_perubahan_dokumen_eksternal_model->error, 'error');
			}
		}
		Template::set('usulan_perubahan_dokumen_eksternal', $this->usulan_perubahan_dokumen_eksternal_model->find($id));
		Template::set('toolbar_title', lang('usulan_perubahan_dokumen_eksternal_edit') .' Usulan Perubahan Dokumen');
		Template::render();
	}
	public function periksa()
	{
		$id = $this->uri->segment(5);
		Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('usulan_perubahan_dokumen_eksternal_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/usulan_perubahan_dokumen_eksternal');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Usulan_Perubahan_Dokumen_Eksternal.Dokumen.Edit');
			 
			$this->load->helper('handle_upload');
			$uploadData = array();
			$upload = true; 
			 
			//save ke tabel induk dokumen yang baru
			$this->dokumen_eksternal_model->skip_validation(true);
			$dataupdate = array(
				'status_active'     => '0'
			);
			$this->dokumen_eksternal_model->update_where('nomor',$this->input->post('usulan_perubahan_dokumen_nomor'), $dataupdate);
			
			$datadetilindukdokumen = $this->dokumen_eksternal_model->find($this->input->post('usulan_perubahan_dokumen_kode_dokumen'));
			$distribusi = $datadetilindukdokumen->distribusi;
		 
			$datadetil = $this->usulan_perubahan_dokumen_eksternal_model->find($id);
			$judul = $datadetil->judul;
			$nomor = $datadetil->nomor;
			 
			$tanggal_permintaan = $datadetil->tanggal_permintaan;
			$tanggal_diperiksa = $datadetil->tanggal_diperiksa;
			$tanggal_persetujuan = $datadetil->tanggal_persetujuan;
			$pengusul = $datadetil->pengusul;
			$pemeriksa = $datadetil->pemeriksa;
			$penyetuju = $datadetil->penyetuju;
			$filename = $datadetil->filename;
			
			$data = array();
			$data['judul']        = $judul;
			$data['nomor']        = $nomor;
			 
			$data['tanggal_berlaku']        = date("Y-m-d");
			$data['distribusi']        = $distribusi;
			$data['created_date']        = $tanggal_permintaan;
			$data['created_by']        = $this->current_user->id;
			$data['updated_by']        = $this->current_user->id;
			$data['pengusul']        = $pengusul;
			$data['pemeriksa']        = $pemeriksa;
			$data['pengesah']        = $penyetuju;
			//$data['keterangan']        = "";
			$data['filename']        = $filename;
			$data['status_active']        = "1"; 
			$newid = $this->dokumen_eksternal_model->insert($data);
		 
			if ($this->save_usulan_perubahan_dokumen_periksa("",'update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_perubahan_dokumen_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_perubahan_dokumen');

				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_edit_failure') . $this->usulan_perubahan_dokumen_eksternal_model->error, 'error');
			}
		}
		 
		Template::set('usulan_perubahan_dokumen', $this->usulan_perubahan_dokumen_eksternal_model->find($id));
		Template::set('toolbar_title', lang('usulan_perubahan_dokumen_eksternal_edit') .' Usulan Perubahan Dokumen');
		Template::render();
	}
	public function pengesahan()
	{
		$id = $this->uri->segment(5);
		Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('usulan_perubahan_dokumen_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/usulan_perubahan_dokumen');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Usulan_Perubahan_Dokumen_Eksternal.Dokumen.Edit');
			 
			$this->load->helper('handle_upload');
			$uploadData = array();
			$upload = true; 
			  
			if ($this->save_usulan_perubahan_dokumen_pengesahan('update', $id))
			{
				//die($this->input->post('kode_dokumen')." kode");
				// update status dokumen sebelumnya menjadi tidak aktif atau kadaluarsa
				if($this->input->post('usulan_perubahan_dokumen_status_sah')=="1"){
					$this->dokumen_eksternal_model->skip_validation(true);
					$dataupdate = array(
						'status_active'     => '0'
					);
					//$this->dokumen_eksternal_model->update($this->input->post('usulan_perubahan_dokumen_kode_dokumen'), $dataupdate);
					 
					$this->dokumen_eksternal_model->update_where('nomor',$this->input->post('nomor_dok'), $dataupdate);
					
					
					//save ke tabel induk dokumen yang baru
					$datadetilindukdokumen = $this->dokumen_eksternal_model->find($this->input->post('usulan_perubahan_dokumen_kode_dokumen'));
					$distribusi = $datadetilindukdokumen->distribusi;
				 
					$datadetil = $this->usulan_perubahan_dokumen_eksternal_model->find($id);
					$judul = $datadetil->judul;
					$nomor = $datadetil->nomor;
					 
					$tanggal_permintaan = $datadetil->tanggal_permintaan;
					$tanggal_diperiksa = $datadetil->tanggal_diperiksa;
					$tanggal_persetujuan = $datadetil->tanggal_persetujuan;
					$pengusul = $datadetil->pengusul;
					$pemeriksa = $datadetil->pemeriksa;
					$penyetuju = $datadetil->penyetuju;
					$filename = $datadetil->filename;
					
					$data = array();
					$data['judul']        = $judul;
					$data['nomor']        = $nomor;
					 
					$data['tanggal_berlaku']        = date("Y-m-d");
					$data['distribusi']        = $distribusi;
					$data['tanggal_dibuat']        = $tanggal_permintaan;
					$data['tanggal_diperiksa']        = $tanggal_diperiksa;
					$data['tanggal_disetujui']        = $tanggal_persetujuan;
					$data['pembuat']        = $pengusul;
					$data['pemeriksa']        = $pemeriksa;
					$data['pengesah']        = $penyetuju;
					$data['keterangan']        = "";
					$data['filename']        = $filename;
					$data['status_active']        = "1"; 
					$newid = $this->dokumen_eksternal_model->insert($data);
					// end insert data
				}
				
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_perubahan_dokumen_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_perubahan_dokumen');

				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('usulan_perubahan_dokumen_eksternal_edit_failure') . $this->usulan_perubahan_dokumen_eksternal_model->error, 'error');
			}
		}
		 
		Template::set('usulan_perubahan_dokumen', $this->usulan_perubahan_dokumen_eksternal_model->find($id));
		Template::set('toolbar_title', lang('usulan_perubahan_dokumen_eksternal_edit') .' Usulan Perubahan Dokumen');
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
	private function save_usulan_perubahan_dokumen($uploadData=false,$pemeriksa="",$pengesah="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('usulan_perubahan_dokumen_judul','Judul','required|required|max_length[255]');
		$this->form_validation->set_rules('usulan_perubahan_dokumen_nomor','Nomora','required|max_length[20]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		// make sure we only pass in the fields we want
		
		$data = array();
		$data['pengusul']        = $this->current_user->id;
		$data['tanggal_permintaan']        = date("Y-m-d");
		$data['judul']        = $this->input->post('usulan_perubahan_dokumen_judul');
		$data['nomor']        = $this->input->post('usulan_perubahan_dokumen_nomor');
		$data['bagian_diubah']        = $this->input->post('usulan_perubahan_dokumen_bagian_diubah');
		$data['manfaat_perubahan']        = $this->input->post('usulan_perubahan_dokumen_manfaat_perubahan');
		$data['catatan_pemeriksa']        = $this->input->post('usulan_perubahan_dokumen_catatan_pemeriksa');
		$data['tanggal_diusulkan']        = date("Y-m-d");
		$data['pemeriksa']        = $pemeriksa;
		//$data['tanggal_diperiksa']        = $this->input->post('usulan_perubahan_dokumen_tanggal_diperiksa') ? $this->input->post('usulan_perubahan_dokumen_tanggal_diperiksa') : '0000-00-00';
		$data['penyetuju']        = $pengesah;
		//$data['tanggal_persetujuan']        = $this->input->post('usulan_perubahan_dokumen_tanggal_persetujuan') ? $this->input->post('usulan_perubahan_dokumen_tanggal_persetujuan') : '0000-00-00';
		if ($uploadData !== false && is_array($uploadData) && count($uploadData) > 0)
		{
			if (!isset($uploadData['error']) && empty($uploadData['error']))
			{
				//die("masuk");
				$data = $data + array('filename'=>serialize($uploadData['data']));
			}
			
		} 
		if ($type == 'insert')
		{
			$id = $this->usulan_perubahan_dokumen_eksternal_model->insert($data);

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
			$return = $this->usulan_perubahan_dokumen_eksternal_model->update($id, $data);
		}

		return $return;
	}
	private function save_usulan_perubahan_dokumen_periksa($pengesah,$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('usulan_perubahan_dokumen_judul','Judul','required|required|max_length[255]');
		$this->form_validation->set_rules('usulan_perubahan_dokumen_nomor','Nomora','required|max_length[20]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		//$data['pengusul']        = $this->current_user->id;
		//$data['tanggal_permintaan']        = date("Y-m-d");
		//$data['kode_dokumen']        = $this->input->post('usulan_perubahan_dokumen_kode_dokumen');
		//$data['judul']        = $this->input->post('usulan_perubahan_dokumen_judul');
		//$data['nomor']        = $this->input->post('usulan_perubahan_dokumen_nomor');
		//$data['revisi']        = $this->input->post('usulan_perubahan_dokumen_revisi');
		//$data['bagian_diubah']        = $this->input->post('usulan_perubahan_dokumen_bagian_diubah');
		$data['status_periksa']        = $this->input->post('usulan_perubahan_dokumen_status_periksa');
		$data['catatan_pemeriksa']        = $this->input->post('usulan_perubahan_dokumen_catatan_pemeriksa');
		//$data['tanggal_diusulkan']        = date("Y-m-d");
		//$data['pemeriksa']        = $pemeriksa;
		//$data['tanggal_diperiksa']        = $this->input->post('usulan_perubahan_dokumen_tanggal_diperiksa') ? $this->input->post('usulan_perubahan_dokumen_tanggal_diperiksa') : '0000-00-00';
		$data['penyetuju']        = $pengesah;
		$data['tanggal_persetujuan']        = date("Y-m-d");
		 
		if ($type == 'insert')
		{
			$id = $this->usulan_perubahan_dokumen_eksternal_model->insert($data);

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
			$return = $this->usulan_perubahan_dokumen_eksternal_model->update($id, $data);
		}

		return $return;
	}
private function save_usulan_perubahan_dokumen_pengesahan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('usulan_perubahan_dokumen_judul','Judul','required|required|max_length[255]');
		$this->form_validation->set_rules('usulan_perubahan_dokumen_nomor','Nomora','required|max_length[20]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		//$data['pengusul']        = $this->current_user->id;
		//$data['tanggal_permintaan']        = date("Y-m-d");
		//$data['kode_dokumen']        = $this->input->post('usulan_perubahan_dokumen_kode_dokumen');
		//$data['judul']        = $this->input->post('usulan_perubahan_dokumen_judul');
		//$data['nomor']        = $this->input->post('usulan_perubahan_dokumen_nomor');
		//$data['revisi']        = $this->input->post('usulan_perubahan_dokumen_revisi');
		//$data['bagian_diubah']        = $this->input->post('usulan_perubahan_dokumen_bagian_diubah');
		$data['status_sah']        = $this->input->post('usulan_perubahan_dokumen_status_sah');
		$data['catatan_pemeriksa']        = $this->input->post('usulan_perubahan_dokumen_catatan_pemeriksa');
		//$data['tanggal_diusulkan']        = date("Y-m-d");
		//$data['pemeriksa']        = $pemeriksa;
		//$data['tanggal_diperiksa']        = $this->input->post('usulan_perubahan_dokumen_tanggal_diperiksa') ? $this->input->post('usulan_perubahan_dokumen_tanggal_diperiksa') : '0000-00-00';
		//$data['penyetuju']        = $pengesah;
		$data['tanggal_persetujuan']        = date("Y-m-d");
		 
		if ($type == 'insert')
		{
			$id = $this->usulan_perubahan_dokumen_eksternal_model->insert($data);

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
			$return = $this->usulan_perubahan_dokumen_eksternal_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}