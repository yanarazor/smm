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

		//$this->auth->restrict('Izin_Keluar.Kepegawaian.View');
		$this->load->model('izin_keluar_model', null, true);
		$this->lang->load('izin_keluar');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		//Template::set_block('sub_nav', 'kepegawaian/_sub_nav');

		Assets::add_module_js('izin_keluar', 'izin_keluar.js');
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
					$result = $this->izin_keluar_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('izin_keluar_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('izin_keluar_delete_failure') . $this->izin_keluar_model->error, 'error');
				}
			}
		}

		$records = $this->izin_keluar_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Izin Meninggalkan Tempat Kerja');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Izin Keluar object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Izin_Keluar.Kepegawaian.Create');

		if (isset($_POST['save']))
		{
			$atasan = $this->current_user->atasan;
			if ($insert_id = $this->save_izin_keluar($atasan))
			{
				$user = $this->user_model->find($atasan);
				$email = "";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Permintaan Izin Meninggalkan Tempat Kerja";
				$isi        	= "Anda Perlu memeriksa Permintaan Izin Meninggalkan Tempat Kerja Dari ".$this->current_user->display_name." Pada tanggal ".$this->input->post('lupa_timer_tanggal_absen')."<br/>Klik <a href='".base_url()."index.php/admin/kepegawaian/izin_keluar/periksa/".$insert_id."'>link</a>";
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
					
					log_activity($this->current_user->id, 'Pengiriman Email ke atasan langsung untuk Izin keluar kantor success, Dari : ' . $this->input->ip_address(), 'lupa_timer');
				}else{
					$resultmail = $this->emailer->send($dataemail,true);
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke atasan langsung untuk permintaan Izin keluar kantor Gagal, Dari : ' . $this->input->ip_address(), 'lupa_timer');
				}
				
				// Log the activity
				log_activity($this->current_user->id, lang('izin_keluar_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'izin_keluar');

				Template::set_message(lang('izin_keluar_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/surat_izin/keluar/');
			}
			else
			{
				Template::set_message(lang('izin_keluar_create_failure') . $this->izin_keluar_model->error, 'error');
			}
		}
		Assets::add_module_js('izin_keluar', 'izin_keluar.js');

		Template::set('toolbar_title', lang('izin_keluar_create') . ' Izin Meninggalkan Tempat Kerja');
		Template::render();
	}
	public function periksa()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('izin_keluar_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/surat_izin/list_periksa_keluar');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Izin_keluar.Kepegawaian.Periksa');
			$this->izin_keluar_model->skip_validation(true);
			if ($this->save_periksa('update', $id))
			{
				$datadetil = $this->izin_keluar_model->find($id);
				$user = $this->izin_keluar_model->find($datadetil->usr_id);
				$email = "";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Persetujuan Izin Meninggalkan Tempat Kerja";
				$isi        	= "Izin Izin Meninggalkan Tempat Kerja anda sudah di proses oleh ".$this->current_user->display_name;
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
				log_activity($this->current_user->id, 'Verifikasi Sukses ID: '. $id .' : '. $this->input->ip_address(), 'izin_keluar');

				Template::set_message("Verifikasi Sukses", 'success');
				redirect(SITE_AREA .'/kepegawaian/surat_izin/list_periksa_keluar/');
				 
				
			}
			else
			{
				Template::set_message(lang('lupa_timer_edit_failure') . $this->lupa_timer_model->error, 'error');
			}
		}
		$datadetil = $this->izin_keluar_model->find_detil($id);
		//print_r($datadetil);
		//die();
		
		if($datadetil->atasan==$this->current_user->id){
			$this->izin_keluar_model->skip_validation(true);
			$dataupdate = array();
			$dataupdate['status_open']        = "1";
			$return = $this->izin_keluar_model->update($id,$dataupdate);
		}
		Template::set('izin_keluar', $datadetil);
		Template::set('toolbar_title','Periksa Pemberitahuan Izin Meninggalkan Tempat Kerja');
		Template::render();
	}
	//--------------------------------------------------------------------


	/**
	 * Allows editing of Izin Keluar data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('izin_keluar_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/izin_keluar');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Izin_Keluar.Kepegawaian.Edit');

			if ($this->save_izin_keluar("",'update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('izin_keluar_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'izin_keluar');

				Template::set_message(lang('izin_keluar_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('izin_keluar_edit_failure') . $this->izin_keluar_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Izin_Keluar.Kepegawaian.Delete');

			if ($this->izin_keluar_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('izin_keluar_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'izin_keluar');

				Template::set_message(lang('izin_keluar_delete_success'), 'success');

				redirect(SITE_AREA .'/kepegawaian/izin_keluar');
			}
			else
			{
				Template::set_message(lang('izin_keluar_delete_failure') . $this->izin_keluar_model->error, 'error');
			}
		}
		Template::set('izin_keluar', $this->izin_keluar_model->find($id));
		Template::set('toolbar_title', lang('izin_keluar_edit') .' Izin Meninggalkan Tempat Kerja');
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
	private function save_izin_keluar($atasan="",$type='insert', $id=0)
	{
		$data = array();
		if ($type == 'update')
		{
			$_POST['id'] = $id;
			$data['date_created']        = date("Y-m-d");//$this->input->post('surat_izin_tanggal_dibuat') ? $this->input->post('surat_izin_tanggal_dibuat') : '0000-00-00';
			//$data['atasan']        = $atasan;//$this->input->post('lupa_timer_atasan');
		
		}
		if ($type != 'update')
		{
			$data['atasan']        = $atasan;

		}

		// make sure we only pass in the fields we want
		
		
		$data['tanggal']        = $this->input->post('izin_keluar_tanggal') ? $this->input->post('izin_keluar_tanggal') : '0000-00-00';
		$data['dari_jam']        = $this->input->post('izin_keluar_dari_jam');
		$data['sampai_jam']        = $this->input->post('izin_keluar_sampai_jam');
		$data['keterangan']        = $this->input->post('izin_keluar_keterangan');
		
		if ($type != 'update')
		{
			$data['usr_id']        = $this->current_user->id;
		}
		if ($type == 'insert')
		{
			$id = $this->izin_keluar_model->insert($data);

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
			$return = $this->izin_keluar_model->update($id, $data);
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
		$this->izin_keluar_model->skip_validation(true);
		$data = array();
		//if($this->input->post('status_atasan')!="")
		$data['status_atasan']        = $this->input->post('status_atasan');
		//$data['status_open']        = $this->input->post('lupa_timer_status_open');
		$data['alasan_ditolak']        = $this->input->post('alasan_ditolak');
		
		if ($type == 'insert')
		{
			$id = $this->izin_keluar_model->insert($data);

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
			$return = $this->izin_keluar_model->update($id, $data);
		}

		return $return;
	}
	//--------------------------------------------------------------------


}