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

		$this->auth->restrict('Surat_Izin.Kepegawaian.View');
		$this->load->model('surat_izin_model', null, true);
		$this->lang->load('surat_izin');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		//Template::set_block('sub_nav', 'kepegawaian/_sub_nav');

		Assets::add_module_js('surat_izin', 'surat_izin.js');
		
		$this->load->model('master_izin/master_izin_model', null, true);
		$masterizin = $this->master_izin_model->find_all();
		Template::set('masterizins', $masterizin);
		
		$this->load->model('user/user_model', null, true);
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		//die($this->current_user->atasan."masuk");
		// Deleting anything?
		redirect(SITE_AREA .'/kepegawaian/surat_izin/rekap');
		/*
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$data_suratizin = $this->surat_izin_model->find($pid);
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}else{
						$result = $this->surat_izin_model->delete($pid);
					}
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}
					else{
						Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
					}
				}
			}
		}
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		$this->surat_izin_model->where('user',$this->current_user->id);
		$total = count($this->surat_izin_model->find_all($keyword,"",$status));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		$this->surat_izin_model->where('user',$this->current_user->id);
		$records = $this->surat_izin_model->limit($limit, $offset)->find_all($keyword,"",$status);
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('keyword', $keyword); 
		Template::set('filter_type', "all"); 
		Template::set('status', $status); 
		Template::set('toolbar_title', 'Daftar Surat Izin');
		Template::render();
		*/
	}
	public function rekap()
	{
		//die($this->current_user->atasan."masuk");
		// Deleting anything?
		$idizin = $this->uri->segment(5);
		 $modul = "";
		if($idizin=="")
			$idizin = "3";
		
		switch($idizin) {
			case "3":
			  $modul = "terlambat";
			break;
			case "2":
			  $modul = "plgcepat";
			  break;
			case "1":
			  $modul = "tidakmasuk";
			  break;
			case "4":
			  $modul = "sakit";
			break;
			 
		}	
		
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$data_suratizin = $this->surat_izin_model->find($pid);
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}else{
						$result = $this->surat_izin_model->delete($pid);
					}
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}
					else{
						Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
					}
				}
			}
		}
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		{
			$this->surat_izin_model->where('user',$this->current_user->id);
		}
		$total = $this->surat_izin_model->count_all($keyword,$idizin,$status);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		{
			$this->surat_izin_model->where('user',$this->current_user->id);
		}	
		$records = $this->surat_izin_model->limit($limit, $offset)->find_all($keyword,$idizin,$status);
		Template::set('total', $total); 
		Template::set('modul', $modul); 
		Template::set('idizin', $idizin);
		Template::set('records', $records); 
		Template::set('keyword', $keyword); 
		Template::set('filter_type', "all"); 
		Template::set('status', $status); 
		Template::set('toolbar_title', 'Daftar Surat Izin');
		Template::render();
	}
	public function rekapizin()
	{
		//die($this->current_user->atasan."masuk");
		// Deleting anything?
		$idizin = $this->uri->segment(5);
		 $modul = "";
		if($idizin=="")
			$idizin = "3";
		
		switch($idizin) {
			case "3":
			  $modul = "terlambat";
			break;
			case "2":
			  $modul = "plgcepat";
			  break;
			case "1":
			  $modul = "tidakmasuk";
			  break;
			case "4":
			  $modul = "sakit";
			break;
			 
		}	
		
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$data_suratizin = $this->surat_izin_model->find($pid);
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}else{
						$result = $this->surat_izin_model->delete($pid);
					}
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}
					else{
						Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
					}
				}
			}
		}
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('user',$this->current_user->id);
		$total = $this->surat_izin_model->count_all($keyword,$idizin,$status);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('user',$this->current_user->id);
		$records = $this->surat_izin_model->limit($limit, $offset)->find_all($keyword,$idizin,$status);
		Template::set('total', $total); 
		Template::set('modul', $modul); 
		Template::set('idizin', $idizin);
		Template::set('records', $records); 
		Template::set('keyword', $keyword); 
		Template::set('filter_type', "all"); 
		Template::set('status', $status); 
		Template::set('toolbar_title', 'Daftar Surat Izin');
		Template::render();
	}
	public function resume()
	{
		$this->auth->restrict('Surat_Izin.Kepegawaian.Rekap');
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');
		$bulan 	= $this->input->post('bulan') != "" ? $this->input->post('bulan') : date("m");
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : date("Y");
		$role 	= $this->input->post('role');
		
		$this->load->model('roles/role_model', null, true);
		$roles = $this->role_model->find_all();
		if($this->current_user->role_id == "1" or $this->current_user->role_id == "16" or $this->current_user->role_id == "20" and $this->current_user->role_id == "12")
			Template::set('roles', $roles);
		
		
		Template::set('bulan', $bulan);
		Template::set('role', $role);
		Template::set('tahun', $tahun);
		Template::set('toolbar_title', 'Rekap Izin');
		Template::render();
	}
	public function sisacuti()
	{
		
		$this->load->model('surat_izin/surat_izin_model', null, true);
		$this->load->model('pegawai/pegawai_model', null, true);
		$tahun = date("Y");
		$this->surat_izin_model->where('user',$this->current_user->id);
		$recordcuti  	= $this->surat_izin_model->getjmlizincuti($tahun,"13");
		$jmlcuti = isset($recordcuti[0]->jumlah) ? $recordcuti[0]->jumlah : 0;
		// detil pegawai 
		$detilpegawai = $this->pegawai_model->find_by("no_absen",$this->current_user->id);
		$tahunini = isset($detilpegawai->sisa_cuti) ? $detilpegawai->sisa_cuti : 0;

		$jmlM = 0;
		Template::set('tahunini', $tahunini);
		Template::set('jmlcuti', $jmlcuti);
		Template::set('jmlM', $jmlM);
		Template::set('toolbar_title', 'Sisa Cuti');
		Template::render();
	}
	public function rekap_content()
	{
		$this->auth->restrict('Surat_Izin.Kepegawaian.Rekap');
		$this->load->model('user/user_model', null, true);
		$this->load->model('roles/role_model', null, true);
		$this->load->model('lupa_timer/lupa_timer_model', null, true);
		$roles = $this->role_model->find_all();
		Template::set('roles', $roles);
		
		
		$nip 	= $this->input->post('nip');
		$nama 	= $this->input->post('nama');
		$bulan 	= $this->input->post('bulan') != "" ? $this->input->post('bulan') : date("m");
		$tahun 	= $this->input->post('tahun') != "" ? $this->input->post('tahun') : date("Y");
		$role 	= $this->input->post('role');
		$recordsuratizin  	= $this->surat_izin_model->count_rekap($bulan,$tahun,$nip,$nama);
		//print_r($recordsuratizin); 
		$dataizin 		= array(); 
		if(isset($recordsuratizin) && is_array($recordsuratizin) && count($recordsuratizin)):
			foreach ($recordsuratizin as $record) :
				$dataizin[$record->izin."_".$record->nip] = $record->jumlah;
			endforeach;
		endif;
		
		$recordtimer  	= $this->lupa_timer_model->count_rekap($bulan,$tahun,$nip,$nama);
		if(isset($recordtimer) && is_array($recordtimer) && count($recordtimer)):
			foreach ($recordtimer as $record) :
				$dataizin["I_".$record->nip] = $record->jumlah;
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
			$this->user_model->where('users.role_id',$role);
		}
		$output = "";
		$this->user_model->where("nip != ''");
		$recorduser  =$this->user_model->find_withnip();
		
		$output .= $this->load->view('kepegawaian/resume_content',array("recorduser"=>$recorduser,"nip"=>$nip,"nama"=>$nama,"bulan"=>$bulan,"tahun"=>$tahun,"dataizin"=>$dataizin),true);	
		 
		echo $output;
		die();
	}
	public function lupa_timer()
	{
		//die($this->current_user->atasan."masuk");
		// Deleting anything?
		$this->load->model('lupa_timer/lupa_timer_model', null, true);
		
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
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}
					else{
						Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
					}
				}
			}
		}
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		$this->lupa_timer_model->where('user',$this->current_user->id);
		$total = $this->lupa_timer_model->count_all($keyword,$status);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		$this->lupa_timer_model->where('user',$this->current_user->id);
		$records = $this->lupa_timer_model->limit($limit, $offset)->find_all($keyword,$status);
		Template::set('total', $total); 
		Template::set('modul', ""); 
		Template::set('idizin', "20");
		Template::set('records', $records); 
		Template::set('keyword', $keyword); 
		Template::set('filter_type', "all"); 
		Template::set('status', $status); 
		Template::set('toolbar_title', 'Daftar Surat Izin');
		Template::render();
	}
	public function keluar()
	{
		//die($this->current_user->atasan."masuk");
		// Deleting anything?
		$this->load->model('izin_keluar/izin_keluar_model', null, true);
		
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
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}
					else{
						Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
					}
				}
			}
		}
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		$this->izin_keluar_model->where('usr_id',$this->current_user->id);
		$total = $this->izin_keluar_model->count_all($keyword,$status);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		$this->izin_keluar_model->where('usr_id',$this->current_user->id);
		$records = $this->izin_keluar_model->limit($limit, $offset)->find_all($keyword,$status);
		Template::set('total', $total); 
		Template::set('modul', ""); 
		Template::set('idizin', "21");
		Template::set('records', $records); 
		Template::set('keyword', $keyword); 
		Template::set('filter_type', "all"); 
		Template::set('status', $status); 
		Template::set('toolbar_title', 'Izin Meninggalkan Tempat Kerja');
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
					$result = $this->surat_izin_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
				}
			}
		}
		//die($this->current_user->id."masuk");
		$status = $this->input->get('status');
		$user = $this->input->get('user');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		{
			$this->surat_izin_model->where('surat_izin.atasan',$this->current_user->id);
		}
		$total = count($this->surat_izin_model->find_all($user,"",$status));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		{
			$this->surat_izin_model->where('surat_izin.atasan',$this->current_user->id);
		}
		$records = $this->surat_izin_model->limit($limit, $offset)->find_all($user,"",$status);
		 
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('filter_type', "periksa"); 
		Template::set('status', $status); 
		
		Template::set('toolbar_title', 'Manage Surat Izin');
		Template::render();
	}
	public function list_periksa_timer()
	{

		// Deleting anything?
		$this->load->model('lupa_timer/lupa_timer_model', null, true);
		
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$bulan = $this->input->get('bulan');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		{
			$this->lupa_timer_model->where('lupa_timer.atasan',$this->current_user->id);
			//$this->lupa_timer_model->where('user',$this->current_user->id);
		}
		$total = $this->lupa_timer_model->count_all($keyword,$status,$bulan);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?&keyword=".$keyword."&bulan=".$bulan."&status=".$status."&Act=Cari+";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->lupa_timer_model->where('lupa_timer.atasan',$this->current_user->id);
		$records = $this->lupa_timer_model->limit($limit, $offset)->find_all($keyword,$status,$bulan);
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('keyword', $keyword);
		Template::set('bulan', $bulan); 
		Template::set('filter_type', "periksa"); 
		Template::set('status', $status); 
		Template::set('idizin', "20"); 
		 
		Template::set('toolbar_title', 'Manage Lupa Timer');
		Template::render();
	}
	public function list_periksa_keluar()
	{

		// Deleting anything?
		$this->load->model('izin_keluar/izin_keluar_model', null, true);
		
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$bulan = $this->input->get('bulan');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		{
			$this->izin_keluar_model->where('izin_keluar.atasan',$this->current_user->id);
			//$this->lupa_timer_model->where('user',$this->current_user->id);
		}
		$total = $this->izin_keluar_model->count_all($keyword,$status,$bulan);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?&keyword=".$keyword."&bulan=".$bulan."&status=".$status."&Act=Cari+";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->izin_keluar_model->where('izin_keluar.atasan',$this->current_user->id);
		$records = $this->izin_keluar_model->limit($limit, $offset)->find_all($keyword,$status,$bulan);
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('keyword', $keyword);
		Template::set('bulan', $bulan); 
		Template::set('filter_type', "periksa"); 
		Template::set('status', $status); 
		Template::set('idizin', "21"); 
		 
		Template::set('toolbar_title', 'Periksa Izin Keluar Kantor');
		Template::render();
	}
	public function rekapvtimerxls()
	{
		$this->load->model('lupa_timer/lupa_timer_model', null, true);
		$idizin = $this->uri->segment(5);
		$modul = "";
		if($idizin=="")
			$idizin = "3";
		
		switch($idizin) {
			case "3":
			  $modul = "terlambat";
			break;
			case "2":
			  $modul = "plgcepat";
			  break;
			case "1":
			  $modul = "tidakmasuk";
			  break;
			case "4":
			  $modul = "sakit";
			break;
			 
		}	
		
		$this->load->library('convert');
		$convert = new convert();
		$this->load->library('Excel');
		//$this->load->library('PHPExcel/IOFactory');
		$objPHPExcel = new PHPExcel();
 		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$bulan 	= $this->input->get('bulan');
        //set Sheet yang akan diolah 
		$objPHPExcel->setActiveSheetIndex(0)
				//mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
				//Hello merupakan isinya
		 ->setCellValue('A1', 'User')
		 ->setCellValue('B1', 'Tanggal Absen')
		 ->setCellValue('C1', 'Absen')
		 ->setCellValue('D1', 'Jam Sebernarnya')
		 ->setCellValue('E1', 'Status');
		// get data
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->lupa_timer_model->where('lupa_timer.atasan',$this->current_user->id);
		$records = $this->lupa_timer_model->find_all($keyword,$status,$bulan);
		$row = 2;
		if(isset($records) && is_array($records) && count($records)){
			$col = 0;
			foreach ($records as $record) :
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $record->user_pengusul);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $convert->fmtDate($record->tanggal_absen,"dd month yyyy")); 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $record->absen);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $record->jam_sebenarnya);
				if($record->status_atasan=="2"){
					echo "<br>Alasan: ".$record->alasan_ditolak;
				}
				if($record->status_atasan=="1")
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row,"Disetujui");
				if($record->status_atasan=="2")
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row,"Ditolak \n Alasan :".$record->alasan_ditolak);
				 
			$row++;  
			endforeach;
		}
		//set title pada sheet (me rename nama sheet)
		$objPHPExcel->getActiveSheet()->setTitle('Sheet 1');
		//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		//sesuaikan headernya 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//ubah nama file saat diunduh
		header('Content-Disposition: attachment;filename="exportLupatimer.xlsx"');
		//unduh file
		$objWriter->save("php://output");
        die();
	}
	public function rekapvf()
	{
		$idizin = $this->uri->segment(5);
		 $modul = "";
		if($idizin=="")
			$idizin = "3";
		
		switch($idizin) {
			case "3":
			  $modul = "terlambat";
			break;
			case "2":
			  $modul = "plgcepat";
			  break;
			case "1":
			  $modul = "tidakmasuk";
			  break;
			case "4":
			  $modul = "sakit";
			break;
			 
		}	
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->surat_izin_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
				}
			}
		}
		//die($this->current_user->id."masuk");
		$status = $this->input->get('status');
		$user = $this->input->get('user');
		$bulan = $this->input->get('bulan');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('surat_izin.atasan',$this->current_user->id);
			
		$total = $this->surat_izin_model->count_all($user,$idizin,$status,$bulan);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('surat_izin.atasan',$this->current_user->id);
		$records = $this->surat_izin_model->limit($limit, $offset)->find_all($user,$idizin,$status,$bulan);
		 
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('filter_type', "periksa"); 
		Template::set('status', $status);
		Template::set('bulan', $bulan);  
		Template::set('user', $user); 
		Template::set('modul', $modul); 
		Template::set('idizin', $idizin);
		Template::set('toolbar_title', 'Manage Surat Izin');
		Template::render();
	}
	public function rekapvfxls()
	{
		$idizin = $this->uri->segment(5);
		$modul = "";
		if($idizin=="")
			$idizin = "3";
		
		switch($idizin) {
			case "3":
			  $modul = "terlambat";
			break;
			case "2":
			  $modul = "plgcepat";
			  break;
			case "1":
			  $modul = "tidakmasuk";
			  break;
			case "4":
			  $modul = "sakit";
			break;
			 
		}	
		
		$this->load->library('convert');
		$convert = new convert();
		$this->load->library('Excel');
		//$this->load->library('PHPExcel/IOFactory');
		$objPHPExcel = new PHPExcel();
 		$status = $this->input->get('status');
		$user 	= $this->input->get('user');
		$bulan 	= $this->input->get('bulan');
		
        //set Sheet yang akan diolah 
		$objPHPExcel->setActiveSheetIndex(0)
				//mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
				//Hello merupakan isinya
									->setCellValue('A1', 'User')
									->setCellValue('B1', 'Izin')
									->setCellValue('C1', 'Lama')
									->setCellValue('D1', 'Hari')
									->setCellValue('E1', 'Tanggal')
									->setCellValue('F1', 'Alasan')
									->setCellValue('G1', 'Status')
									->setCellValue('H1', 'Tanggal Dibuat');
		// get data
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('surat_izin.atasan',$this->current_user->id);
		$records = $this->surat_izin_model->find_all($user,$idizin,$status,$bulan);
		$row = 2;
		if(isset($records) && is_array($records) && count($records)){
			$col = 0;
			foreach ($records as $record) :
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $record->user_pengusul);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $record->nama_izin);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $record->lama." ".$record->satuan);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $record->hari);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $convert->fmtDate($record->tanggal,"dd month yyyy"));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $record->alasan);
				 
				if($record->status_atasan=="2"){
					echo "<br>Alasan: ".$record->alasan_ditolak;
				}
				if($record->status_atasan=="1")
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row,"Disetujui");
				if($record->status_atasan=="2")
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row,"Ditolak \n Alasan :".$record->alasan_ditolak);
				 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $convert->fmtDate($record->tanggal_dibuat,"dd month yyyy"));            	
            $row++;  
			endforeach;
		}
		//set title pada sheet (me rename nama sheet)
		$objPHPExcel->getActiveSheet()->setTitle('Sheet 1');
		//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		//sesuaikan headernya 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//ubah nama file saat diunduh
		header('Content-Disposition: attachment;filename="export.xlsx"');
		//unduh file
		$objWriter->save("php://output");
        die();
	}
	public function rekapvfizin()
	{
		$idizin = $this->uri->segment(5);
		 $modul = "";
		if($idizin=="")
			$idizin = "3";
		
		switch($idizin) {
			case "3":
			  $modul = "terlambat";
			break;
			case "2":
			  $modul = "plgcepat";
			  break;
			case "1":
			  $modul = "tidakmasuk";
			  break;
			case "4":
			  $modul = "sakit";
			break;
			 
		}	
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->surat_izin_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
				}
			}
		}
		//die($this->current_user->id."masuk");
		$status = $this->input->get('status');
		$user = $this->input->get('user');
		$bulan = $this->input->get('bulan');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('surat_izin.atasan',$this->current_user->id);
		$total = $this->surat_izin_model->count_all($user,$idizin,$status,$bulan);
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
		$this->surat_izin_model->where('surat_izin.atasan',$this->current_user->id);
		$records = $this->surat_izin_model->limit($limit, $offset)->find_all($user,$idizin,$status,$bulan);
		 
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('filter_type', "periksa"); 
		Template::set('status', $status); 
		Template::set('bulan', $bulan); 
		Template::set('modul', $modul); 
		Template::set('idizin', $idizin);
		Template::set('user', $user); 
		Template::set('toolbar_title', 'Manage Surat Izin');
		Template::render();
	}
	public function rekapvfizinxls()
	{
		$idizin = $this->uri->segment(5);
		$modul = "";
		if($idizin=="")
			$idizin = "3";
		
		switch($idizin) {
			case "3":
			  $modul = "terlambat";
			break;
			case "2":
			  $modul = "plgcepat";
			  break;
			case "1":
			  $modul = "tidakmasuk";
			  break;
			case "4":
			  $modul = "sakit";
			break;
			 
		}	
		
		$this->load->library('convert');
		$convert = new convert();
		$this->load->library('Excel');
		//$this->load->library('PHPExcel/IOFactory');
		$objPHPExcel = new PHPExcel();
 		$status = $this->input->get('status');
		$user = $this->input->get('user');
		$bulan 	= $this->input->get('bulan');
        //set Sheet yang akan diolah 
		$objPHPExcel->setActiveSheetIndex(0)
				//mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya 
				//Hello merupakan isinya
		 ->setCellValue('A1', 'User')
		 ->setCellValue('B1', 'Izin')
		 ->setCellValue('C1', 'Lama')
		 ->setCellValue('D1', 'Hari')
		 ->setCellValue('E1', 'Dari Tanggal')
		 ->setCellValue('F1', 'Sampai Tanggal')
		 ->setCellValue('G1', 'Alasan')
		 ->setCellValue('H1', 'Status')
		 ->setCellValue('I1', 'Tanggal Dibuat');
		// get data
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12")
			$this->surat_izin_model->where('surat_izin.atasan',$this->current_user->id);
		$records = $this->surat_izin_model->find_all($user,$idizin,$status,$bulan);
		$row = 2;
		if(isset($records) && is_array($records) && count($records)){
			$col = 0;
			foreach ($records as $record) :
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $record->user_pengusul);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $record->nama_izin);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $record->lama." ".$record->satuan);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $record->hari);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $convert->fmtDate($record->tanggal,"dd month yyyy"));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $convert->fmtDate($record->tanggal_selesai,"dd month yyyy"));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $record->alasan);
				 
				if($record->status_atasan=="2"){
					echo "<br>Alasan: ".$record->alasan_ditolak;
				}
				if($record->status_atasan=="1")
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row,"Disetujui");
				if($record->status_atasan=="2")
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row,"Ditolak \n Alasan :".$record->alasan_ditolak);
				 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $convert->fmtDate($record->tanggal_dibuat,"dd month yyyy"));            	
            $row++;  
			endforeach;
		}
		//set title pada sheet (me rename nama sheet)
		$objPHPExcel->getActiveSheet()->setTitle('Sheet 1');
		//mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		//sesuaikan headernya 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//ubah nama file saat diunduh
		header('Content-Disposition: attachment;filename="export.xlsx"');
		//unduh file
		$objWriter->save("php://output");
        die();
	}
	public function list_bystatus()
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
					$result = $this->surat_izin_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
				}
			}
		}
		//die($this->current_user->id."masuk");
		$status = $this->input->get('status');
		$user = $this->input->get('user');
		$this->load->library('pagination');
		if($status != "")
			$this->surat_izin_model->where('status_atasan !=""');
		else
			$this->surat_izin_model->where('status_atasan is null');
			
		$total = $this->surat_izin_model->count_all();
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?status=".$status;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		if($status != "")
			$this->surat_izin_model->where('status_atasan !=""');
		else
			$this->surat_izin_model->where('status_atasan is null');
		$records = $this->surat_izin_model->limit($limit, $offset)->find_all();
		 
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('filter_type', "periksa"); 
		Template::set('status', $status); 
		Template::set_theme('simple');
		Template::set('toolbar_title', 'Manage Surat Izin');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Surat Izin object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Surat_Izin.Kepegawaian.Create');

		if (isset($_POST['save']))
		{
			$atasan = $this->current_user->atasan;
			if ($insert_id = $this->save_surat_izin($atasan))
			{
				$user = $this->user_model->find($atasan);
				$email = "";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       	= "Notifikasi Permintaan Izin";
				$isi        	= "Anda Perlu memeriksa Permintaan Izin dari ".$this->current_user->display_name;
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
					
					log_activity($this->current_user->id, 'Pengiriman Email ke atasan langsung untuk permintaan izin success, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}else{
					$resultmail = $this->emailer->send($dataemail,true);
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke atasan langsung untuk permintaan izin Gagal, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}
				
				// Log the activity
				log_activity($this->current_user->id, lang('surat_izin_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/surat_izin');
			}
			else
			{
				Template::set_message(lang('surat_izin_create_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		Assets::add_module_js('surat_izin', 'surat_izin.js');

		Template::set('toolbar_title', lang('surat_izin_create') . ' Surat Izin');
		Template::render();
	}
	public function terlambat()
	{
		$this->auth->restrict('Surat_Izin.Kepegawaian.Create');
		$id = $this->uri->segment(5);
		if (isset($_POST['save']))
		{
			$atasan = $this->current_user->atasan;
			if($id==""){
				$insert_id = $this->save_surat_izin($atasan,"3");
			}else{
				$insert_id = $this->save_surat_izin($atasan,"3","update",$id);
			}
			if ($insert_id)
			{
				$resultmail = $this->sendmail($atasan," Selama ".$this->input->post('surat_izin_lama')." ".$this->input->post('surat_izin_satuan').",Pada Tanggal ".$this->input->post('surat_izin_tanggal')."<br/>Klik <a href='".base_url()."index.php/admin/kepegawaian/surat_izin/periksa/".$insert_id."'>link</a>"," Terlambat");
			 	
			 	if ($resultmail)
				{
					
					log_activity($this->current_user->id, 'Pengiriman Email ke atasan langsung untuk permintaan izin success, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}else{
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke atasan langsung untuk permintaan izin Gagal, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}
				
				// Log the activity
				log_activity($this->current_user->id, 'Sukses Update data : '. $insert_id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/surat_izin/terlambat');
			}
			else
			{
				Template::set_message(lang('surat_izin_create_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		

		Template::set('surat_izin', $this->surat_izin_model->find($id));
		Assets::add_module_js('surat_izin', 'surat_izin.js');

		Template::set('toolbar_title', lang('surat_izin_create') . ' Surat Izin Datang Terlambat');
		Template::render();
	}
	
	public function plgcepat()
	{
		$this->auth->restrict('Surat_Izin.Kepegawaian.Create');
		$id = $this->uri->segment(5);
		if (isset($_POST['save']))
		{
			$atasan = $this->current_user->atasan;
			if($id==""){
				$insert_id = $this->save_surat_izin($atasan,"2");
			}else{
				$insert_id = $this->save_surat_izin($atasan,"2","update",$id);
			}
			if ($insert_id)
			{
				$resultmail = $this->sendmail($atasan," Selama ".$this->input->post('surat_izin_lama')." ".$this->input->post('surat_izin_satuan').",Pada Tanggal ".$this->input->post('surat_izin_tanggal')."<br/>Klik <a href='".base_url()."index.php/admin/kepegawaian/surat_izin/periksa/".$insert_id."'>link</a>"," Pulang Cepat");
			 	
			 	if ($resultmail)
				{
					
					log_activity($this->current_user->id, 'Pengiriman Email ke atasan langsung untuk permintaan izin success, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}else{
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke atasan langsung untuk permintaan izin Gagal, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}
				
				// Log the activity
				log_activity($this->current_user->id, lang('surat_izin_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/surat_izin/plgcepat');
			}
			else
			{
				Template::set_message(lang('surat_izin_create_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		
		Template::set('surat_izin', $this->surat_izin_model->find($id));
		Assets::add_module_js('surat_izin', 'surat_izin.js');

		Template::set('toolbar_title', lang('surat_izin_create') . ' Surat Izin Pulang Cepat');
		Template::render();
	}
	public function tidakmasuk()
	{
		$this->auth->restrict('Surat_Izin.Kepegawaian.Create');
		$id = $this->uri->segment(5);
		if (isset($_POST['save']))
		{
			$atasan = $this->current_user->atasan;
			if($id==""){
				$insert_id = $this->save_surat_izin($atasan,"1");
			}else{
				$insert_id = $this->save_surat_izin($atasan,"1","update",$id);
			}
			if ($insert_id)
			{
				$resultmail = $this->sendmail($atasan," Selama ".$this->input->post('surat_izin_lama')." Hari, dari tanggal ".$this->input->post('surat_izin_tanggal')." sampai ".$this->input->post('surat_izin_tanggal_selesai')."<br/>Klik <a href='".base_url()."index.php/admin/kepegawaian/surat_izin/periksaizin/".$insert_id."'>link</a>"," Tidak Masuk Kerja");
			 	if ($resultmail)
				{
					
					log_activity($this->current_user->id, 'Pengiriman Email ke atasan langsung untuk permintaan izin success, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}else{
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke atasan langsung untuk permintaan izin Gagal, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}
				
				// Log the activity
				log_activity($this->current_user->id, lang('surat_izin_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/surat_izin/tidakmasuk');
			}
			else
			{
				Template::set_message(lang('surat_izin_create_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		
		Template::set('surat_izin', $this->surat_izin_model->find($id));
		Assets::add_module_js('surat_izin', 'surat_izin.js');

		Template::set('toolbar_title', lang('surat_izin_create') . ' Surat Izin Tidak Masuk Kerja');
		Template::render();
	}
	public function other()
	{
		//die($this->current_user->atasan."masuk");
		// Deleting anything?
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$data_suratizin = $this->surat_izin_model->find($pid);
					if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12" and $data_suratizin->status_atasan!=""){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}else{
						$result = $this->surat_izin_model->delete($pid);
					}
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('surat_izin_delete_success'), 'success');
				}
				else
				{
					if($data_suratizin->status_atasan!="" and $data_suratizin->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}
					else{
						Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
					}
				}
			}
		}
		$status = $this->input->get('status');
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		//$this->surat_izin_model->where('user',$this->current_user->id);
		$total = count($this->surat_izin_model->find_all($keyword,"",$status));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?";
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		//$this->surat_izin_model->where('user',$this->current_user->id);
		$records = $this->surat_izin_model->limit($limit, $offset)->find_all($keyword,"",$status);
		Template::set('total', $total); 
		Template::set('records', $records); 
		Template::set('keyword', $keyword); 
		Template::set('filter_type', "all"); 
		Template::set('status', $status); 
		Template::set('toolbar_title', 'Daftar Surat Izin');
		Template::render();
		
	}
	public function other_create()
	{
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');
		$this->auth->restrict('Surat_Izin.Kepegawaian.Other');
		$this->load->model('master_izin/master_izin_model', null, true);
		$master_izins = $this->master_izin_model->find_all();
		Template::set('master_izins', $master_izins);
		
		$this->load->model('users/user_model', null, true);
		$this->user_model->where('nip != ""');
		$this->user_model->order_by('display_name',"asc");
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		
		$id = $this->uri->segment(5);
		if (isset($_POST['save']))
		{
			$atasan = "";//$this->current_user->atasan;
			if($id==""){
				$insert_id = $this->save_other($atasan);
			}else{
				$insert_id = $this->save_other($atasan,"update",$id);
			}
			if ($insert_id)
			{
				/*
				$resultmail = $this->sendmail($atasan," Selama ".$this->input->post('surat_izin_lama')." Hari, dari tanggal ".$this->input->post('surat_izin_tanggal')." sampai ".$this->input->post('surat_izin_tanggal_selesai')."<br/>Klik <a href='".base_url()."index.php/admin/kepegawaian/surat_izin/periksaizin/".$insert_id."'>link</a>"," Tidak Masuk Kerja");
			 	if ($resultmail)
				{
					
					log_activity($this->current_user->id, 'Pengiriman Email ke atasan langsung untuk permintaan izin success, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}else{
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke atasan langsung untuk permintaan izin Gagal, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}
				*/
				// Log the activity
				log_activity($this->current_user->id, lang('surat_izin_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_create_success'), 'success');
				//redirect(SITE_AREA .'/kepegawaian/surat_izin/tidakmasuk');
			}
			else
			{
				Template::set_message(lang('surat_izin_create_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		
		Template::set('surat_izin', $this->surat_izin_model->find($id));
		Assets::add_module_js('surat_izin', 'surat_izin.js');

		Template::set('toolbar_title', lang('surat_izin_create') . ' Surat Izin Lainnya');
		Template::render();
	}
	public function sakit()
	{
		
		$this->auth->restrict('Surat_Izin.Kepegawaian.Create');
		$id = $this->uri->segment(5);
		if (isset($_POST['save']))
		{
			$atasan = $this->current_user->atasan;
			if($id==""){
				$insert_id = $this->save_surat_izin($atasan,"4");
			}else{
				$insert_id = $this->save_surat_izin($atasan,"4","update",$id);
			}
			if ($insert_id)
			{
				$resultmail = $this->sendmail($atasan," Selama ".$this->input->post('surat_izin_lama')." Hari, dari tanggal ".$this->input->post('surat_izin_tanggal')." sampai ".$this->input->post('surat_izin_tanggal_selesai')."<br/>Klik <a href='".base_url()."index.php/admin/kepegawaian/surat_izin/periksaizin/".$insert_id."'>link</a> berikut untuk membuka aplikasi semar secara otomatis"," Sakit");
			 	if ($resultmail)
				{
					
					log_activity($this->current_user->id, 'Pengiriman Email ke atasan langsung untuk permintaan izin success, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}else{
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke atasan langsung untuk permintaan izin Gagal, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}
				
				// Log the activity
				log_activity($this->current_user->id, lang('surat_izin_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/surat_izin/sakit');
			}
			else
			{
				Template::set_message(lang('surat_izin_create_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		$id = $this->uri->segment(5);
		Template::set('surat_izin', $this->surat_izin_model->find($id));
		Assets::add_module_js('surat_izin', 'surat_izin.js');

		Template::set('toolbar_title', lang('surat_izin_create') . ' Surat Izin Sakit');
		Template::render();
	}
	private function sendmail($atasan,$tambahan="",$namaizin="")
	{
	
		$user = $this->user_model->find($atasan);
		$email = "";
		if (isset($user))
		{
			$email = $user->email;
		}
		//sending mail
		$subjek       		= "Notifikasi Permintaan Izin ".$namaizin;
		$isi        	= "Anda Perlu memeriksa Permintaan Izin ".$namaizin." dari ".$this->current_user->display_name.$tambahan;
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
	 * Allows editing of Surat Izin data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('surat_izin_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/surat_izin');
		}

		if (isset($_POST['save']))
		{
			if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12" and $this->input->post('surat_izin_status_atasan')!="")
			{
				Template::set_message("Data Tidak bisa diubah", 'error');
			}else{
				$this->auth->restrict('Surat_Izin.Kepegawaian.Edit');

				if ($this->save_surat_izin("","",'update', $id))
				{
					// Log the activity
					log_activity($this->current_user->id, lang('surat_izin_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'surat_izin');

					Template::set_message(lang('surat_izin_edit_success'), 'success');
				}
				else
				{
					Template::set_message(lang('surat_izin_edit_failure') . $this->surat_izin_model->error, 'error');
				}
			}
			
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Surat_Izin.Kepegawaian.Delete');

			if ($this->surat_izin_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('surat_izin_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_delete_success'), 'success');

				redirect(SITE_AREA .'/kepegawaian/surat_izin');
			}
			else
			{
				Template::set_message(lang('surat_izin_delete_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		Template::set('surat_izin', $this->surat_izin_model->find($id));
		Template::set('toolbar_title', lang('surat_izin_edit') .' Surat Izin');
		Template::render();
	}
	public function periksa()
	{
		$id = $this->uri->segment(5);
		
		if (empty($id))
		{	
			Template::set_message(lang('surat_izin_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/surat_izin');
		}
				
		if (isset($_POST['save']))
		{
			$this->auth->restrict('Surat_Izin.Kepegawaian.Edit');
				$datadetil = $this->surat_izin_model->find($id);
				$user = $this->user_model->find($datadetil->user);
				$email = "";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Permintaan Izin";
				$isi        	= "Izin anda sudah di proses oleh ".$this->current_user->display_name;
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
			 	if ($resultmail)
				{
					
					log_activity($this->current_user->id, 'Pengiriman Email ke Pengusul untuk notifikasi permintaan izin success, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}else{
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke Pengusul untuk notifikasi permintaan izin Gagal, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}
				
			if ($this->save_periksa('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('surat_izin_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('surat_izin_edit_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		$datadetil = $this->surat_izin_model->find($id);
		//update status open ke sudah dibuka
		if($datadetil->atasan==$this->current_user->id){
			$this->surat_izin_model->skip_validation(true);
			$dataupdate = array();
			$dataupdate['status_open']        = "1";
			$return = $this->surat_izin_model->update($id,$dataupdate);
		}
		Template::set('surat_izin', $datadetil);
		Template::set('toolbar_title', lang('surat_izin_edit') .' Surat Izin');
		Template::render();
	}
	public function periksaizin()
	{
		$id = $this->uri->segment(5);
		
		if (empty($id))
		{	
			Template::set_message(lang('surat_izin_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/surat_izin');
		}
				
		if (isset($_POST['save']))
		{
			$this->auth->restrict('Surat_Izin.Kepegawaian.Edit');
				$datadetil = $this->surat_izin_model->find($id);
				$user = $this->user_model->find($datadetil->user);
				$email = "";
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Permintaan Izin";
				$isi        	= "Izin anda sudah di proses oleh ".$this->current_user->display_name;
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
			 	if ($resultmail)
				{
					log_activity($this->current_user->id, 'Pengiriman Email ke Pengusul untuk notifikasi permintaan izin success, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}else{
					//$resultmail = $this->emailer->send($dataemail,true);
					log_activity($this->current_user->id, ' Pengiriman Email ke Pengusul untuk notifikasi permintaan izin Gagal, Dari : ' . $this->input->ip_address(), 'surat_izin');
				}
				
			if ($this->save_periksa('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('surat_izin_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'surat_izin');

				Template::set_message(lang('surat_izin_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('surat_izin_edit_failure') . $this->surat_izin_model->error, 'error');
			}
		}
		$datadetil = $this->surat_izin_model->find($id);
		//update status open ke sudah dibuka
		if($datadetil->atasan==$this->current_user->id){
			$this->surat_izin_model->skip_validation(true);
			$dataupdate = array();
			$dataupdate['status_open']        = "1";
			$return = $this->surat_izin_model->update($id,$dataupdate);
		}
		Template::set('surat_izin', $datadetil);
		Template::set('toolbar_title', lang('surat_izin_edit') .' Surat Izin');
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
	private function save_surat_izin($atasan="", $izin="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$namahari = "";
		if($this->input->post('surat_izin_tanggal')!=""){
			$weekday = date('l', strtotime( $this->input->post('surat_izin_tanggal')));
			$this->load->library('convert');
			$convert = new convert();
			$namahari = $convert->getday($weekday);
		}
		
		//die($namahari);
		$satuan = $this->input->post('surat_izin_satuan');
		$this->form_validation->set_rules('surat_izin_lama','Lama','required|max_length[10]');
		if($izin!="1" and $izin!="4"){
			$this->form_validation->set_rules('surat_izin_satuan','Satuan','required|max_length[10]');
			
		}else{
			$satuan = "Hari";
		}
		
		$this->form_validation->set_rules('surat_izin_tanggal','Tanggal','required|max_length[20]');
		$this->form_validation->set_rules('surat_izin_alasan','Alasan','required|max_length[255]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		// make sure we only pass in the fields we want
		
		$data = array();
		if ($type != 'update')
		{
			$data['user']        = $this->current_user->id;
		}
		
		//$data['nip']       = $this->input->post('surat_izin_nip');
		$data['izin']        = $izin;//$this->input->post('izin');
		$data['lama']        = $this->input->post('surat_izin_lama');
		$data['satuan']      = $satuan;
		$data['hari']        = $namahari;//$this->input->post('surat_izin_hari');
		$data['tanggal']        = $this->input->post('surat_izin_tanggal') ? $this->input->post('surat_izin_tanggal') : '0000-00-00';
		$data['alasan']        = $this->input->post('surat_izin_alasan');
		$data['atasan']        = $atasan;
		$data['tanggal_selesai']        = $this->input->post('surat_izin_tanggal_selesai') ? $this->input->post('surat_izin_tanggal_selesai') : '0000-00-00';
		$data['tanggal_dibuat']        = date("Y-m-d");//$this->input->post('surat_izin_tanggal_dibuat') ? $this->input->post('surat_izin_tanggal_dibuat') : '0000-00-00';

		if ($type == 'insert')
		{
			$id = $this->surat_izin_model->insert($data);

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
			$return = $this->surat_izin_model->update($id, $data);
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
		
		$data = array();
		//$data['user']        = $this->current_user->id;//$this->input->post('surat_izin_user');
		//$data['nip']        = $this->input->post('surat_izin_nip');
		//$data['izin']        = $this->input->post('izin');
		//$data['lama']        = $this->input->post('surat_izin_lama');
		//$data['satuan']        = $this->input->post('surat_izin_satuan');
		//$data['hari']        = $this->input->post('surat_izin_hari');
		//$data['tanggal']        = $this->input->post('surat_izin_tanggal') ? $this->input->post('surat_izin_tanggal') : '0000-00-00';
		//$data['alasan']        = $this->input->post('surat_izin_alasan');
		//$data['atasan']        = $atasan;
		$data['status_atasan']        = $this->input->post('surat_izin_status_atasan');
		$data['tanggal_dibuat']        = date("Y-m-d");//$this->input->post('surat_izin_tanggal_dibuat') ? $this->input->post('surat_izin_tanggal_dibuat') : '0000-00-00';
		$data['alasan_ditolak']        = $this->input->post('alasan_ditolak');
		if($this->input->post('surat_izin_catatan')!=""){
			$data['catatan']        = $this->input->post('surat_izin_catatan');
		}
		if ($type == 'insert')
		{
			$id = $this->surat_izin_model->insert($data);

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
			$return = $this->surat_izin_model->update($id, $data);
		}

		return $return;
	}
	private function save_other($atasan="", $type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		//die($this->input->post('sppd_jabodetabek_pegawai')." ini");
		$data = array();
		$data['user']        = $this->input->post('sppd_jabodetabek_pegawai');
		$data['nip']        = $this->input->post('surat_izin_nip');
		$data['izin']        = $this->input->post('surat_izin_izin');
		$data['lama']        = $this->input->post('surat_izin_lama');
		//$data['satuan']        = $this->input->post('surat_izin_satuan');
		//$data['hari']        = $this->input->post('surat_izin_hari');
		$data['tanggal']        = $this->input->post('surat_izin_tanggal') ? $this->input->post('surat_izin_tanggal') : '0000-00-00';
		$data['tanggal_selesai']        = $this->input->post('surat_izin_tanggal_selesai') ? $this->input->post('surat_izin_tanggal_selesai') : '0000-00-00';
		$data['alasan']        = $this->input->post('surat_izin_alasan');
		$data['atasan']        = $atasan;
		$data['status_atasan']        = "1";$this->input->post('surat_izin_status_atasan');
		$data['tanggal_dibuat']        = date("Y-m-d");//$this->input->post('surat_izin_tanggal_dibuat') ? $this->input->post('surat_izin_tanggal_dibuat') : '0000-00-00';
		//$data['alasan_ditolak']        = $this->input->post('alasan_ditolak');
		//if($this->input->post('surat_izin_catatan')!=""){
		//	$data['catatan']        = $this->input->post('surat_izin_catatan');
		//}
		if ($type == 'insert')
		{
			$id = $this->surat_izin_model->insert($data);

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
			$return = $this->surat_izin_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}