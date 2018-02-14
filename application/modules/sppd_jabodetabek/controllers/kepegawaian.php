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

		$this->auth->restrict('SPPD_Jabodetabek.Kepegawaian.View');
		$this->load->model('sppd_jabodetabek_model', null, true);
		$this->load->model('sppd_jabodetabek/sppd_pengikut_model', null, true);
		$this->lang->load('sppd_jabodetabek');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');

		Assets::add_module_js('sppd_jabodetabek', 'sppd_jabodetabek.js');
		
		$this->load->model('pejabat_pemberi_perintah/pejabat_pemberi_perintah_model', null, true);
		$ppps = $this->pejabat_pemberi_perintah_model->find_all();
		Template::set('ppps', $ppps);
		$this->load->model('users/user_model', null, true);
		$this->user_model->where('nip != ""');
		$this->user_model->order_by('display_name',"asc");
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		
		
		$this->load->model('pegawai/pegawai_model', null, true);
		$pegawais = $this->pegawai_model->find_all();
		Template::set('pegawais', $pegawais);
		
		$this->load->model('kegiatan/kegiatan_model', null, true);
		$this->user_model->where('tahun',date("Y"));
		$kegiatans = $this->kegiatan_model->find_all();
		Template::set('kegiatans', $kegiatans);
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
					$data_sppd = $this->sppd_jabodetabek_model->find($pid);
					if($data_sppd->status_atasan!="" and $data_sppd->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'success');
						//Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}else{
						$result = $this->sppd_jabodetabek_model->delete($pid);
						$data = array('kode_sppd '=>$pid);
						$this->sppd_pengikut_model->delete_where($data);
					}
					
					
					
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('sppd_jabodetabek_delete_success'), 'success');
				}
				else
				{
					if($data_sppd->status_atasan!="" and $data_sppd->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'success');
						 
					}
					else{
						Template::set_message(lang('sppd_jabodetabek_delete_failure') . $this->sppd_jabodetabek_model->error, 'error');
					}
					
				}
			}
		}

		// die($this->current_user->nip." ini");
		$bulan = $this->input->get('bulan');
		$keyword = $this->input->get('keyword');
		$tahun = $this->input->get('tahun') != "" ? $this->input->get('tahun') : date("Y");
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20")
		{
			$this->sppd_jabodetabek_model->or_where('pegawai',$this->current_user->nip);
			$this->sppd_jabodetabek_model->or_where('sppd_pengikut.id_user',$this->current_user->id);
		}
		$total = count($this->sppd_jabodetabek_model->find_search($keyword,$bulan,$tahun));
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&bulan=".$bulan."&tahun=".$tahun;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20")
		{
			$this->sppd_jabodetabek_model->or_where('pegawai',$this->current_user->nip);
			$this->sppd_jabodetabek_model->or_where('sppd_pengikut.id_user',$this->current_user->id);
		}
		$records = $this->sppd_jabodetabek_model->limit($limit, $offset)->find_search($keyword,$bulan,$tahun);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('bulan', $bulan); 
		Template::set('tahun', $tahun); 
		Template::set('keyword', $keyword); 
		
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage SPPD Jabodetabek');
		Template::render();
	}
	public function listsppd()
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
					
					$result = $this->sppd_jabodetabek_model->delete($pid);
					$data = array('kode_sppd '=>$pid);
					$this->sppd_pengikut_model->delete_where($data);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('sppd_jabodetabek_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('sppd_jabodetabek_delete_failure') . $this->sppd_jabodetabek_model->error, 'error');
				}
			}
		}

		 
		$bulan = $this->input->get('bulan');
		$keyword = $this->input->get('keyword');
		$tahun = $this->input->get('tahun');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->sppd_jabodetabek_model->or_where('pegawai',$this->current_user->id);
			$this->sppd_jabodetabek_model->or_where('sppd_pengikut.id_user',$this->current_user->id);
		}
		$total = count($this->sppd_jabodetabek_model->find_search($keyword,$bulan,$tahun));
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&bulan=".$bulan."&tahun=".$tahun;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->sppd_jabodetabek_model->or_where('pegawai',$this->current_user->id);
			$this->sppd_jabodetabek_model->or_where('sppd_pengikut.id_user',$this->current_user->id);
		}
		$records = $this->sppd_jabodetabek_model->limit($limit, $offset)->find_search($keyword,$bulan,$tahun);
		if(isset($records) && is_array($records) && count($records) && $total>0)
			$total = $total;
		else
			$total = 0;
		Template::set('total', $total); 
		Template::set('bulan', $bulan); 
		Template::set('tahun', $tahun); 
		Template::set('keyword', $keyword); 
		
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage SPPD Jabodetabek');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a SPPD Jabodetabek object.
	 *
	 * @return void
	 */
	public function getpeserta()
	{
		$kode = $this->input->post('kode');
		$this->load->model('users/user_model', null, true);
		$this->user_model->where('nip != ""');
		$this->user_model->order_by('display_name',"asc");
		$users = $this->user_model->find_all(); 
		$output="";
			$output .= $this->load->view('kepegawaian/dinamic',array('users'=>$users),true);	
		 
		echo $output;
		die();
	}
	public function create()
	{
		$this->auth->restrict('SPPD_Jabodetabek.Kepegawaian.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_sppd_jabodetabek())
			{
				$pengikut = $this->input->post('pengikut');
				if(isset($_POST['pengikut'])){
					 
					foreach($this->input->post("pengikut") as $value )
					{
						$this->save_pengikut($insert_id,$value);
					}
				}
				// Log the activity
				log_activity($this->current_user->id, lang('sppd_jabodetabek_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'sppd_jabodetabek');

				Template::set_message(lang('sppd_jabodetabek_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/sppd_jabodetabek/edit/'.$insert_id);
			}
			else
			{
				Template::set_message(lang('sppd_jabodetabek_create_failure') . $this->sppd_jabodetabek_model->error, 'error');
			}
		}
		Assets::add_module_js('sppd_jabodetabek', 'sppd_jabodetabek.js');

		Template::set('toolbar_title', lang('sppd_jabodetabek_create') . ' SPPD Jabodetabek');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of SPPD Jabodetabek data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('sppd_jabodetabek_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/sppd_jabodetabek');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('SPPD_Jabodetabek.Kepegawaian.Edit');

			if ($this->save_sppd_jabodetabek('update', $id))
			{
				// delete pengikut
				$datadel = array('kode_sppd '=>$id);
				$this->sppd_pengikut_model->delete_where($datadel);
						
				// save pengikut 
				$pengikut = $this->input->post('pengikut');
				if(isset($_POST['pengikut'])){
					 
					foreach($this->input->post("pengikut") as $value )
					{
						$this->save_pengikut($id,$value);
					}
				}
				// Log the activity
				log_activity($this->current_user->id, lang('sppd_jabodetabek_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'sppd_jabodetabek');

				Template::set_message(lang('sppd_jabodetabek_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('sppd_jabodetabek_edit_failure') . $this->sppd_jabodetabek_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('SPPD_Jabodetabek.Kepegawaian.Delete');

			if ($this->sppd_jabodetabek_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('sppd_jabodetabek_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'sppd_jabodetabek');

				Template::set_message(lang('sppd_jabodetabek_delete_success'), 'success');

				redirect(SITE_AREA .'/kepegawaian/sppd_jabodetabek');
			}
			else
			{
				Template::set_message(lang('sppd_jabodetabek_delete_failure') . $this->sppd_jabodetabek_model->error, 'error');
			}
		}
		$data = $this->sppd_jabodetabek_model->find($id);
		//$id_pegawai = $data->pegawai;
		//$datadetil = $this->pegawai_model->find_bynip("nip",$id_pegawai);
		
		$datapengikut = $this->sppd_pengikut_model->find_byidsppd($id);
		Template::set('data_pengikut', $datapengikut);
		
		Template::set('id', $id);
		Template::set('sppd_jabodetabek', $data);
		//Template::set('datadetil', $datadetil);
		Template::set('toolbar_title', lang('sppd_jabodetabek_edit') .' SPPD Jabodetabek');
		Template::render();
	}
	public function periksa()
	{
		$id = $this->uri->segment(5);
		if (empty($id))
		{
			Template::set_message(lang('sppd_jabodetabek_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/sppd_jabodetabek/periksa');
		}
		if (isset($_POST['save']))
		{
			$this->auth->restrict('SPPD_Jabodetabek.Kepegawaian.Edit');

			if ($this->save_sppd_jabodetabek('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('sppd_jabodetabek_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'sppd_jabodetabek');
				Template::set_message(lang('sppd_jabodetabek_edit_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/sppd_jabodetabek/listsppd');
			}
			else
			{
				Template::set_message(lang('sppd_jabodetabek_edit_failure') . $this->sppd_jabodetabek_model->error, 'error');
			}
		}
		$data = $this->sppd_jabodetabek_model->find($id);
		//print_r($data);
		$id_pegawai = $data->pegawai;
		$datadetil = $this->user_model->find($id_pegawai);
		if( isset($datadetil) ) {
			$datadetil = (array)$datadetil;
		}
		$datapengikut = $this->sppd_pengikut_model->find_byidsppd($id);
		Template::set('data_pengikut', $datapengikut);
		
		Template::set('id', $id);
		Template::set('sppd_jabodetabek', $data);
		Template::set('datadetil', $datadetil);
		Template::set('toolbar_title', lang('sppd_jabodetabek_edit') .' SPPD Jabodetabek');
		Template::render();
	}
	public function printsppd()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('sppd_jabodetabek_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/sppd_jabodetabek');
		}
		$datapengikut = $this->sppd_pengikut_model->find_byidsppd($id);
		Template::set('data_pengikut', $datapengikut);
		
		$data = $this->sppd_jabodetabek_model->find_detil($id);
		
		Template::set('id', $id);
		Template::set('sppd_jabodetabek', $data);
		//Template::set('datadetil', $datadetil);
		Template::set('toolbar_title', lang('sppd_jabodetabek_edit') .' SPPD Jabodetabek');
		Template::set_theme('print');
		
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
	
	private function save_sppd_jabodetabek($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$namahari = "";
		if($this->input->post('sppd_jabodetabek_tanggal_berangkat')!=""){
			$weekday = date('l', strtotime( $this->input->post('sppd_jabodetabek_tanggal_berangkat')));
			$this->load->library('convert');
			$convert = new convert();
			$namahari = $convert->getday($weekday);
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['pejabat']        = $this->input->post('sppd_jabodetabek_pejabat');
		$data['pegawai']        = $this->input->post('sppd_jabodetabek_pegawai');
		
		$data['sppd_pangkat']        = $this->input->post('pangkat');
		$data['sppd_golongan']        = $this->input->post('golongan');
		$data['sppd_jabatan']        = $this->input->post('jabatan');
		
		$data['maksud']        	= $this->input->post('sppd_jabodetabek_maksud');
		$data['anggaran']       = $this->input->post('sppd_jabodetabek_anggaran');
		$data['no_keg']        	= $this->input->post('sppd_jabodetabek_no_keg');
		$data['judul']        	= $this->input->post('sppd_jabodetabek_judul');
		$data['angkutan']        = $this->input->post('sppd_jabodetabek_angkutan');
		$data['tempat_berangkat']        = $this->input->post('sppd_jabodetabek_tempat_berangkat');
		$data['instansi_tujuan']        = $this->input->post('sppd_jabodetabek_instansi_tujuan');
		$data['tanggal_berangkat']        = $this->input->post('sppd_jabodetabek_tanggal_berangkat') ? $this->input->post('sppd_jabodetabek_tanggal_berangkat') : '0000-00-00';
		$data['sampai_tanggal']        = $this->input->post('sampai_tanggal') ? $this->input->post('sampai_tanggal') : '0000-00-00';
		$data['hari']        = $namahari;
		$data['jam_berangkat']        = $this->input->post('sppd_jabodetabek_jam_berangkat');
		$data['pengemudi']        = $this->input->post('sppd_jabodetabek_pengemudi');
		if($this->input->post('status_atasan')!="")
			$data['status_atasan']        = $this->input->post('status_atasan');
		if($this->input->post('alasan_ditolak')!="")
			$data['alasan_ditolak']       = $this->input->post('alasan_ditolak');

		if ($type == 'insert')
		{
			$id = $this->sppd_jabodetabek_model->insert($data);

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
			$return = $this->sppd_jabodetabek_model->update($id, $data);
		}

		return $return;
	}
	private function save_pengikut($kode_sppd="",$id_user="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		// make sure we only pass in the fields we want
		
		$data = array();
		$data['kode_sppd']        = $kode_sppd;
		$data['id_user']        = $id_user;
		 

		if ($type == 'insert')
		{
			$id = $this->sppd_pengikut_model->insert($data);

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
			$return = $this->sppd_pengikut_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}