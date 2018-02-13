<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * audit controller
 */
class audit extends Admin_Controller
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

		$this->auth->restrict('Audit_Internal.Audit.View');
		$this->load->model('audit_internal_model', null, true);
		$this->load->model('daftar_periksa_audit/daftar_periksa_audit_model', null, true);
		$this->load->model('bidang/bidang_model', null, true);
		$this->lang->load('audit_internal');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'audit/_sub_nav');

		Assets::add_module_js('audit_internal', 'audit_internal.js');
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');
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
					$result = $this->audit_internal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('audit_internal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('audit_internal_delete_failure') . $this->audit_internal_model->error, 'error');
				}
			}
		}
		$keyword 	= $this->input->get('keyword');
		$year 	= $this->input->get('year');
		 
		$this->load->library('pagination');
		 
		$total = count($this->audit_internal_model->find_all($keyword,$year));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?keyword='.$keyword.'&year='.$year.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		$records = $this->audit_internal_model->limit($limit, $offset)->find_all($keyword,$year);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('year', $year);
		Template::set('records', $records);
		
		Template::set('toolbar_title', 'Kelola Audit Internal');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Audit Internal object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Audit_Internal.Audit.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_audit_internal())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('audit_internal_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'audit_internal');

				Template::set_message(lang('audit_internal_create_success'), 'success');
				redirect(SITE_AREA .'/audit/audit_internal/edit/'.$insert_id);
			}
			else
			{
				Template::set_message(lang('audit_internal_create_failure') . $this->audit_internal_model->error, 'error');
			}
		}
		Assets::add_module_js('audit_internal', 'audit_internal.js');

		Template::set('toolbar_title', lang('audit_internal_create') . ' Audit Internal');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Audit Internal data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$this->load->model('user/user_model', null, true);
		$this->load->model('jadwal_audit/jadwal_audit_model', null, true);
		//$this->user_model->where('users.role_id',"11");
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('audit_internal_invalid_id'), 'error');
			redirect(SITE_AREA .'/audit/audit_internal');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Audit_Internal.Audit.Edit');

			if ($this->save_audit_internal('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('audit_internal_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'audit_internal');

				Template::set_message(lang('audit_internal_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('audit_internal_edit_failure') . $this->audit_internal_model->error, 'error');
			}
		}
		if (isset($_POST['savejadwal']))
		{
			$resultmail = false;
			$datadelete = array('id_audit'=>$id);
			$this->jadwal_audit_model->delete_where($datadelete);
				
			$this->auth->restrict('Jadwal_Audit.Audit.Edit');
			$id_bidang = $this->input->post('id_bidang');
			$id_audit = $this->input->post('id_audit');
			$jadwal_audit_pm = $this->input->post('jadwal_audit_pm');
			$jadwal_audit_klausul = $this->input->post('jadwal_audit_klausul');
			$jadwal_audit_tanggal = $this->input->post('jadwal_audit_tanggal');
			$jadwal_audit_auditor_kepala = $this->input->post('jadwal_audit_auditor_kepala');
			$jadwal_audit_auditor = $this->input->post('jadwal_audit_auditor');
			for($i=0;$i<count($id_bidang);$i++){
				$data = array();
				$data['id_audit']        = $id_audit[$i];
				$data['id_bidang']        = $id_bidang[$i];
				$data['pm']        = $jadwal_audit_pm[$i];
				$data['klausul']        = $jadwal_audit_klausul[$i];
				$data['tanggal']        = $jadwal_audit_tanggal[$i] ? $jadwal_audit_tanggal[$i] : '0000-00-00';
				$data['auditor_kepala']        = $jadwal_audit_auditor_kepala[$i];
				$data['auditor']        = $jadwal_audit_auditor[$i];
				$this->jadwal_audit_model->insert($data);
			}
			
			$this->user_model->where('users.role_id',"11");
			$users = $this->user_model->find_all();
		
			// notifikasi ke auditor dan kabid yang mau diaudit
			if(isset($users) && is_array($users) && count($users)):
			  foreach($users as $user):
			  	 $email = $user->email;
				 //sending mail
				   $subjek       	= "Penunjukan Auditor dan Pembuatan Daftar Periksa Audit";
				   $isi        		= "Selamat, Anda Telah ditunjuk sebagai auditor, Silahkan membuat daftar periksa audit";
		 
				   $this->load->library('emailer/emailer');
				   $dataemail = array (
					   'subject'	=> $subjek,
					   'message'	=> $isi,
				   );
				   $success_count = 0;
				   $resultmail = FALSE;
		  
				   $dataemail['to'] = $email;
				   $resultmail = $this->emailer->send($dataemail,false);
				endforeach;
			endif;
			
			if ($resultmail)
			 {
				Template::set_message("Pengiriman Email Notifikasi ke Kabid Berhasil", 'success');
				 log_activity($this->current_user->id, 'Pengiriman Email Notifikasi ke Kabid Berhasil : ' . $this->input->ip_address(), 'rencana_tahunan');
			 }else{
			 	$resultmail = $this->emailer->send($dataemail,true);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu

				Template::set_message("Pengiriman Email Notifikasi ke Kabid Gagal", 'error');
				 log_activity($this->current_user->id, ' Pengiriman Email Notifikasi ke Kabid Gagal : ' . $this->input->ip_address(), 'rencana_tahunan');
			 }

		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Audit_Internal.Audit.Delete');

			if ($this->audit_internal_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('audit_internal_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'audit_internal');

				Template::set_message(lang('audit_internal_delete_success'), 'success');

				redirect(SITE_AREA .'/audit/audit_internal');
			}
			else
			{
				Template::set_message(lang('audit_internal_delete_failure') . $this->audit_internal_model->error, 'error');
			}
		}
			$emailkabid = $this->input->post('email_kabid');
			 
			for($i=0;$i<count($emailkabid);$i++){
			  //sending mail
			  $email = $emailkabid[$i];
			  $subjek       	= "Jadwal Audit Internal";
			  $isi        		= "Jadwal Audit internal sudah dibuat, Informasi selengkapnya silakan cek di ISO Semar";

			  $this->load->library('emailer/emailer');
			  $dataemail = array (
				  'subject'	=> $subjek,
				  'message'	=> $isi,
			  );
			  $success_count = 0;
			  $resultmail = FALSE;
	  
			  $dataemail['to'] = $email;
			  if($email!=""){
				   $resultmail = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu   		
			  }
			}
			
		$records = $this->jadwal_audit_model->find_all($id);
			$jsonjadwal[] =array();
			if (isset($records) && is_array($records) && count($records)) :
				foreach ($records as $record) :
					
					$jsonjadwal["pm-".$record->id_bidang] = $record->pm;
					$jsonjadwal["klausul-".$record->id_bidang] = $record->klausul;
					$jsonjadwal["tanggal-".$record->id_bidang] = $record->tanggal;
					$jsonjadwal["auditor_kepala-".$record->id_bidang] = $record->auditor_kepala;
					$jsonjadwal["auditor-".$record->id_bidang] = $record->auditor; 
				endforeach;
			endif; 
			Template::set('jsonjadwal',$jsonjadwal); 
			
		$recordbidangs = $this->bidang_model->find_all();
		
		//record jadwal pertahun
		 
		
		Template::set('recordbidangs', $recordbidangs);
		
		// end daftar periksa audit
		Template::set('filter_type', "daftar");
		Template::set('audit_internal', $this->audit_internal_model->find($id));
		Template::set('toolbar_title', lang('audit_internal_edit') .' Audit Internal');
		Template::render();
	}
	private function save_jadwal_audit($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['id_audit']        = $this->input->post('jadwal_audit_id_audit');
		$data['id_bidang']        = $this->input->post('jadwal_audit_id_bidang');
		$data['pm']        = $this->input->post('jadwal_audit_pm');
		$data['klausul']        = $this->input->post('jadwal_audit_klausul');
		$data['tanggal']        = $this->input->post('jadwal_audit_tanggal') ? $this->input->post('jadwal_audit_tanggal') : '0000-00-00';
		$data['auditor_kepala']        = $this->input->post('jadwal_audit_auditor_kepala');
		$data['auditor']        = $this->input->post('jadwal_audit_auditor');
		if ($type == 'insert')
		{
			$id = $this->jadwal_audit_model->insert($data);

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
			$return = $this->jadwal_audit_model->update($id, $data);
		}

		return $return;
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
	private function save_audit_internal($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('audit_internal_judul','Judul : '.$this->input->post('audit_internal_judul'),'required|unique[bf_audit_internal.judul,bf_audit_internal.id]|max_length[100]');
		$this->form_validation->set_rules('audit_internal_dari_tanggal','Dari Tanggal','required|max_length[20]');
		$this->form_validation->set_rules('audit_internal_sampai_tanggal','Sampai Tanggal','required|max_length[20]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		// make sure we only pass in the fields we want
		$data = array();
		$data['judul']        = $this->input->post('audit_internal_judul');
		$data['dari_tanggal']        = $this->input->post('audit_internal_dari_tanggal') ? $this->input->post('audit_internal_dari_tanggal') : '0000-00-00';
		$data['sampai_tanggal']        = $this->input->post('audit_internal_sampai_tanggal') ? $this->input->post('audit_internal_sampai_tanggal') : '0000-00-00';
		if ($type == 'insert')
		{
			$id = $this->audit_internal_model->insert($data);
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
			$return = $this->audit_internal_model->update($id, $data);
		}

		return $return;
	}
	public function listchecklist()
	{
		$idai = $this->uri->segment(5);
		 
		$records =	$this->daftar_periksa_audit_model->find_all($idai,"");
		$total =	count($this->daftar_periksa_audit_model->find_all($idai,""));
		if(isset($records) && is_array($records) && count($records))
			$total = $total;
		else
			$total = 0;
		 
		$output = "";
			$output .= $this->load->view('audit/listchecklist',array('checklists'=>$records,'idai'=>$idai,'totalchecklist'=>$total),true);	
		echo $output;
		die();
	}
	

	//--------------------------------------------------------------------


}