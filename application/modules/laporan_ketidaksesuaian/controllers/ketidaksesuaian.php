<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ketidaksesuaian controller
 */
class ketidaksesuaian extends Admin_Controller
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

		$this->auth->restrict('Laporan_Ketidaksesuaian.Ketidaksesuaian.View');
		$this->load->model('laporan_ketidaksesuaian_model', null, true);
		$this->lang->load('laporan_ketidaksesuaian');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'ketidaksesuaian/_sub_nav');

		Assets::add_module_js('laporan_ketidaksesuaian', 'laporan_ketidaksesuaian.js');
		$this->load->model('tindakan/tindakan_model');
		$tindakan = $this->tindakan_model->find_all();
		Template::set('tindakans', $tindakan);
		$this->load->model('user/user_model', null, true);
		$users = $this->user_model->find_all();
		Template::set('users', $users);
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
					$result = $this->laporan_ketidaksesuaian_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('laporan_ketidaksesuaian_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('laporan_ketidaksesuaian_delete_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
				}
			}
		}
		$status = $this->input->get('status');
		$tindakan = $this->input->get('tindakan');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1")
			$this->laporan_ketidaksesuaian_model->where('pengaju',$this->current_user->id);
		$total = count($this->laporan_ketidaksesuaian_model->find_all($tindakan));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?tindakan='.$status.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1")
			$this->laporan_ketidaksesuaian_model->where('pengaju',$this->current_user->id);
		$records = $this->laporan_ketidaksesuaian_model->limit($limit, $offset)->find_all($tindakan);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('status_ptpp', $status);
		Template::set('tindakan', $tindakan);
		Template::set('records', $records);
		Template::set('filter_type', "all");
		Template::set('action', "edit");
		
		Template::set('toolbar_title', 'Kelola Laporan Ketidaksesuaian');
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
					$result = $this->laporan_ketidaksesuaian_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('laporan_ketidaksesuaian_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('laporan_ketidaksesuaian_delete_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
				}
			}
		}
		$status = $this->input->get('status');
		$tindakan = $this->input->get('tindakan');
		$this->load->library('pagination');
		//if($this->current_user->role_id != "1")
		//$this->laporan_ketidaksesuaian_model->where('pengaju',$this->current_user->id);
		$total = count($this->laporan_ketidaksesuaian_model->find_all($tindakan));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?tindakan='.$status.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		//if($this->current_user->role_id != "1")
		//$this->laporan_ketidaksesuaian_model->where('pengaju',$this->current_user->id);
		$records = $this->laporan_ketidaksesuaian_model->limit($limit, $offset)->find_all($tindakan);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('status_ptpp', $status);
		Template::set('tindakan', $tindakan);
		Template::set('records', $records);
		 
		Template::set('action', "verifikasi");
		Template::set('filter_type', "periksa");
		Template::set_view('ketidaksesuaian/index');
		Template::set('toolbar_title', 'Kelola Laporan Ketidaksesuaian');
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
					$result = $this->laporan_ketidaksesuaian_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('laporan_ketidaksesuaian_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('laporan_ketidaksesuaian_delete_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
				}
			}
		}
		$status = $this->input->get('status');
		$tindakan = $this->input->get('tindakan');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id == "4")
			$this->laporan_ketidaksesuaian_model->where('penanggung_jawab',$this->current_user->id);
		if($this->current_user->role_id != "9")
			$this->laporan_ketidaksesuaian_model->where('bidang_bagian',$this->current_user->id_bidang);
			$this->laporan_ketidaksesuaian_model->where('status_evaluasi_swm',"1");
		$total = count($this->laporan_ketidaksesuaian_model->find_all($tindakan));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?tindakan='.$status.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id == "4")
			$this->laporan_ketidaksesuaian_model->where('penanggung_jawab',$this->current_user->id);
		if($this->current_user->role_id != "9")
			$this->laporan_ketidaksesuaian_model->where('bidang_bagian',$this->current_user->id_bidang);
			
			$this->laporan_ketidaksesuaian_model->where('status_evaluasi_swm',"1");
		$records = $this->laporan_ketidaksesuaian_model->limit($limit, $offset)->find_all($tindakan);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('status_ptpp', $status);
		Template::set('tindakan', $tindakan);
		Template::set('records', $records);
		 
		Template::set('action', "evaluasi");
		Template::set('filter_type', "penyelesaian"); 
		Template::set_view('ketidaksesuaian/index');
		Template::set('toolbar_title', 'Kelola Laporan Ketidaksesuaian');
		Template::render();
	}
	
	//--------------------------------------------------------------------


	/**
	 * Creates a Laporan Ketidaksesuaian object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Laporan_Ketidaksesuaian.Ketidaksesuaian.Create');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');
		
		if (isset($_POST['save']))
		{
			$databidang = $this->bidang_model->find($this->input->post('laporan_ketidaksesuaian_bidang_bagian'));
		//print_r($databidang);
			//die($databidang->kabid);
			if ($insert_id = $this->save_laporan_ketidaksesuaian())
			{
				//$this->input->post('laporan_ketidaksesuaian_bidang_bagian')
					
					$user = $this->user_model->find($databidang->kabid);
					$email = "yanarazor@gmail.com";
					if (isset($user))
					{
						$email = $user->email;
						 
					}
				 
					//sending mail
					$subjek       	= "Notifikasi Usulan Perbaikan";
					$isi        	= "Ada Laporan ketidak sesuaian dari : ".$this->current_user->display_name;
					
					$this->load->library('emailer/emailer');
					$dataemail = array (
						'subject'	=> $subjek,
						'message'	=> $isi,
					);
					$success_count = 0;
					$resultmail = FALSE;
					 
					$dataemail['to'] = $email;
					$resultmail = $this->emailer->send($dataemail,false);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
				 
				 
				// Log the activity
				log_activity($this->current_user->id, lang('laporan_ketidaksesuaian_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'laporan_ketidaksesuaian');

				Template::set_message(lang('laporan_ketidaksesuaian_create_success'), 'success');
				redirect(SITE_AREA .'/ketidaksesuaian/laporan_ketidaksesuaian');
			}
			else
			{
				Template::set_message(lang('laporan_ketidaksesuaian_create_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
			}
		}
		Assets::add_module_js('laporan_ketidaksesuaian', 'laporan_ketidaksesuaian.js');

		Template::set('toolbar_title', lang('laporan_ketidaksesuaian_create') . ' Laporan Ketidaksesuaian');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Laporan Ketidaksesuaian data.
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
			Template::set_message(lang('laporan_ketidaksesuaian_invalid_id'), 'error');
			redirect(SITE_AREA .'/ketidaksesuaian/laporan_ketidaksesuaian');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Laporan_Ketidaksesuaian.Ketidaksesuaian.Edit');

			if ($this->save_laporan_ketidaksesuaian('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('laporan_ketidaksesuaian_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'laporan_ketidaksesuaian');

				Template::set_message(lang('laporan_ketidaksesuaian_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('laporan_ketidaksesuaian_edit_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Laporan_Ketidaksesuaian.Ketidaksesuaian.Delete');

			if ($this->laporan_ketidaksesuaian_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('laporan_ketidaksesuaian_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'laporan_ketidaksesuaian');

				Template::set_message(lang('laporan_ketidaksesuaian_delete_success'), 'success');

				redirect(SITE_AREA .'/ketidaksesuaian/laporan_ketidaksesuaian');
			}
			else
			{
				Template::set_message(lang('laporan_ketidaksesuaian_delete_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
			}
		}
		Template::set('laporan_ketidaksesuaian', $this->laporan_ketidaksesuaian_model->find($id));
		Template::set('toolbar_title', lang('laporan_ketidaksesuaian_edit') .' Laporan Ketidaksesuaian');
		Template::render();
	}
	public function verifikasi()
	{
		$id = $this->uri->segment(5);
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('laporan_ketidaksesuaian_invalid_id'), 'error');
			redirect(SITE_AREA .'/ketidaksesuaian/laporan_ketidaksesuaian');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Laporan_Ketidaksesuaian.Ketidaksesuaian.Edit');

			if ($this->save_pemeriksa('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('laporan_ketidaksesuaian_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'laporan_ketidaksesuaian');

				Template::set_message(lang('laporan_ketidaksesuaian_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('laporan_ketidaksesuaian_edit_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
			}
		}
		 
		Template::set('laporan_ketidaksesuaian', $this->laporan_ketidaksesuaian_model->find($id));
		Template::set('toolbar_title', lang('laporan_ketidaksesuaian_edit') .' Laporan Ketidaksesuaian');
		Template::render();
	}
	public function evaluasi()
	{
		$id = $this->uri->segment(5);
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('laporan_ketidaksesuaian_invalid_id'), 'error');
			redirect(SITE_AREA .'/ketidaksesuaian/laporan_ketidaksesuaian');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Laporan_Ketidaksesuaian.Ketidaksesuaian.Edit');

			if ($this->save_evaluasi('update', $id))
			{
				if($this->input->post('laporan_ketidaksesuaian_keputusan')=="1" or $this->input->post('laporan_ketidaksesuaian_keputusan')=="2"){
					$user = $this->user_model->find($this->input->post('pengaju'));
					//print_r($user);
					//die();
					$email = "yanarazor@gmail.com";
					if (isset($user))
					{
						$email = $user->email;
					}
					//sending mail
					$subjek       	= "Notifikasi usulan Tindakan Perbaikan";
					$isi        	= "Usulan  Tindakan Perbaikan Anda sudah di tanggapi Oleh ".$this->current_user->display_name;
					
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
				log_activity($this->current_user->id, lang('laporan_ketidaksesuaian_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'laporan_ketidaksesuaian');

				Template::set_message(lang('laporan_ketidaksesuaian_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('laporan_ketidaksesuaian_edit_failure') . $this->laporan_ketidaksesuaian_model->error, 'error');
			}
		}
		 
		Template::set('laporan_ketidaksesuaian', $this->laporan_ketidaksesuaian_model->find($id));
		Template::set('toolbar_title', lang('laporan_ketidaksesuaian_edit') .' Laporan Ketidaksesuaian');
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
	private function save_laporan_ketidaksesuaian($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		//$this->form_validation->set_rules('laporan_ketidaksesuaian_nomor','Nomor','required|unique[bf_laporan_ketidaksesuaian.nomor,bf_laporan_ketidaksesuaian.id]|max_length[30]');
		$this->form_validation->set_rules('laporan_ketidaksesuaian_kegiatan','Kegiatan','required|max_length[50]');
		$this->form_validation->set_rules('laporan_ketidaksesuaian_bidang_bagian','Bidang','max_length[10]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nomor']        = $this->input->post('laporan_ketidaksesuaian_nomor');
		$data['kegiatan']        = $this->input->post('laporan_ketidaksesuaian_kegiatan');
		if ($type == 'insert')
		{
			$data['pengaju']        = $this->current_user->id;
		}
		
		$data['penanggung_jawab']        = $this->input->post('laporan_ketidaksesuaian_penanggung_jawab');
		$data['tanggal_penemuan']        = $this->input->post('laporan_ketidaksesuaian_tanggal_penemuan') ? $this->input->post('laporan_ketidaksesuaian_tanggal_penemuan') : '0000-00-00';
		$data['bidang_bagian']        = $this->input->post('laporan_ketidaksesuaian_bidang_bagian');
		$data['ketidaksesuaian']        = $this->input->post('laporan_ketidaksesuaian_ketidaksesuaian');
		$data['seharusnya']        = $this->input->post('laporan_ketidaksesuaian_seharusnya');
		//$data['status_evaluasi_swm']        = $this->input->post('laporan_ketidaksesuaian_status_evaluasi_swm');
		//$data['tgl_persetujuan_swm']        = $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_swm') ? $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_swm') : '0000-00-00';
		//$data['tgl_persetujuan_kabid']        = $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_kabid') ? $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_kabid') : '0000-00-00';
		//$data['keterangan']        = $this->input->post('laporan_ketidaksesuaian_keterangan');
		//$data['tgl_close']        = $this->input->post('laporan_ketidaksesuaian_tgl_close') ? $this->input->post('laporan_ketidaksesuaian_tgl_close') : '0000-00-00';

		if ($type == 'insert')
		{
			$id = $this->laporan_ketidaksesuaian_model->insert($data);

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
			$return = $this->laporan_ketidaksesuaian_model->update($id, $data);
		}

		return $return;
	}
	private function save_pemeriksa($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		//$this->form_validation->set_rules('laporan_ketidaksesuaian_nomor','Nomor','required|unique[bf_laporan_ketidaksesuaian.nomor,bf_laporan_ketidaksesuaian.id]|max_length[30]');
		$this->form_validation->set_rules('laporan_ketidaksesuaian_kegiatan','Kegiatan','required|max_length[50]');
		$this->form_validation->set_rules('laporan_ketidaksesuaian_penanggung_jawab','Penanggung Jawab','max_length[10]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		//$data['nomor']        = $this->input->post('laporan_ketidaksesuaian_nomor');
		//$data['kegiatan']        = $this->input->post('laporan_ketidaksesuaian_kegiatan');
		//$data['pengaju']        = $this->current_user->id;
		//$data['penanggung_jawab']        = $this->input->post('laporan_ketidaksesuaian_penanggung_jawab');
		//$data['tanggal_penemuan']        = $this->input->post('laporan_ketidaksesuaian_tanggal_penemuan') ? $this->input->post('laporan_ketidaksesuaian_tanggal_penemuan') : '0000-00-00';
		//$data['bidang_bagian']        = $this->input->post('laporan_ketidaksesuaian_bidang_bagian');
		//$data['ketidaksesuaian']        = $this->input->post('laporan_ketidaksesuaian_ketidaksesuaian');
		//$data['seharusnya']        = $this->input->post('laporan_ketidaksesuaian_seharusnya');
		$data['status_evaluasi_swm']        = $this->input->post('laporan_ketidaksesuaian_status_evaluasi_swm');
		$data['tgl_persetujuan_swm']        = date("Y-m-d");
		//$data['tgl_persetujuan_kabid']        = $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_kabid') ? $this->input->post('laporan_ketidaksesuaian_tgl_persetujuan_kabid') : '0000-00-00';
		//$data['keterangan']        = $this->input->post('laporan_ketidaksesuaian_keterangan');
		//$data['tgl_close']        = $this->input->post('laporan_ketidaksesuaian_tgl_close') ? $this->input->post('laporan_ketidaksesuaian_tgl_close') : '0000-00-00';

		if ($type == 'insert')
		{
			$id = $this->laporan_ketidaksesuaian_model->insert($data);

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
			$return = $this->laporan_ketidaksesuaian_model->update($id, $data);
		}

		return $return;
	}
private function save_evaluasi($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		///$this->form_validation->set_rules('laporan_ketidaksesuaian_nomor','Nomor','required|unique[bf_laporan_ketidaksesuaian.nomor,bf_laporan_ketidaksesuaian.id]|max_length[30]');
		$this->form_validation->set_rules('laporan_ketidaksesuaian_kegiatan','Kegiatan','required|max_length[50]');
		$this->form_validation->set_rules('laporan_ketidaksesuaian_penanggung_jawab','Penanggung Jawab','max_length[10]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		//$data['nomor']        = $this->input->post('laporan_ketidaksesuaian_nomor');
		//$data['kegiatan']        = $this->input->post('laporan_ketidaksesuaian_kegiatan');
		//$data['pengaju']        = $this->current_user->id;
		//$data['penanggung_jawab']        = $this->input->post('laporan_ketidaksesuaian_penanggung_jawab');
		//$data['tanggal_penemuan']        = $this->input->post('laporan_ketidaksesuaian_tanggal_penemuan') ? $this->input->post('laporan_ketidaksesuaian_tanggal_penemuan') : '0000-00-00';
		//$data['bidang_bagian']        = $this->input->post('laporan_ketidaksesuaian_bidang_bagian');
		//$data['ketidaksesuaian']        = $this->input->post('laporan_ketidaksesuaian_ketidaksesuaian');
		//$data['seharusnya']        = $this->input->post('laporan_ketidaksesuaian_seharusnya');
		//$data['status_evaluasi_swm']        = $this->input->post('laporan_ketidaksesuaian_status_evaluasi_swm');
		$data['batas_waktu_penyelesaian']        = $this->input->post('laporan_ketidaksesuaian_batas_waktu_penyelesaian') ? $this->input->post('laporan_ketidaksesuaian_batas_waktu_penyelesaian') : '0000-00-00';
		$data['tgl_persetujuan_kabid']        = date("Y-m-d");
		$data['keterangan']        = $this->input->post('laporan_ketidaksesuaian_keterangan');
		$data['keputusan']        = $this->input->post('laporan_ketidaksesuaian_keputusan');
		$data['status_close']        = $this->input->post('status_close');
		if($this->input->post('status_close')=="1")
			$data['tgl_close']        = date("Y-m-d");
		

		if ($type == 'insert')
		{
			$id = $this->laporan_ketidaksesuaian_model->insert($data);

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
			$return = $this->laporan_ketidaksesuaian_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}