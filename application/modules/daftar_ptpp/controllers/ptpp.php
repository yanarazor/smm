<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ptpp controller
 */
class ptpp extends Admin_Controller
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

		$this->auth->restrict('Daftar_ptpp.Ptpp.View');
		$this->load->model('daftar_ptpp_model', null, true);
		$this->lang->load('daftar_ptpp');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'ptpp/_sub_nav');

		Assets::add_module_js('daftar_ptpp', 'daftar_ptpp.js');
		$this->load->model('status_ptpp/status_ptpp_model');
		$status = $this->status_ptpp_model->find_all();
		Template::set('statuss', $status);
		$this->load->model('user/user_model', null, true);
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		
		$this->load->model('kategori_ptpp/kategori_ptpp_model');
		$kategoris = $this->kategori_ptpp_model->find_all();
		Template::set('kategoris', $kategoris);
		
		$this->load->model('bidang/bidang_model', null, true);
		$bidangs = $this->bidang_model->find_all();
		Template::set('bidangs', $bidangs);
		
		$this->load->model('audit_internal/audit_internal_model', null, true);
		$audits = $this->audit_internal_model->find_all();
		Template::set('audits', $audits);
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$mode = $this->input->get('mode');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->daftar_ptpp_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('daftar_ptpp_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('daftar_ptpp_delete_failure') . $this->daftar_ptpp_model->error, 'error');
				}
			}
		}
		
		$checklist = $this->input->get('checklist');
		$status = $this->input->get('status');
		$bid = $this->input->get('bid');
		$audit = $this->input->get('audit');
		$this->load->library('pagination');
		//if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8")
		//	$this->daftar_ptpp_model->where('diajukan_oleh',$this->current_user->id);
		$total = count($this->daftar_ptpp_model->find_all($status,$checklist,$bid,$audit));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?status='.$status.'&bid='.$bid.'&audit='.$audit.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		//if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8")
		//	$this->daftar_ptpp_model->where('diajukan_oleh',$this->current_user->id);
		$records = $this->daftar_ptpp_model->limit($limit, $offset)->find_all($status,$checklist,$bid,$audit);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
		
		Template::set('link', "daftar_ptppprint/?mode=print");
		Template::set('total', $total);
		Template::set('bid', $bid);
		Template::set('status_ptpp', $status);
		Template::set('records', $records);
		Template::set('audit', $audit);
		Template::set('filter_type', "all");
		Template::set('action', "edit");
		Template::set('toolbar_title', 'Usulan PKTP');
		Template::render();
	}
	public function daftar_ptppprint()
	{
		$mode = $this->input->get('mode');
		// Deleting anything?
		 
		
		$checklist = $this->input->get('checklist');
		$status = $this->input->get('status');
		$bid = $this->input->get('bid');
		$audit = $this->input->get('audit');
		$this->load->library('pagination');
		//if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8")
		//	$this->daftar_ptpp_model->where('diajukan_oleh',$this->current_user->id);
		 
		//if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8")
		//	$this->daftar_ptpp_model->where('diajukan_oleh',$this->current_user->id);
		$records = $this->daftar_ptpp_model->find_all($status,$checklist,$bid,$audit);
		 

		if($mode == "print"){
			Template::set_theme('print');
		}
			
		Template::set('bid', $bid);
		Template::set('status_ptpp', $status);
		Template::set('records', $records);
		Template::set('audit', $audit);
		Template::set('filter_type', "all");
		Template::set('action', "edit");
		Template::set('toolbar_title', 'Usulan PKTP');
		Template::render();
	}
	
	public function list_periksa()
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
					$result = $this->daftar_ptpp_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('daftar_ptpp_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('daftar_ptpp_delete_failure') . $this->daftar_ptpp_model->error, 'error');
				}
			}
		}
		$checklist = $this->input->get('checklist');
		$status = $this->input->get('status');
		$bid = $this->input->get('bid');
		$audit = $this->input->get('audit');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8")
			$this->daftar_ptpp_model->where('daftar_ptpp.id_bidang',$this->current_user->id_bidang);
		$total = count($this->daftar_ptpp_model->find_all($status,$checklist,$bid,$audit));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?status='.$status.'&bid='.$bid.'&audit='.$audit.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8")
			$this->daftar_ptpp_model->where('daftar_ptpp.id_bidang',$this->current_user->id_bidang);
		$records = $this->daftar_ptpp_model->limit($limit, $offset)->find_all($status,$checklist,$bid,$audit);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";

		Template::set('link', "listperiksaprint/?mode=print");
		Template::set('bid', $bid);
		Template::set('total', $total);
		Template::set('status_ptpp', $status);
		Template::set('records', $records);
		Template::set('audit', $audit);
		Template::set('filter_type', "periksa");
		Template::set('action', "periksa");
		Template::set('toolbar_title', 'List Usulan PKTP (Pemeriksa)');
		Template::set_view('ptpp/index');
		Template::render();
	}
	public function listperiksaprint()
	{
		 
		 
		$checklist = $this->input->get('checklist');
		$status = $this->input->get('status');
		$bid = $this->input->get('bid');
		$audit = $this->input->get('audit');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8")
			$this->daftar_ptpp_model->where('daftar_ptpp.id_bidang',$this->current_user->id_bidang);
		$total = count($this->daftar_ptpp_model->find_all($status,$checklist,$bid,$audit));
		 
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8")
			$this->daftar_ptpp_model->where('daftar_ptpp.id_bidang',$this->current_user->id_bidang);
		$records = $this->daftar_ptpp_model->find_all($status,$checklist,$bid,$audit);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";

		Template::set('link', "listperiksaprint/?mode=print");
		Template::set_view('ptpp/daftar_ptppprint');
		Template::set_theme('print');
		Template::set('bid', $bid);
		Template::set('total', $total);
		Template::set('status_ptpp', $status);
		Template::set('records', $records);
		Template::set('audit', $audit);
		Template::set('filter_type', "periksa");
		Template::set('action', "periksa");
		Template::set('toolbar_title', 'List Usulan PKTP (Pemeriksa)');

		Template::render();
	}
	public function list_penyelesaian()
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
					$result = $this->daftar_ptpp_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('daftar_ptpp_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('daftar_ptpp_delete_failure') . $this->daftar_ptpp_model->error, 'error');
				}
			}
		}
		$checklist = $this->input->get('checklist');
		$status = $this->input->get('status');
		$bid = $this->input->get('bid');
		$audit = $this->input->get('audit');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8" and $this->current_user->role_id != "11")
			$this->daftar_ptpp_model->where('daftar_ptpp.id_bidang',$this->current_user->id_bidang);
		if($this->current_user->role_id == "9")
			$this->daftar_ptpp_model->where('status_persetujuan',"1");
		//if($this->current_user->role_id == "7")
			//$this->daftar_ptpp_model->or_where('persetujuan',"1");
		if($this->current_user->role_id == "11"){
			//$this->daftar_ptpp_model->or_where('daftar_ptpp.kategori != ""');
			$this->daftar_ptpp_model->where('diajukan_oleh',$this->current_user->id);
		}
		$total = count($this->daftar_ptpp_model->find_all($status,$checklist,$bid,$audit));
		
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?status='.$status.'&bid='.$bid.'&audit='.$audit.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8" and $this->current_user->role_id != "11")
			$this->daftar_ptpp_model->where('daftar_ptpp.id_bidang',$this->current_user->id_bidang);
		if($this->current_user->role_id == "9")
			$this->daftar_ptpp_model->where('status_persetujuan',"1");
		//if($this->current_user->role_id == "7")
		//	$this->daftar_ptpp_model->or_where('persetujuan',"1");
		if($this->current_user->role_id == "11"){
			//$this->daftar_ptpp_model->or_where('daftar_ptpp.kategori != ""');
			$this->daftar_ptpp_model->where('diajukan_oleh',$this->current_user->id);
		}
		$records = $this->daftar_ptpp_model->limit($limit, $offset)->find_all($status,$checklist,$bid,$audit);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
		
		Template::set('link', "penyelesaianprint/?mode=print");
		 
		Template::set('bid', $bid);
		Template::set('total', $total);
		Template::set('audit', $audit);
		Template::set('status_ptpp', $status);
		//die($status);
		Template::set('records', $records);
		Template::set('filter_type', "penyelesaian");
		Template::set('action', "penyelesaian");
		Template::set('toolbar_title', 'List Usulan PKTP (Penyelesaian)');
		Template::set_view('ptpp/index');
		Template::render();
	}
	public function penyelesaianprint()
	{
		 
		 
		$checklist = $this->input->get('checklist');
		$status = $this->input->get('status');
		$bid = $this->input->get('bid');
		$audit = $this->input->get('audit');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8" and $this->current_user->role_id != "11")
			$this->daftar_ptpp_model->where('daftar_ptpp.id_bidang',$this->current_user->id_bidang);
		if($this->current_user->role_id == "9")
			$this->daftar_ptpp_model->where('status_persetujuan',"1");
		//if($this->current_user->role_id == "7")
			//$this->daftar_ptpp_model->or_where('persetujuan',"1");
		if($this->current_user->role_id == "11"){
			//$this->daftar_ptpp_model->or_where('daftar_ptpp.kategori != ""');
			$this->daftar_ptpp_model->where('diajukan_oleh',$this->current_user->id);
		}
		$total = count($this->daftar_ptpp_model->find_all($status,$checklist,$bid,$audit));
		
		 
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "7" and $this->current_user->role_id != "8" and $this->current_user->role_id != "11")
			$this->daftar_ptpp_model->where('daftar_ptpp.id_bidang',$this->current_user->id_bidang);
		if($this->current_user->role_id == "9")
			$this->daftar_ptpp_model->where('status_persetujuan',"1");
		//if($this->current_user->role_id == "7")
		//	$this->daftar_ptpp_model->or_where('persetujuan',"1");
		if($this->current_user->role_id == "11"){
			//$this->daftar_ptpp_model->or_where('daftar_ptpp.kategori != ""');
			$this->daftar_ptpp_model->where('diajukan_oleh',$this->current_user->id);
		}
		$records = $this->daftar_ptpp_model->find_all($status,$checklist,$bid,$audit);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
		
		Template::set('link', "penyelesaianprint/?mode=print");
		Template::set_view('ptpp/daftar_ptppprint');
		Template::set_theme('print');

		Template::set('bid', $bid);
		Template::set('total', $total);
		Template::set('audit', $audit);
		Template::set('status_ptpp', $status);
		//die($status);
		Template::set('records', $records);
		Template::set('filter_type', "penyelesaian");
		Template::set('action', "penyelesaian");
		Template::set('toolbar_title', 'List Usulan PKTP (Penyelesaian)');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a daftar ptpp object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Daftar_ptpp.Ptpp.Create');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');
		$kode_audit = $this->uri->segment(5);
		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_daftar_ptpp($kode_audit))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_ptpp_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'daftar_ptpp');

				Template::set_message(lang('daftar_ptpp_create_success'), 'success');
				redirect(SITE_AREA .'/ptpp/daftar_ptpp');
			}
			else
			{
				Template::set_message(lang('daftar_ptpp_create_failure') . $this->daftar_ptpp_model->error, 'error');
			}
		}
		Assets::add_module_js('daftar_ptpp', 'daftar_ptpp.js');
		Template::set('kode_audit', $kode_audit);
		Template::set('toolbar_title', lang('daftar_ptpp_create') . ' daftar PKTP');
		Template::set('user_active', $this->current_user->id);
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of daftar ptpp data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('daftar_ptpp_invalid_id'), 'error');
			redirect(SITE_AREA .'/ptpp/daftar_ptpp');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Daftar_ptpp.Ptpp.Edit');

			if ($this->save_daftar_ptpp("",'update', $id))
			{
				// kirim email ke WM
				$wm ="";
				$this->load->model('user/user_model', null, true);
				$this->user_model->where('users.role_id',"7");
				$users = $this->user_model->find_all();
				if(isset($users) && is_array($users) && count($users)){
					foreach ($users as $recorduser) :
						$wm = $recorduser->id;
					endforeach;
				}
				$user = $this->user_model->find($wm);
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Usulan Dokumen Eksternal";
				$isi        		= "Anda Perlu memeriksa usulan dokumen eksternal yang diupload oleh: ".$this->current_user->display_name;
				
				$this->load->library('emailer/emailer');
				$dataemail = array (
					'subject'	=> $subjek,
					'message'	=> $isi,
				);
				$success_count = 0;
				$resultmail = FALSE;
				 
				$dataemail['to'] = $email;
				$resultmailwm = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
			 
				if ($resultmailwm)
				{
					log_activity($this->current_user->id, 'Pengiriman email ke wm usulan PKTP gagal ' . $this->input->ip_address(), 'usulan_dokumen_internal');
				}else{
					log_activity($this->current_user->id, ' pengiriman email ke wm dari usulan PKTP gagal' . $this->input->ip_address(), 'usulan_dokumen_internal');
				}
			//end WM
			
				
				
				// kirim email ke pengusul
				$user = $this->user_model->find($this->current_user->id);
				$email = "yanarazor@gmail.com";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       	= "Notifikasi usulan PKTP";
				$isi        	= "Usulan PKTP Anda sudah di Kirim";
				
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
					log_activity($this->current_user->id, 'Pengiriman Email Kepada '.$email.' dari IP: ' . $this->input->ip_address()." Sukses", 'usulan_dokumen_internal');
				}else{
					log_activity($this->current_user->id, ' Pengiriman Email Kepada '.$email.' dari IP: ' . $this->input->ip_address()." Gagal", 'usulan_dokumen_internal');
				}
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_ptpp_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_ptpp');

				Template::set_message(lang('daftar_ptpp_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('daftar_ptpp_edit_failure') . $this->daftar_ptpp_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Daftar_ptpp.Ptpp.Delete');

			if ($this->daftar_ptpp_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_ptpp_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_ptpp');

				Template::set_message(lang('daftar_ptpp_delete_success'), 'success');

				redirect(SITE_AREA .'/ptpp/daftar_ptpp');
			}
			else
			{
				Template::set_message(lang('daftar_ptpp_delete_failure') . $this->daftar_ptpp_model->error, 'error');
			}
		}
		Template::set('daftar_ptpp', $this->daftar_ptpp_model->find($id));
		Template::set('toolbar_title', lang('daftar_ptpp_edit') .' Usulan PKTP');
		Template::render();
	}
	public function periksa()
	{
		$id = $this->uri->segment(5);
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('daftar_ptpp_invalid_id'), 'error');
			redirect(SITE_AREA .'/ptpp/daftar_ptpp');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Daftar_ptpp.Ptpp.pengecekan');
		
			if ($this->save_periksa('update', $id))
			{
				// kirim email ke kabid
				if($this->input->post('daftar_ptpp_status_persetujuan')=="1")
				{
					$bidangrecorddetil = $this->bidang_model->find($this->input->post('daftar_ptpp_ditujukan_kepada'));
					$kabid = $bidangrecorddetil->kabid;
					$user = $this->user_model->find($kabid);
					$email = "yanarazor@gmail.com";
					if (isset($user))
					{
						$email = $user->email;
					}
					//sending mail
					$subjek       	= "Notifikasi usulan PKTP";
					$isi        	= "Ada usulan PKTP Baru, Silahkan dicek";
				
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
						log_activity($this->current_user->id, 'Pengiriman Email Kepada '.$email.' dari IP: ' . $this->input->ip_address()." Sukses", 'usulan_dokumen_internal');
					}else{
						log_activity($this->current_user->id, ' Pengiriman Email Kepada '.$email.' dari IP: ' . $this->input->ip_address()." Gagal", 'usulan_dokumen_internal');
					}
				}else
				{
					$user = $this->user_model->find($this->input->post('daftar_ptpp_diajukan_oleh'));
					$email = "yanarazor@gmail.com";
					if (isset($user))
					{
						$email = $user->email;
					}
					//sending mail
					$subjek       	= "Notifikasi usulan PKTP";
					$isi        	= "PTPP Anda Ditolak";
				
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
						log_activity($this->current_user->id, 'Pengiriman Email Kepada '.$email.' dari IP: ' . $this->input->ip_address()." Sukses", 'usulan_dokumen_internal');
					}else{
						log_activity($this->current_user->id, ' Pengiriman Email Kepada '.$email.' dari IP: ' . $this->input->ip_address()." Gagal", 'usulan_dokumen_internal');
					}
				}
				
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_ptpp_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_ptpp');

				Template::set_message(lang('daftar_ptpp_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('daftar_ptpp_edit_failure') . $this->daftar_ptpp_model->error, 'error');
			}
		}
		 
		Template::set('daftar_ptpp', $this->daftar_ptpp_model->find($id));
		Template::set('toolbar_title', "Verifikasi Usulan PKTP");
		Template::render();
	}
	public function penyelesaian()
	{
		$id = $this->uri->segment(5);
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('daftar_ptpp_invalid_id'), 'error');
			redirect(SITE_AREA .'/ptpp/daftar_ptpp');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Daftar_ptpp.Ptpp.pengesahan');

			if ($this->save_penyelesaian('update', $id))
			{
				$user = $this->user_model->find($this->input->post('daftar_ptpp_diajukan_oleh'));
				$email = "yanarazor@gmail.com";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       	= "Notifikasi usulan PKTP";
				$isi        	= "Usulan PKTP Anda sudah di tanggapi Oleh ".$this->current_user->display_name;
				
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
					log_activity($this->current_user->id, 'Pengiriman Email Kepada '.$email.' dari IP: ' . $this->input->ip_address()." Sukses", 'usulan_dokumen_internal');
				}else{
					log_activity($this->current_user->id, ' Pengiriman Email Kepada '.$email.' dari IP: ' . $this->input->ip_address()." Gagal", 'usulan_dokumen_internal');
				}
				 
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_ptpp_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_ptpp');

				Template::set_message(lang('daftar_ptpp_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('daftar_ptpp_edit_failure') . $this->daftar_ptpp_model->error, 'error');
			}
		}
		 
		Template::set('daftar_ptpp', $this->daftar_ptpp_model->find($id));
		Template::set('toolbar_title', 'Penyelesaian PTPP');
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
	private function save_daftar_ptpp($kode_audit="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('daftar_ptpp_ditujukan_kepada','Kepada','required|max_length[50]');
		//$this->form_validation->set_rules('daftar_ptpp_diajukan_oleh','Pengaju','required|max_length[50]');
		$this->form_validation->set_rules('daftar_ptpp_no_ptpp','No PTPP','max_length[20]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		// make sure we only pass in the fields we want
		
		$data = array();
		//$data['ditujukan_kepada']        = $this->input->post('daftar_ptpp_ditujukan_kepada');
		 
		$data['id_bidang']        = $this->input->post('daftar_ptpp_ditujukan_kepada');
		if ($type == 'insert')
		{
			$data['diajukan_oleh']        = $this->current_user->id;//$this->input->post('daftar_ptpp_diajukan_oleh');
		}
		$data['no_ptpp']        = $this->input->post('daftar_ptpp_no_ptpp');
		$data['tgl_ptpp']        = date("Y-m-d");//$this->input->post('daftar_ptpp_tgl_ptpp') ? $this->input->post('daftar_ptpp_tgl_ptpp') : '0000-00-00';
		$data['referensi']        = $this->input->post('daftar_ptpp_referensi');
		$data['kategori']        = $this->input->post('daftar_ptpp_kategori');
		$data['deskripsi_ketidaksesuaian']        = $this->input->post('daftar_ptpp_deskripsi_ketidaksesuaian');
		$data['tanggal_pengusulan']        = date("Y-m-d");//$this->input->post('daftar_ptpp_tanggal_pengusulan') ? $this->input->post('daftar_ptpp_tanggal_pengusulan') : '0000-00-00';
		//$data['tanggal_tandatangan_auditi']        = $this->input->post('daftar_ptpp_tanggal_tandatangan_auditi') ? $this->input->post('daftar_ptpp_tanggal_tandatangan_auditi') : '0000-00-00';
		//$data['hasil_investigasi']        = $this->input->post('daftar_ptpp_hasil_investigasi');
		//$data['tgl_tandatangan_hasil']        = $this->input->post('daftar_ptpp_tgl_tandatangan_hasil') ? $this->input->post('daftar_ptpp_tgl_tandatangan_hasil') : '0000-00-00';
		//$data['tindakan_koreksi']        = $this->input->post('daftar_ptpp_tindakan_koreksi');
		//$data['tindakan_korektif']        = $this->input->post('daftar_ptpp_tindakan_korektif');
		//$data['tgl_penyelesaian']        = $this->input->post('daftar_ptpp_tgl_penyelesaian') ? $this->input->post('daftar_ptpp_tgl_penyelesaian') : '0000-00-00';
		//$data['disetujui_oleh']        = $this->input->post('daftar_ptpp_disetujui_oleh');
		//$data['tanggal_disetujui']        = $this->input->post('daftar_ptpp_tanggal_disetujui') ? $this->input->post('daftar_ptpp_tanggal_disetujui') : '0000-00-00';
		//$data['tinjauan_tindakan_perbaikan']        = $this->input->post('daftar_ptpp_tinjauan_tindakan_perbaikan');
		//$data['status_persetujuan']        = $this->input->post('daftar_ptpp_status_persetujuan');
		if($kode_audit != "")
			$data['kode_audit']        = $kode_audit;
		else
			$data['kode_audit']        = $this->input->post('kode_audit');
			
		if($this->input->post('daftar_ptpp_status') == "2")
			$data['tanggal_close']        = date("Y-m-d");
			
		$data['status']        = $this->input->post('daftar_ptpp_status')?$this->input->post('daftar_ptpp_status'):"1";
		$data['kesimpulan']        = $this->input->post('daftar_ptpp_kesimpulan');
		
		if($this->input->post('daftar_ptpp_status') == "11")
			$data['status_persetujuan']        = "1";
			
		if ($type == 'insert')
		{
			$id = $this->daftar_ptpp_model->insert($data);

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
			$return = $this->daftar_ptpp_model->update($id, $data);
		}

		return $return;
	}
	private function save_periksa($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('daftar_ptpp_ditujukan_kepada','Kepada','required|max_length[50]');
		//$this->form_validation->set_rules('daftar_ptpp_diajukan_oleh','Pengaju','required|max_length[50]');
		$this->form_validation->set_rules('daftar_ptpp_no_ptpp','No PTPP','max_length[20]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		// make sure we only pass in the fields we want
		
		$data = array();
		 
		$data['status_persetujuan']        = $this->input->post('daftar_ptpp_status_persetujuan');
		//$data['status']        = $this->input->post('daftar_ptpp_status');
		//$data['kesimpulan']        = $this->input->post('daftar_ptpp_kesimpulan');

		if ($type == 'insert')
		{
			$id = $this->daftar_ptpp_model->insert($data);

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
			$return = $this->daftar_ptpp_model->update($id, $data);
		}

		return $return;
	}
	private function save_penyelesaian($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('daftar_ptpp_ditujukan_kepada','Kepada','required|max_length[50]');
		//$this->form_validation->set_rules('daftar_ptpp_diajukan_oleh','Pengaju','required|max_length[50]');
		$this->form_validation->set_rules('daftar_ptpp_no_ptpp','No PTPP','max_length[20]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		// make sure we only pass in the fields we want
		
		$data = array();
		//$data['ditujukan_kepada']        = $this->input->post('daftar_ptpp_ditujukan_kepada');
		//$data['diajukan_oleh']        = $this->input->post('daftar_ptpp_diajukan_oleh');
		//$data['no_ptpp']        = $this->input->post('daftar_ptpp_no_ptpp');
		//$data['tgl_ptpp']        = $this->input->post('daftar_ptpp_tgl_ptpp') ? $this->input->post('daftar_ptpp_tgl_ptpp') : '0000-00-00';
		//$data['referensi']        = $this->input->post('daftar_ptpp_referensi');
		//$data['kategori']        = $this->input->post('daftar_ptpp_kategori');
		//$data['deskripsi_ketidaksesuaian']        = $this->input->post('daftar_ptpp_deskripsi_ketidaksesuaian');
		//$data['tanggal_pengusulan']        = $this->input->post('daftar_ptpp_tanggal_pengusulan') ? $this->input->post('daftar_ptpp_tanggal_pengusulan') : '0000-00-00';
		//$data['tanggal_tandatangan_auditi']        = $this->input->post('daftar_ptpp_tanggal_tandatangan_auditi') ? $this->input->post('daftar_ptpp_tanggal_tandatangan_auditi') : '0000-00-00';
		$data['hasil_investigasi']        = $this->input->post('daftar_ptpp_hasil_investigasi');
		//$data['tgl_tandatangan_hasil']        = $this->input->post('daftar_ptpp_tgl_tandatangan_hasil') ? $this->input->post('daftar_ptpp_tgl_tandatangan_hasil') : '0000-00-00';
		$data['tindakan_koreksi']        = $this->input->post('daftar_ptpp_tindakan_koreksi');
		$data['tindakan_korektif']        = $this->input->post('daftar_ptpp_tindakan_korektif');
		$data['tgl_penyelesaian']        = $this->input->post('daftar_ptpp_tgl_penyelesaian') ? $this->input->post('daftar_ptpp_tgl_penyelesaian') : '0000-00-00';
		$data['disetujui_oleh']        = $this->current_user->id;//$this->input->post('daftar_ptpp_disetujui_oleh');
		$data['tanggal_disetujui']        = date("Y-m-d");//$this->input->post('daftar_ptpp_tanggal_disetujui') ? $this->input->post('daftar_ptpp_tanggal_disetujui') : '0000-00-00';
		$data['persetujuan']        = $this->input->post('persetujuan');
		
		if($this->current_user->role_id == "7" or $this->current_user->role_id == "11" or $this->current_user->role_id == "1")
		{
			$data['tinjauan_tindakan_perbaikan']    = $this->input->post('daftar_ptpp_tinjauan_tindakan_perbaikan');
			//$data['status_persetujuan']        	= $this->input->post('daftar_ptpp_status_persetujuan');
			$data['status']        					= $this->input->post('daftar_ptpp_status');
			$data['kesimpulan']        				= $this->input->post('daftar_ptpp_kesimpulan');
		}
		if ($type == 'insert')
		{
			$id = $this->daftar_ptpp_model->insert($data);

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
			$return = $this->daftar_ptpp_model->update($id, $data);
		}

		return $return;
	}
	//--------------------------------------------------------------------
	function saveberkas(){
    	 $this->load->helper('handle_upload');
		 $uploadData = array();
		 $upload = true;
		 $id_log = $this->input->post('id_log');
		 $namafile = "";
		 if (isset($_FILES['userfile']) && is_array($_FILES['userfile']) && $_FILES['userfile']['error'] != 4)
		 {
			$tmp_name = pathinfo($_FILES['userfile']['name'], PATHINFO_FILENAME);
			$uploadData = handle_upload('userfile',$this->settings_lib->item('site.pathuploaded'));
			 if (isset($uploadData['error']) && !empty($uploadData['error']))
			 {
			 	$tipefile=$_FILES['userfile']['type'];
				 $upload = false;
				 log_activity($this->auth->user_id(), 'Gagal : '.$uploadData['error'].$tipefile.$this->input->ip_address(), 'daftar_ptpp');
			 }else{
			 	$namafile = $uploadData['data']['file_name'];
			 	// update lampiran
			 	$data = array();
				$data['lampiran']        = $namafile; 
				$return = $this->daftar_ptpp_model->update($id_log, $data);

                log_activity($this->auth->user_id(), 'Save Berkas lampiran PKTP, ID : ' . $id_log . ' : ' . $this->input->ip_address(), 'daftar_ptpp');
			 }
		 }else{
		 	die("File tidak ditemukan");
		 	log_activity($this->auth->user_id(), 'File tidak ditemukan : ' . $this->input->ip_address(), 'daftar_ptpp');
		 } 	

       echo '{"namafile":"'.$namafile.'"}';
       exit();
	}

}