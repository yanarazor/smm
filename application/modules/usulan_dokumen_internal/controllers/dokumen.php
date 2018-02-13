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

		$this->auth->restrict('Usulan_Dokumen_Internal.Dokumen.View');
		$this->load->model('usulan_dokumen_internal_model', null, true);
		$this->lang->load('usulan_dokumen_internal');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'dokumen/_sub_nav');

		Assets::add_module_js('usulan_dokumen_internal', 'usulan_dokumen_internal.js');
		$this->load->model('jenis_dokumen/jenis_dokumen_model', null, true);
		$jenis_docs = $this->jenis_dokumen_model->find_all();
		Template::set('jenis_docs', $jenis_docs);
		
		$this->load->model('bidang/bidang_model', null, true);
		$this->load->model('sub_bidang/sub_bidang_model', null, true);
		$this->load->model('user/user_model', null, true);
		
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		//Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');
		$this->load->model('bidang/bidang_model', null, true);
		$bidangs = $this->bidang_model->find_all();
		Template::set('bidangs', $bidangs);
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->usulan_dokumen_internal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('usulan_dokumen_internal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('usulan_dokumen_internal_delete_failure') . $this->usulan_dokumen_internal_model->error, 'error');
				}
			}
		}
		$this->load->library('pagination');
		$keyword 	= $this->input->get('keyword');
		$jenis_dokumen 	= $this->input->get('jenis_dokumen');
		
		if($this->current_user->role_id != "1")
			$this->usulan_dokumen_internal_model->where('pengusul',$this->current_user->id);
		$total = count($this->usulan_dokumen_internal_model->find_all($keyword,$jenis_dokumen));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?keyword='.$keyword.'&jenis_dokumen='.$jenis_dokumen.'';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		if($this->current_user->role_id != "1")
			$this->usulan_dokumen_internal_model->where('pengusul',$this->current_user->id);
		$records = $this->usulan_dokumen_internal_model->limit($limit, $offset)->find_all($keyword,$jenis_dokumen); 
		Template::set('records', $records);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('jenis_dokumen', $jenis_dokumen);
		 
		Template::set('toolbar_title', 'Kelola Usulan Dokumen Internal');
		Template::set('filter_type', "all");
		Template::set('action', "edit");
		Template::render();
	}
	public function list_periksa()
	{
		$this->auth->restrict('Usulan_Dokumen_Internal.Dokumen.pengecekan');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->usulan_dokumen_internal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('usulan_dokumen_internal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('usulan_dokumen_internal_delete_failure') . $this->usulan_dokumen_internal_model->error, 'error');
				}
			}
		}
		$keyword 	= $this->input->get('keyword');
		$jenis_dokumen 	= $this->input->get('jenis_dokumen');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1")
			$this->usulan_dokumen_internal_model->where('usulan_dokumen_internal.pemeriksa',$this->current_user->id);
		 
		$total = count($this->usulan_dokumen_internal_model->find_all($keyword,$jenis_dokumen));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?keyword='.$keyword.'&jenis_dokumen='.$jenis_dokumen.'';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		if($this->current_user->role_id != "1")
			$this->usulan_dokumen_internal_model->where('usulan_dokumen_internal.pemeriksa',$this->current_user->id);
		$records = $this->usulan_dokumen_internal_model->limit($limit, $offset)->find_all($keyword,$jenis_dokumen); 
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('jenis_dokumen', $jenis_dokumen);
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Usulan Dokumen Internal');
		Template::set('filter_type', "periksa");
		Template::set('action', "periksa");
		Template::set_view('dokumen/index');
		Template::render();
	}
	public function list_pengesahan()
	{
		$this->auth->restrict('Usulan_Dokumen_Internal.Dokumen.pengesahan');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->usulan_dokumen_internal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('usulan_dokumen_internal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('usulan_dokumen_internal_delete_failure') . $this->usulan_dokumen_internal_model->error, 'error');
				}
			}
		}

		$this->load->library('pagination');
		$keyword 	= $this->input->get('keyword');
		$jenis_dokumen 	= $this->input->get('jenis_dokumen');
		//if($this->current_user->role_id != "1")
		//	$this->usulan_dokumen_internal_model->where('usulan_dokumen_internal.pengesah',$this->current_user->id);
		$this->usulan_dokumen_internal_model->where('usulan_dokumen_internal.status_periksa',"1");
		$total = count($this->usulan_dokumen_internal_model->find_all($keyword,$jenis_dokumen));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?keyword='.$keyword.'&jenis_dokumen='.$jenis_dokumen.'';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		//if($this->current_user->role_id != "1")
		//	$this->usulan_dokumen_internal_model->where('usulan_dokumen_internal.pengesah',$this->current_user->id);
		
		$this->usulan_dokumen_internal_model->where('usulan_dokumen_internal.status_periksa',"1");
		$records = $this->usulan_dokumen_internal_model->limit($limit, $offset)->find_all($keyword,$jenis_dokumen); 
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('jenis_dokumen', $jenis_dokumen);
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Usulan Dokumen Internal');
		Template::set('filter_type', "pengesahan");
		
		Template::set('action', "pengesahan");
		Template::set_view('dokumen/index');
		 
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Usulan Dokumen Internal object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Usulan_Dokumen_Internal.Dokumen.Create');
		$this->load->model('user/user_model', null, true);
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
			$jenis_doc = $this->input->post('usulan_dokumen_internal_jenis_dokumen');
			$pemeriksa = "";
			$pengesah = ""; 
			$this->load->model('jenis_dokumen/jenis_dokumen_model', null, true);
			$jenisdocrecord 	= $this->jenis_dokumen_model->find($jenis_doc);
			$pemeriksajenis 	= $jenisdocrecord->pemeriksa;
			$pengesahjenis 		= $jenisdocrecord->pengesah;
			if($pemeriksajenis=="9"){
				$bidang 	= $this->current_user->id_bidang; // kabid
				$bidangrecorddetil = $this->bidang_model->find($this->current_user->id_bidang);
				$pemeriksa = $bidangrecorddetil->kabid;
			}
			if($pemeriksajenis=="10"){
				$subbid 	= $this->current_user->id_subbid; // ka subbid
				$subbidangrecorddetil = $this->sub_bidang_model->find($this->current_user->id_subbid);
				$pemeriksa = $subbidangrecorddetil->kasubid;
			}
			if($pemeriksajenis != "10" and $pemeriksajenis != "9"){
			//die($pemeriksajenis);
				$userrecord = $this->user_model->find_by("users.role_id",$pemeriksajenis);
				$pemeriksa = $userrecord->id;
			}
			
			
			if($pengesahjenis!="9" and $pengesahjenis!="10"){
				$userrecord = $this->user_model->find_by("users.role_id",$pengesahjenis);
				$pengesah = $userrecord->id;
			}
			
			
			//die($pemeriksa);
			 
			if ($insert_id = $this->save_usulan_dokumen_internal($uploadData,$pemeriksa,$pengesah))
			{
				 
				$user = $this->user_model->find($pemeriksa);
				if (isset($user))
				{
					$email = $user->email;
				}
				
				//sending mail
				$subjek       		= "Notifikasi Usulan Dokumen";
				$isi        	= "Anda Perlu memeriksa usulan dokumen dari ".$this->current_user->display_name;
				
				$this->load->library('emailer/emailer');
				$dataemail = array (
					'subject'	=> $subjek,
					'message'	=> $isi,
				);
				$success_count = 0;
				$resultmail = FALSE;
				 
				$dataemail['to'] = $email;
				$resultmail = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
			 	if ($resultmail)
				{
					$resultmail = $this->emailer->send($dataemail,true);
				
					log_activity($this->current_user->id, 'Sending email to sender from Usulan Dokumen, ID : ' . $insert_id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
				}else{
					log_activity($this->current_user->id, ' Sending email to sender from Usulan Dokumen Failed, ID : ' . $insert_id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
				}
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_dokumen_internal_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'usulan_dokumen_internal');

				Template::set_message(lang('usulan_dokumen_internal_create_success'), 'success');
				redirect(SITE_AREA .'/dokumen/usulan_dokumen_internal');
			}
			else
			{
				Template::set_message(lang('usulan_dokumen_internal_create_failure') . $this->usulan_dokumen_internal_model->error, 'error');
			}
		}
		Assets::add_module_js('usulan_dokumen_internal', 'usulan_dokumen_internal.js');

		Template::set('toolbar_title', lang('usulan_dokumen_internal_create') . ' Usulan Dokumen Internal');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Usulan Dokumen Internal data.
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
			Template::set_message(lang('usulan_dokumen_internal_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/usulan_dokumen_internal');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Usulan_Dokumen_Internal.Dokumen.Edit');
			 
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
					$recordresult = $this->usulan_dokumen_internal_model->find($id);
					if (isset($recordresult) && isset($recordresult->filename))
					{
						deletefile ($recordresult->filename,$this->settings_lib->item('site.pathuploaded'));
					}
				
				}
			}
			$jenis_doc = $this->input->post('usulan_dokumen_internal_jenis_dokumen');
			$pemeriksa = "";
			$pengesah = ""; 
			$this->load->model('jenis_dokumen/jenis_dokumen_model', null, true);
			$jenisdocrecord = $this->jenis_dokumen_model->find($jenis_doc);
			$pemeriksajenis 	= $jenisdocrecord->pemeriksa;
			$pengesahjenis 	= $jenisdocrecord->pengesah;
			 
			if($pemeriksajenis=="9"){
				$bidang 	= $this->current_user->id_bidang; // kabid
				$bidangrecorddetil = $this->bidang_model->find($this->current_user->id_bidang);
				$pemeriksa = $bidangrecorddetil->kabid;
			}
			if($pemeriksajenis=="10"){
				$subbid 	= $this->current_user->id_subbid; // ka subbid
				$subbidangrecorddetil = $this->sub_bidang_model->find($this->current_user->id_subbid);
				$pemeriksa = $subbidangrecorddetil->kasubid;
			}
			if($pemeriksajenis != "10" and $pemeriksajenis != "9"){
				$userrecord = $this->user_model->find_by("users.role_id",$pemeriksajenis);
				$pemeriksa = $userrecord->id;
			}
			
			if ($this->save_usulan_dokumen_internal($uploadData,$pemeriksa,"",'update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_dokumen_internal_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_dokumen_internal');

				Template::set_message(lang('usulan_dokumen_internal_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('usulan_dokumen_internal_edit_failure') . $this->usulan_dokumen_internal_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Usulan_Dokumen_Internal.Dokumen.Delete');

			if ($this->usulan_dokumen_internal_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_dokumen_internal_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_dokumen_internal');

				Template::set_message(lang('usulan_dokumen_internal_delete_success'), 'success');

				redirect(SITE_AREA .'/dokumen/usulan_dokumen_internal');
			}
			else
			{
				Template::set_message(lang('usulan_dokumen_internal_delete_failure') . $this->usulan_dokumen_internal_model->error, 'error');
			}
		}
		Template::set('usulan_dokumen_internal', $this->usulan_dokumen_internal_model->find($id));
		Template::set('toolbar_title', lang('usulan_dokumen_internal_edit') .' Usulan Dokumen Internal');
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
			Template::set_message(lang('usulan_dokumen_internal_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/usulan_dokumen_internal');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Usulan_Dokumen_Internal.Dokumen.Edit');
			 
			$jenis_doc = $this->input->post('usulan_dokumen_internal_jenis_dokumen');
			$pemeriksa = "";
			$pengesah = ""; 
			$this->load->model('jenis_dokumen/jenis_dokumen_model', null, true);
			$jenisdocrecord = $this->jenis_dokumen_model->find($jenis_doc);
			$pemeriksajenis 	= $jenisdocrecord->pemeriksa;
			$pengesahjenis 	= $jenisdocrecord->pengesah;
			if($pengesahjenis=="9"){
				$bidang 	= $this->current_user->id_bidang; // kabid
				$bidangrecorddetil = $this->bidang_model->find($this->current_user->id_bidang);
				$pengesah = $bidangrecorddetil->kabid;
			}
			if($pengesahjenis=="10"){
				$subbid 	= $this->current_user->id_subbid; // ka subbid
				$subbidangrecorddetil = $this->sub_bidang_model->find($this->current_user->id_subbid);
				$pengesah = $subbidangrecorddetil->kasubid;
			}
			if($pengesahjenis != "10" and $pengesahjenis != "9"){
				$userrecord = $this->user_model->find_by("users.role_id",$pengesahjenis);
				if(isset($userrecord->id))
					$pengesah = $userrecord->id;
				 
			}
			if($this->input->post('usulan_dokumen_internal_status_periksa')=="0")// jika ditolak
			{
				if ($this->save_usulan_dokumen_periksa($pengesah,'update', $id))
					{
						$user = $this->user_model->find($this->input->post('pengusul'));
						if (isset($user))
						{
							$email = $user->email;
						}
						//sending mail
						$subjek       		= "Notifikasi Usulan Dokumen";
						$isi        	= "Mohon Periksa Kembali usulan Dokumen Anda.: ";
					
						$this->load->library('emailer/emailer');
						$dataemail = array (
							'subject'	=> $subjek,
							'message'	=> $isi,
						);
						$success_count = 0;
						$resultmail = FALSE;
					 
						$dataemail['to'] = $email;
						$resultemail = $this->emailer->send($dataemail,true);
						$resultmail = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
					
						if ($resultmail)
						{
							//$resultemail = $this->emailer->send($dataemail,true);
							log_activity($this->current_user->id, 'Sending email to sender from Usulan Dokumen, ID : ' . $id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
						}else{
							log_activity($this->current_user->id, ' Sending email to sender from Usulan Dokumen Failed, ID : ' . $id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
						}
						// Log the activity
						log_activity($this->current_user->id, lang('usulan_dokumen_internal_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_dokumen_internal');

						Template::set_message(lang('usulan_dokumen_internal_edit_success'), 'success');
					}
					else
					{
						Template::set_message(lang('usulan_dokumen_internal_edit_failure') . $this->usulan_dokumen_internal_model->error, 'error');
					}
				
			}
			if($this->input->post('usulan_dokumen_internal_status_periksa')=="1") // jika diterima
			{
				if($pengesah != "")
				{
					if ($this->save_usulan_dokumen_periksa($pengesah,'update', $id))
					{
						// kirim email ke pengusul
						//sending mail
						$user = $this->user_model->find($this->input->post('pengusul'));
						if (isset($user))
						{
							$emailpengusul = $user->email;
						}
						$subjek       		= "Notifikasi Usulan Dokumen";
						$isi        	= "Usulan Dokumen Anda sudah diverifikasi";
					
						$this->load->library('emailer/emailer');
						$dataemail = array (
							'subject'	=> $subjek,
							'message'	=> $isi,
						);
						$resultmail = FALSE;
					 	$dataemail['to'] = $emailpengusul;
						$resultmail = $this->emailer->send($dataemail,false);
						//
						
						$user = $this->user_model->find($pengesah);
						if (isset($user))
						{
							$email = $user->email;
						}
						//sending mail
						$subjek       		= "Notifikasi Usulan Dokumen";
						$isi        	= "Anda Perlu memeriksa usulan dokumen yang telah di verifikasi oleh: ".$this->current_user->display_name;
					
						$this->load->library('emailer/emailer');
						$dataemail = array (
							'subject'	=> $subjek,
							'message'	=> $isi,
						);
						$success_count = 0;
						$resultmail = FALSE;
					 
						$dataemail['to'] = $email;
						$resultmail = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
					
						if ($resultmail)
						{
							$resultemail = $this->emailer->send($dataemail,true);
							log_activity($this->current_user->id, 'Sending email to sender from Usulan Dokumen, ID : ' . $id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
						}else{
							log_activity($this->current_user->id, ' Sending email to sender from Usulan Dokumen Failed, ID : ' . $id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
						}
						// Log the activity
						log_activity($this->current_user->id, lang('usulan_dokumen_internal_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_dokumen_internal');

						Template::set_message(lang('usulan_dokumen_internal_edit_success'), 'success');
					}
					else
					{
						Template::set_message(lang('usulan_dokumen_internal_edit_failure') . $this->usulan_dokumen_internal_model->error, 'error');
					}
				}else{
						Template::set_message("Pengesah Untuk Dokumen ini belum di Tentukan..", 'error');
				}
			
			}
			
		}
		 
		Template::set('usulan_dokumen_internal', $this->usulan_dokumen_internal_model->find($id));
		Template::set('toolbar_title', lang('usulan_dokumen_internal_edit') .' Usulan Dokumen Internal');
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
			Template::set_message(lang('usulan_dokumen_internal_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/usulan_dokumen_internal');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Usulan_Dokumen_Internal.Dokumen.Edit'); 
			$this->load->model('daftar_induk_dokumen/daftar_induk_dokumen_model', null, true);
			
			$datadetil = $this->usulan_dokumen_internal_model->find($id);
			$judul = $datadetil->judul;
			$nomor = $datadetil->nomor;
			 
			$pembuat = $datadetil->pengusul;
			$pemeriksa = $datadetil->pemeriksa;
			$pengesah = $datadetil->pengesah;
			$jenis_dokumen = $datadetil->jenis_dokumen;
			$id_bidang = $datadetil->id_bidang;
			$keterangan = "";
			$filename = $datadetil->filename;
			$isiemail ="";
			if ($this->save_usulan_dokumen_sah('update', $id))
			{
				$datadetil = $this->usulan_dokumen_internal_model->find($id);
				if($this->input->post('usulan_dokumen_internal_status_sah')=="1")
				{
					 
					$isexist = $this->daftar_induk_dokumen_model->cekexist($id);
					if($isexist>0){
						Template::set_message("Dokumen Sudah Terdaftar Pada Daftar Induk Dokumen", 'error');
					}else{
						 
						$kodedaftarinduk = $this->save_daftar_induk_dokumen($judul,$nomor,$pembuat,$pemeriksa,$pengesah,$jenis_dokumen,$keterangan,$filename,$id_bidang);
						Template::set_message("Dokumen Telah di Masukan Pada Daftar Induk Dokumen..", 'success');
						$isiemail = "Usulan Dokumen dengan Judul <b>'".$judul."'</b> Telah disahkan dan sudah masuk pada daftar induk dokumen";
					}
				}
				if($this->input->post('usulan_dokumen_internal_status_sah')=="0")
				{
					Template::set_message("Dokumen Ditolak...", 'success');
					$isiemail = "Usulan Dokumen dengan Judul <b>'".$judul."'</b> Telah Ditolak";
				}
				
				// kirim email notifikasi ke pengusul dan verifikator
					$user = $this->user_model->find($pembuat);
					if (isset($user))
					{
						$email = $user->email;
					}
					//sending mail
					$subjek       		= "Pengesahan Usulan Dokumen";
					$isi        	= $isiemail;
					
					$this->load->library('emailer/emailer');
					$dataemail = array (
						'subject'	=> $subjek,
						'message'	=> $isi,
					);
					$success_count = 0;
					$resultmail = FALSE;
					 
					$dataemail['to'] = $email;
					$resultmail = $this->emailer->send($dataemail,true);
				 
					if ($resultmail)
					{
						log_activity($this->current_user->id, 'Sending email to sender from Usulan Dokumen, ID : ' . $id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
					}else{
						log_activity($this->current_user->id, ' Sending email to sender from Usulan Dokumen Failed, ID : ' . $id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
					}
				// end kirim email
				
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_dokumen_internal_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_dokumen_internal');
				
				
			}
			else
			{
				Template::set_message(lang('usulan_dokumen_internal_edit_failure') . $this->usulan_dokumen_internal_model->error, 'error');
			}
		}
		 
		Template::set('usulan_dokumen_internal', $this->usulan_dokumen_internal_model->find($id));
		Template::set('toolbar_title', lang('usulan_dokumen_internal_edit') .' Usulan Dokumen Internal');
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
	private function save_usulan_dokumen_internal($uploadData,$pemeriksa,$pengesah,$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		$jenis_doc = $this->input->post('usulan_dokumen_internal_jenis_dokumen');
		 
		$data = array();
		$data['judul']        	= $this->input->post('usulan_dokumen_internal_judul');
		$data['nomor']        	= $this->input->post('usulan_dokumen_internal_nomor');
		$data['pengusul']       = $this->current_user->id;
		$data['pemeriksa']      = $pemeriksa;
		$data['id_bidang']        = $this->input->post('usulan_dokumen_internal_bidang');
		if ($type != 'update')
		{
			$data['catatan_periksa']        = "";
		}
		$data['pengesah']       = $pengesah;
		//$data['catatan_pengesah']        = $this->input->post('usulan_dokumen_internal_catatan_pengesah');
		//$data['status_sah']        = $this->input->post('usulan_dokumen_internal_status_sah');
		$data['jenis_dokumen']        = $jenis_doc;
		$data['tanggal_pengusulan']        = date("Y-m-d");
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
			$id = $this->usulan_dokumen_internal_model->insert($data);

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
			$return = $this->usulan_dokumen_internal_model->update($id, $data);
		}

		return $return;
	}
	private function save_usulan_dokumen_periksa($pengesah,$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		$jenis_doc = $this->input->post('usulan_dokumen_internal_jenis_dokumen');
		 
		$data = array();
		//$data['judul']        	= $this->input->post('usulan_dokumen_internal_judul');
		//$data['nomor']        	= $this->input->post('usulan_dokumen_internal_nomor');
		//$data['pengusul']       = $this->current_user->id;
		//$data['pemeriksa']      = $pemeriksa;
		$data['status_periksa']        = $this->input->post('usulan_dokumen_internal_status_periksa');
		$data['catatan_periksa']        = $this->input->post('usulan_dokumen_internal_catatan_periksa');
		$data['pengesah']       = $pengesah;
		//$data['catatan_pengesah']        = $this->input->post('usulan_dokumen_internal_catatan_pengesah');
		//$data['status_sah']        = $this->input->post('usulan_dokumen_internal_status_sah');
		//$data['jenis_dokumen']        = $jenis_doc;
		//$data['tanggal_pengusulan']        = date("Y-m-d");
		 
		if ($type == 'insert')
		{
			$id = $this->usulan_dokumen_internal_model->insert($data);

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
			$return = $this->usulan_dokumen_internal_model->update($id, $data);
		}

		return $return;
	}
	private function save_usulan_dokumen_sah($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		//$jenis_doc = $this->input->post('usulan_dokumen_internal_jenis_dokumen');
		 
		$data = array();
		//$data['judul']        	= $this->input->post('usulan_dokumen_internal_judul');
		//$data['nomor']        	= $this->input->post('usulan_dokumen_internal_nomor');
		//$data['pengusul']       = $this->current_user->id;
		//$data['pemeriksa']      = $pemeriksa;
		//$data['status_periksa']        = $this->input->post('usulan_dokumen_internal_status_periksa');
		//$data['catatan_periksa']        = $this->input->post('usulan_dokumen_internal_catatan_periksa');
		//$data['pengesah']       = $pengesah;
		$data['catatan_pengesah']        = $this->input->post('usulan_dokumen_internal_catatan_pengesah');
		$data['status_sah']        = $this->input->post('usulan_dokumen_internal_status_sah');
		//$data['jenis_dokumen']        = $jenis_doc;
		//$data['tanggal_pengusulan']        = date("Y-m-d");
		 
		if ($type == 'insert')
		{
			$id = $this->usulan_dokumen_internal_model->insert($data);

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
			$return = $this->usulan_dokumen_internal_model->update($id, $data);
		}

		return $return;
	}
	private function save_daftar_induk_dokumen($judul="",$nomor="",$pembuat="",$pemeriksa="",$pengesah="",$jenis_dokumen="",$keterangan="",$file_name="",$bidang="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		// make sure we only pass in the fields we want
		$this->daftar_induk_dokumen_model->skip_validation(true);
		$data = array();
		$data['judul']        = $judul;
		$data['nomor']        = $nomor;
		$data['revisi']        = "0";
		$data['tanggal_berlaku']        = date("Y-m-d");
		//$data['tanggal_dibuat']        = $this->input->post('daftar_induk_dokumen_tanggal_dibuat') ? $this->input->post('daftar_induk_dokumen_tanggal_dibuat') : '0000-00-00';
		$data['bidang']        = $bidang;
		$data['tanggal_disetujui']        = date("Y-m-d");
		$data['pembuat']        = $pembuat;
		$data['pemeriksa']        = $pemeriksa;
		$data['pengesah']        = $pengesah;
		$data['jenis_dokumen']        = $jenis_dokumen;
		$data['keterangan']        = $keterangan;
		$data['filename']        = $file_name;
		$data['status_active']        = "1";
		 
		if ($type == 'insert')
		{
			$id = $this->daftar_induk_dokumen_model->insert($data);

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
			$return = $this->daftar_induk_dokumen_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}