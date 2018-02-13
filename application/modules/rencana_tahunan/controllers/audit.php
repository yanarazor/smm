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

		$this->auth->restrict('Rencana_Tahunan.Audit.View');
		$this->load->model('rencana_tahunan_model', null, true);
		$this->load->model('bidang/bidang_model', null, true);
		$this->lang->load('rencana_tahunan');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'audit/_sub_nav');

		Assets::add_module_js('rencana_tahunan', 'rencana_tahunan.js');
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
					$result = $this->rencana_tahunan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('rencana_tahunan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('rencana_tahunan_delete_failure') . $this->rencana_tahunan_model->error, 'error');
				}
			}
		}

		$year = $this->input->get('year');
		if($year=="")
			$year = date("Y");
		$recordbidangs = $this->bidang_model->find_all();
		
		//record jadwal pertahun
		$records = $this->rencana_tahunan_model->GetbyYear($year);
		$jsonjadwal[] =array();
		if (isset($records) && is_array($records) && count($records)) :
			foreach ($records as $record) :
				//echo $record->id_provinsi."<br>";
				$jsonjadwal[$record->bulan."-".$record->id_bidang] = $record->id;
			endforeach;
		endif; 
		Template::set('jsonjadwal',$jsonjadwal);
		
		Template::set('recordbidangs', $recordbidangs);
		Template::set('records', $records);
		Template::set('year', $year);
		Template::set('toolbar_title', 'Kelola Rencana Tahunan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Rencana Tahunan object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Rencana_Tahunan.Audit.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_rencana_tahunan())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('rencana_tahunan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'rencana_tahunan');

				Template::set_message(lang('rencana_tahunan_create_success'), 'success');
				redirect(SITE_AREA .'/audit/rencana_tahunan');
			}
			else
			{
				Template::set_message(lang('rencana_tahunan_create_failure') . $this->rencana_tahunan_model->error, 'error');
			}
		}
		Assets::add_module_js('rencana_tahunan', 'rencana_tahunan.js');

		Template::set('toolbar_title', lang('rencana_tahunan_create') . ' Rencana Tahunan');
		Template::render();
	}
				
	public function kirimnotifikasi()
	{
		$this->auth->restrict('Rencana_Tahunan.Audit.Create');
		
		$wm ="";
		$this->load->model('user/user_model', null, true);
		$this->user_model->where('users.role_id',"8");// SWM 
		$users = $this->user_model->find_all();
		if(isset($users) && is_array($users) && count($users)){
			foreach ($users as $recorduser) :
				$wm = $recorduser->id;
			endforeach;
		}
		$email = "yanarazor@gmail.com";
		$user = $this->user_model->find($wm);
		 if (isset($user))
		 {
			 $email = $user->email;
		 }
		 //sending mail
		 $subjek       		= "Notifikasi Rencana Tahunan Audit Internal";
		 $isi        		= "Silahkan Membuat Jadwal Audit Internal Berdasarkan Rencana Tahunan yang telah Disusun";
		 
		 $this->load->library('emailer/emailer');
		 $dataemail = array (
			 'subject'	=> $subjek,
			 'message'	=> $isi,
		 );
		 $success_count = 0;
		 $resultmail = FALSE;
		  
		 $dataemail['to'] = $email;
		$resultmail = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
	  
		 $resultmail = $this->emailer->send($dataemail,true);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
	  
		 if ($resultmail)
		 {
		 	Template::set_message("Pengiriman Email Notifikasi Rencana Tahunan Audit Internal Ke SWM Berhasil", 'success');
			 log_activity($this->current_user->id, 'Pengiriman Email Notifikasi Rencana Tahunan Audit Internal Ke SWM Berhasil : ' . $this->input->ip_address(), 'rencana_tahunan');
		 }else{
		 	Template::set_message("Pengiriman Email Notifikasi Rencana Tahunan Audit Internal Ke SWM Error", 'error');
			 log_activity($this->current_user->id, ' Pengiriman Email Notifikasi Rencana Tahunan Audit Internal Ke SWM Gagal : ' . $this->input->ip_address(), 'rencana_tahunan');
		 }
		 redirect(SITE_AREA .'/audit/rencana_tahunan');
	}
	public function addjadwal()
	{
		$this->auth->restrict('Rencana_Tahunan.Audit.Create');

		
			if ($insert_id = $this->save_rencana_tahunan())
			{
			 
				// Log the activity
				log_activity($this->current_user->id, lang('rencana_tahunan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'rencana_tahunan');

				$message = lang('rencana_tahunan_create_success');
				 
			}
			else
			{
			  
				$message = lang('rencana_tahunan_create_failure') . $this->rencana_tahunan_model->error;
			}
		echo $message;
		exit;
	}
	public function deljadwal()
	{
		$this->auth->restrict('Rencana_Tahunan.Audit.Delete');
		$year        = $this->input->get('year');
		$bidang        = $this->input->get('bidang');
		$bulan = $this->input->get('bulan');
		if($year=="")
			$year = date("Y");
		$data = array('tahun'=>$year,'bulan'=>$bulan,'id_bidang'=>$bidang);
		
		$result = $this->rencana_tahunan_model->delete_where($data);
		if ($result)
			{
				$message = lang('rencana_tahunan_delete_success');
			}
			else
			{
				$message =  lang('rencana_tahunan_delete_failure') . $this->rencana_tahunan_model->error;
			}	
		echo $message;
		exit;
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Rencana Tahunan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('rencana_tahunan_invalid_id'), 'error');
			redirect(SITE_AREA .'/audit/rencana_tahunan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Rencana_Tahunan.Audit.Edit');

			if ($this->save_rencana_tahunan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('rencana_tahunan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'rencana_tahunan');

				Template::set_message(lang('rencana_tahunan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('rencana_tahunan_edit_failure') . $this->rencana_tahunan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Rencana_Tahunan.Audit.Delete');

			if ($this->rencana_tahunan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('rencana_tahunan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'rencana_tahunan');

				Template::set_message(lang('rencana_tahunan_delete_success'), 'success');

				redirect(SITE_AREA .'/audit/rencana_tahunan');
			}
			else
			{
				Template::set_message(lang('rencana_tahunan_delete_failure') . $this->rencana_tahunan_model->error, 'error');
			}
		}
		Template::set('rencana_tahunan', $this->rencana_tahunan_model->find($id));
		Template::set('toolbar_title', lang('rencana_tahunan_edit') .' Rencana Tahunan');
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
	private function save_rencana_tahunan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['tahun']        = $this->input->get('year');
		$data['dari_tanggal']        = $this->input->post('rencana_tahunan_dari_tanggal') ? $this->input->post('rencana_tahunan_dari_tanggal') : '0000-00-00';
		$data['sampai_tanggal']        = $this->input->post('rencana_tahunan_sampai_tanggal') ? $this->input->post('rencana_tahunan_sampai_tanggal') : '0000-00-00';
		$data['id_bidang']        = $this->input->get('bidang');
		$data['status_wm']        = $this->input->post('rencana_tahunan_status_wm');
		$data['bulan']        = $this->input->get('bulan');

		if ($type == 'insert')
		{
			$id = $this->rencana_tahunan_model->insert($data);

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
			$return = $this->rencana_tahunan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}