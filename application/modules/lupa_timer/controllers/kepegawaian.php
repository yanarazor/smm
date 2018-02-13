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

		
		$this->load->model('lupa_timer_model', null, true);
		$this->lang->load('lupa_timer');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');

		Assets::add_module_js('lupa_timer', 'lupa_timer.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		//$this->auth->restrict('Lupa_Timer.Kepegawaian.View');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->lupa_timer_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('lupa_timer_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('lupa_timer_delete_failure') . $this->lupa_timer_model->error, 'error');
				}
			}
		}
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12"){
			$this->lupa_timer_model->where('user',$this->current_user->id);
		}
		$total = $this->lupa_timer_model->count_all($keyword,$status);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12"){
			$this->lupa_timer_model->where('user',$this->current_user->id);
		}
		$records = $this->lupa_timer_model->limit($limit, $offset)->find_all($keyword,$status);
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('keyword', $keyword); 
		Template::set('filter_type', "all"); 
		Template::set('status', $status); 

		 
		Template::set('toolbar_title', 'Manage Lupa Timer');
		Template::render();
	}
	public function list_periksa()
	{

		// Deleting anything?
		 
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1")
			$this->lupa_timer_model->where('lupa_timer.atasan',$this->current_user->id);
		$this->lupa_timer_model->where('user',$this->current_user->id);
		$total = count($this->lupa_timer_model->find_all($keyword,$status));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1")
			$this->lupa_timer_model->where('lupa_timer.atasan',$this->current_user->id);
		$records = $this->lupa_timer_model->limit($limit, $offset)->find_all($keyword,$status);
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('keyword', $keyword); 
		Template::set('filter_type', "periksa"); 
		Template::set('status', $status); 

		 
		Template::set('toolbar_title', 'Manage Lupa Timer');
		Template::render();
	}
	//--------------------------------------------------------------------


	/**
	 * Creates a Lupa Timer object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Lupa_Timer.Kepegawaian.Create');

		if (isset($_POST['save']))
		{
			$atasan = $this->current_user->atasan;
			if ($insert_id = $this->save_lupa_timer($atasan))
			{
				$user = $this->user_model->find($atasan);
				$email = "";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Lupa Menerakan Timer";
				$isi        	= "Anda Perlu memeriksa Permintaan izin Lupa Menerakan Timer Dari ".$this->current_user->display_name." Pada tanggal ".$this->input->post('lupa_timer_tanggal_absen')."<br/>Klik <a href='".base_url()."index.php/admin/kepegawaian/lupa_timer/periksa/".$insert_id."'>link</a>";
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
					
					log_activity($this->current_user->id, 'Pengiriman Email ke atasan langsung untuk izin Lupa menerakan Timer success, Dari : ' . $this->input->ip_address(), 'lupa_timer');
				}else{
					$resultmail = $this->emailer->send($dataemail,true);
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke atasan langsung untuk permintaan izin Lupa menerakan Timer Gagal, Dari : ' . $this->input->ip_address(), 'lupa_timer');
				}
				
				// Log the activity
				log_activity($this->current_user->id, lang('lupa_timer_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'lupa_timer');

				Template::set_message(lang('lupa_timer_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/lupa_timer');
			}
			else
			{
				Template::set_message(lang('lupa_timer_create_failure') . $this->lupa_timer_model->error, 'error');
			}
		}
		Assets::add_module_js('lupa_timer', 'lupa_timer.js');

		Template::set('toolbar_title', lang('lupa_timer_create') . ' Lupa Timer');
		Template::render();
	}
	public function list_bystatus()
	{

		 
		//die($this->current_user->id."masuk");
		$status = $this->input->get('status');
		//die($status."asd");
		$user = $this->input->get('user');
		$this->load->library('pagination');
		if($status != "")
			$this->lupa_timer_model->where('status_atasan !=""');
		else
			$this->lupa_timer_model->where('status_atasan is null');
			
		$total = $this->lupa_timer_model->count_all();
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?status=".$status;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($status != "")
			$this->lupa_timer_model->where('status_atasan !=""');
		else
			$this->lupa_timer_model->where('status_atasan is null');
		$records = $this->lupa_timer_model->limit($limit, $offset)->find_all();
		 
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('filter_type', "periksa"); 
		Template::set('status', $status); 
		Template::set_theme('simple');
		Template::set('toolbar_title', 'Manage Surat Izin');
		Template::render();
	}
	//--------------------------------------------------------------------

	public function periksa()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('lupa_timer_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/surat_izin/list_periksa_timer');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Lupa_Timer.Kepegawaian.Periksa');
			$this->lupa_timer_model->skip_validation(true);
			if ($this->save_periksa('update', $id))
			{
				$datadetil = $this->lupa_timer_model->find($id);
				$user = $this->user_model->find($datadetil->user);
				$email = "";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Persetujuan Lupa Timer";
				$isi        	= "Izin Lupa timer anda sudah di proses oleh ".$this->current_user->display_name;
				$this->load->library('emailer/emailer');
				$dataemail = array (
					'subject'	=> $subjek,
					'message'	=> $isi,
				);
				$success_count = 0;
				$resultmail = FALSE;
				 
				$dataemail['to'] = $email;
				$resultmail = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
			 	$resultmail = $this->emailer->send($dataemail,true);
				// Log the activity
				log_activity($this->current_user->id, 'Verifikasi Sukses ID: '. $id .' : '. $this->input->ip_address(), 'lupa_timer');

				Template::set_message("Verifikasi Sukses", 'success');
				
				// save ke absen harian jika diterima
				/*
				$this->load->model('absen/absen_model', null, true);
				if($this->input->post('status_atasan') == "1"){
					$mode = "";
					if($this->input->post('lupa_timer_absen') == "Masuk"){
						$mode = "Scan Masuk";
					}
					else if($this->input->post('lupa_timer_absen') == "Pulang"){
						$mode = "Scan Keluar";
					} 
					$this->save_absen($mode);
				}
				*/
				
			}
			else
			{
				Template::set_message(lang('lupa_timer_edit_failure') . $this->lupa_timer_model->error, 'error');
			}
		}
		$datadetil = $this->lupa_timer_model->find_detil($id);
		if($datadetil->atasan==$this->current_user->id){
			$this->lupa_timer_model->skip_validation(true);
			$dataupdate = array();
			$dataupdate['status_open']        = "1";
			$return = $this->lupa_timer_model->update($id,$dataupdate);
		}
		Template::set('lupa_timer', $datadetil);
		Template::set('toolbar_title','Periksa Pemberitahuan Lupa Timer');
		Template::render();
	}
	/**
	 * Allows editing of Lupa Timer data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('lupa_timer_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/lupa_timer');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Lupa_Timer.Kepegawaian.Edit');

			if ($this->save_lupa_timer("",'update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('lupa_timer_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'lupa_timer');

				Template::set_message(lang('lupa_timer_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('lupa_timer_edit_failure') . $this->lupa_timer_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Lupa_Timer.Kepegawaian.Delete');

			if ($this->lupa_timer_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('lupa_timer_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'lupa_timer');

				Template::set_message(lang('lupa_timer_delete_success'), 'success');

				redirect(SITE_AREA .'/kepegawaian/lupa_timer');
			}
			else
			{
				Template::set_message(lang('lupa_timer_delete_failure') . $this->lupa_timer_model->error, 'error');
			}
		}
		Template::set('lupa_timer', $this->lupa_timer_model->find($id));
		Template::set('toolbar_title', lang('lupa_timer_edit') .' Lupa Timer');
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
	private function save_lupa_timer($atasan="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		
		if ($type != 'update')
		{
			$data['user']        = $this->current_user->id;
		}
		
		$data['tanggal_absen']        = $this->input->post('lupa_timer_tanggal_absen') ? $this->input->post('lupa_timer_tanggal_absen') : '0000-00-00';
		$data['absen']        = $this->input->post('lupa_timer_absen');
		$data['jam_sebenarnya']        = $this->input->post('lupa_timer_jam_sebenarnya');
		$data['atasan']        = $atasan;//$this->input->post('lupa_timer_atasan');
		if($this->input->post('status_atasan')!="")
			$data['status_atasan']        = $this->input->post('status_atasan');
		$data['date_created']        = date("Y-m-d");

		if ($type == 'insert')
		{
			$id = $this->lupa_timer_model->insert($data);

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
			$return = $this->lupa_timer_model->update($id, $data);
		}

		return $return;
	}
	private function save_periksa($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		$this->lupa_timer_model->skip_validation(true);
		$data = array();
		//if($this->input->post('status_atasan')!="")
		$data['status_atasan']        = $this->input->post('status_atasan');
		//$data['status_open']        = $this->input->post('lupa_timer_status_open');
		$data['alasan_ditolak']        = $this->input->post('alasan_ditolak');
		
		if ($type == 'insert')
		{
			$id = $this->lupa_timer_model->insert($data);

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
			$return = $this->lupa_timer_model->update($id, $data);
		}

		return $return;
	}
	private function save_absen($mode = "",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		$this->lupa_timer_model->skip_validation(true);
		$data = array();
		$data['nik']        = $this->input->post('nip');
		$data['nama']       = $this->input->post('nama');
		$data['tanggal']    = $this->input->post('lupa_timer_tanggal_absen') ? $this->input->post('lupa_timer_tanggal_absen') : '0000-00-00';
		$data['jam']        = $this->input->post('lupa_timer_jam_sebenarnya');
		$data['sn_mesin']   = "Semar";
		$data['verifikasi'] = "SMM";
		$data['model']      = $mode;

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