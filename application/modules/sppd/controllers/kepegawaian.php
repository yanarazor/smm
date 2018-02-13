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

		$this->auth->restrict('Sppd.Kepegawaian.View');
		$this->load->model('Sppd_model', null, true);
		$this->lang->load('sppd');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');

		Assets::add_module_js('sppd', 'sppd.js');
		
		$this->load->model('pejabat_pemberi_perintah/pejabat_pemberi_perintah_model', null, true);
		$ppps = $this->pejabat_pemberi_perintah_model->find_all();
		Template::set('ppps', $ppps);
		$this->load->model('users/user_model', null, true);
		$this->user_model->where('nip != ""');
		$this->user_model->order_by('display_name',"asc");
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		
		$this->load->model('kegiatan/kegiatan_model', null, true);
		$this->user_model->where('tahun',date("Y"));
		$kegiatans = $this->kegiatan_model->find_all();
		Template::set('kegiatans', $kegiatans);
		
		$this->load->model('sppd/propinsi_model', null, true);
		$propinsis = $this->propinsi_model->find_all();
		Template::set('propinsis', $propinsis);
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
					$data_sppd = $this->Sppd_model->find($pid);
					if($data_sppd->status_atasan!="" and $data_sppd->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'success');
						//Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'error');
					}else{
						$result = $this->Sppd_model->delete($pid);
						
					}
					
					
					
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('Sppd_delete_success'), 'success');
				}
				else
				{
					if($data_sppd->status_atasan!="" and $data_sppd->status_atasan!="0"){
						Template::set_message("Data tidak bisa dihapus karena sudah melewati Proses Persetujuan", 'success');
						 
					}
					else{
						Template::set_message(lang('Sppd_delete_failure') . $this->Sppd_model->error, 'error');
					}
					
				}
			}
		}

		 
		$bulan = $this->input->get('bulan');
		$keyword = $this->input->get('keyword');
		$tahun = $this->input->get('tahun');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20")
		{
			$this->Sppd_model->or_where('pegawai',$this->current_user->id);
		}
		$total = count($this->Sppd_model->find_search($keyword,$bulan,$tahun));
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&bulan=".$bulan."&tahun=".$tahun;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "20")
		{
			$this->Sppd_model->or_where('pegawai',$this->current_user->id);
		}
		$records = $this->Sppd_model->limit($limit, $offset)->find_search($keyword,$bulan,$tahun);
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
				 

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('Sppd_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('Sppd_delete_failure') . $this->Sppd_model->error, 'error');
				}
			}
		}

		 
		$bulan = $this->input->get('bulan');
		$keyword = $this->input->get('keyword');
		$tahun = $this->input->get('tahun');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->Sppd_model->or_where('pegawai',$this->current_user->id);
			$this->Sppd_model->or_where('sppd_pengikut.id_user',$this->current_user->id);
		}
		$total = count($this->Sppd_model->find_search($keyword,$bulan,$tahun));
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&bulan=".$bulan."&tahun=".$tahun;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->Sppd_model->or_where('pegawai',$this->current_user->id);
			$this->Sppd_model->or_where('sppd_pengikut.id_user',$this->current_user->id);
		}
		$records = $this->Sppd_model->limit($limit, $offset)->find_search($keyword,$bulan,$tahun);
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
		$this->auth->restrict('Sppd.Kepegawaian.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_Sppd())
			{
				 
				// Log the activity
				log_activity($this->current_user->id, lang('Sppd_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'Sppd');

				Template::set_message(lang('sppd_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/sppd/edit/'.$insert_id);
			}
			else
			{
				Template::set_message(lang('Sppd_create_failure') . $this->Sppd_model->error, 'error');
			}
		}
		Assets::add_module_js('sppd', 'sppd.js');

		Template::set('toolbar_title',  'Buat SPPD');
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
			Template::set_message(lang('sppd_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/Sppd');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Sppd.Kepegawaian.Edit');

			if ($this->save_Sppd('update', $id))
			{
				 
				// Log the activity
				log_activity($this->current_user->id, lang('sppd_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'Sppd');

				Template::set_message("Update SPPD SUkses", 'success');
			}
			else
			{
				Template::set_message(lang('sppd_edit_failure') . $this->Sppd_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Sppd.Kepegawaian.Delete');

			if ($this->Sppd_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, 'Delete Sukses id : '. $id .' : '. $this->input->ip_address(), 'Sppd');

				Template::set_message("Delete sukses", 'success');

				redirect(SITE_AREA .'/kepegawaian/sppd');
			}
			else
			{
				Template::set_message(lang('sppd_delete_failure') . $this->Sppd_model->error, 'error');
			}
		}
		$data = $this->Sppd_model->find($id);
		$id_pegawai = $data->pegawai;
		$datadetil = $this->user_model->find($id_pegawai);
		
		if( isset($datadetil) ) {
			$datadetil = (array)$datadetil;
		}
		 
		Template::set('id', $id);
		Template::set('sppd', $data);
		Template::set('datadetil', $datadetil);
		Template::set('toolbar_title', 'Edit SPPD');
		Template::render();
	}
	public function periksa()
	{
		$id = $this->uri->segment(5);
		if (empty($id))
		{
			Template::set_message(lang('sppd_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/Sppd/periksa');
		}
		if (isset($_POST['save']))
		{
			$this->auth->restrict('Sppd.Kepegawaian.Periksa');

			if ($this->save_periksa('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, 'Verifikasi Sppd sukses: '. $id .' : '. $this->input->ip_address(), 'Sppd');
				Template::set_message("Sukses Verifikasi data", 'success');
				redirect(SITE_AREA .'/kepegawaian/sppd/periksa/'.$id);
			}
			else
			{
				Template::set_message(lang('sppd_edit_failure') . $this->Sppd_model->error, 'error');
			}
		}
		$data = $this->Sppd_model->find($id);
		 
		$id_pegawai = $data->pegawai;
		$datadetil = $this->user_model->find($id_pegawai);
		if( isset($datadetil) ) {
			$datadetil = (array)$datadetil;
		}
		 
		Template::set('id', $id);
		Template::set('sppd', $data);
		Template::set('datadetil', $datadetil);
		Template::set('toolbar_title', 'Edit SPPD');
		Template::render();
	}
	public function printsppd()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('sppd_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/Sppd');
		}
		 
		$data = $this->Sppd_model->find_detil($id);
		$id_pegawai = $data->pegawai;
		$datadetil = $this->user_model->find($id_pegawai);
		if( isset($datadetil) ) {
			$datadetil = (array)$datadetil;
		}
		Template::set('id', $id);
		Template::set('sppd', $data);
		Template::set('datadetil', $datadetil);
		Template::set('toolbar_title', lang('sppd_edit') .' SPPD Jabodetabek');
		Template::set_theme('print');
		
		Template::render();
	}
	public function reprintsppd()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('sppd_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/Sppd');
		}
		 
		$data = $this->Sppd_model->find_detil($id);
		$id_pegawai = $data->pegawai;
		$datadetil = $this->user_model->find($id_pegawai);
		if( isset($datadetil) ) {
			$datadetil = (array)$datadetil;
		}
		Template::set('id', $id);
		Template::set('sppd', $data);
		Template::set('datadetil', $datadetil);
		Template::set('toolbar_title', lang('sppd_edit') .' SPPD Jabodetabek');
		Template::set_theme('print');
		
		Template::render();
	}
	public function createlaporan()
	{
		$id = $this->uri->segment(5);
		$data = $this->Sppd_model->find($id);
		Template::set('id', $id);
		Template::set('sppd', $data);
		$this->auth->restrict('Sppd.Kepegawaian.Create');
		Template::set('toolbar_title', 'Buat Laporan SPD');
		Template::render();
	}
	public function savelaporan(){
        
        if ($this->input->post("laporan_perjalanan_text") == "") {
            $response['msg'] = "
            <div class='alert alert-block alert-error fade in'>
                <a class='close' data-dismiss='alert'>&times;</a>
                <h4 class='alert-heading'>
                    Error
                </h4>
                Silahkan isi laporan perjalanan
            </div>
            ";
            echo json_encode($response);
            exit();
        }
        
        
        $id_data = $this->input->post("id");
        if(isset($id_data) && !empty($id_data)){
        	$dataupdate = array();//$this->sppd_model->prep_data($this->input->post());
       		$dataupdate["laporan_perjalanan_text"] = $this->input->post("laporan_perjalanan_text");
       		$this->Sppd_model->update($id_data, $dataupdate);
        }
        
        $response ['success']= true;
        $response ['msg']= "Laporan berhasil disimpan";
        echo json_encode($response);    

    }
    public function printlaporan()
	{
		$this->load->model('pegawai/pegawai_model', null, true);
		$id = $this->uri->segment(5);
		$first = $this->uri->segment(6);
		if (empty($id))
		{
			Template::set_message(lang('sppd_jabodetabek_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/sppd_jabodetabek');
		}
		
		$data = $this->Sppd_model->find_detilspd($id);
		$id_pegawai = $data->pegawai;
		$anggaran = isset($data->no_keg) ? $data->no_keg : "";
		$datadetil = $this->pegawai_model->find($id_pegawai);
		if( isset($datadetil) ) {
			$datadetil = (array)$datadetil;
		}
		//die($data->pj." ini");
		$penanggungjawabs = $this->pegawai_model->find_by("no_absen",$data->pj);
		Template::set('penanggungjawabs', $penanggungjawabs);
		
		$this->kegiatan_model->where('tahun',date("Y"));
		$kegiatans = $this->kegiatan_model->find_all("","",$anggaran);
		Template::set('kegiatans', $kegiatans);
		 
		Template::set('id', $id);
		Template::set('sppd_jabodetabek', $data);
		Template::set_theme('print');
		Template::set('toolbar_title','Cetak Laporan SPD');
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
	
	private function save_Sppd($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$namahari = "";
		if($this->input->post('Sppd_tanggal_berangkat')!=""){
			$weekday = date('l', strtotime( $this->input->post('Sppd_tanggal_berangkat')));
			$this->load->library('convert');
			$convert = new convert();
			$namahari = $convert->getday($weekday);
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['pejabat']        = $this->input->post('sppd_pejabat');
		$data['pegawai']        = $this->input->post('sppd_pegawai');
		$data['maksud']        	= $this->input->post('sppd_maksud');
		$data['anggaran']       = $this->input->post('sppd_anggaran');
		$data['no_keg']        	= $this->input->post('sppd_no_keg');
		$data['judul']        	= $this->input->post('sppd_judul');
		$data['angkutan']        = $this->input->post('sppd_angkutan');
		
		$data['tempat_berangkat']        = $this->input->post('sppd_tempat_berangkat');
		$data['instansi_tujuan']        = $this->input->post('sppd_instansi_tujuan');
		$data['tanggal_berangkat']        = $this->input->post('sppd_tanggal_berangkat') ? $this->input->post('sppd_tanggal_berangkat') : '0000-00-00';
		$data['tanggal_kembali']        = $this->input->post('tanggal_kembali') ? $this->input->post('tanggal_kembali') : '0000-00-00';
		$data['hari']        = $namahari;
		$data['jam_berangkat']        = $this->input->post('sppd_jam_berangkat');
		$data['pengemudi']        = $this->input->post('sppd_pengemudi');
		$data['provinsi']        = $this->input->post('provinsi');
		$data['lama']        = $this->input->post('lama');
		
		// tiba II
		$data['tibadi_II']        = $this->input->post('tibadi_II');
		$data['tiba_tanggal_II']        = $this->input->post('tiba_tanggal_II') ? $this->input->post('tiba_tanggal_II') : '0000-00-00';
		$data['tiba_kepala_II']        = $this->input->post('tiba_kepala_II');
		$data['tiba_nama_II']        = $this->input->post('tiba_nama_II');
		$data['tiba_nip_II']        = $this->input->post('tiba_nip_II');
		// Berangkat II
		$data['berangkatdi_II']        = $this->input->post('berangkatdi_II');
		$data['berangkat_tanggal_II']        = $this->input->post('berangkat_tanggal_II') ? $this->input->post('berangkat_tanggal_II') : '0000-00-00';
		$data['berangkat_kepala_II']        = $this->input->post('berangkat_kepala_II');
		$data['berangkat_nama_II']        = $this->input->post('berangkat_nama_II');
		$data['berangkat_nip_II']        = $this->input->post('berangkat_nip_II');
		// tiba III
		$data['tibadi_III']        = $this->input->post('tibadi_III');
		$data['tiba_tanggal_III']        = $this->input->post('tiba_tanggal_III') ? $this->input->post('tiba_tanggal_III') : '0000-00-00';
		$data['tiba_kepala_III']        = $this->input->post('tiba_kepala_III');
		$data['tiba_nama_III']        = $this->input->post('tiba_nama_III');
		$data['tiba_nip_III']        = $this->input->post('tiba_nip_III');
		// berangkat III
		$data['berangkatdi_III']        = $this->input->post('berangkatdi_III');
		$data['berangkat_tanggal_III']        = $this->input->post('berangkat_tanggal_III') ? $this->input->post('berangkat_tanggal_III') : '0000-00-00';
		$data['berangkat_kepala_III']        = $this->input->post('berangkat_kepala_III');
		$data['berangkat_nama_III']        = $this->input->post('berangkat_nama_III');
		$data['berangkat_nip_III']        = $this->input->post('berangkat_nip_III');
		// tiba IV
		$data['tibadi_IV']        = $this->input->post('tibadi_IV');
		$data['tiba_tanggal_IV']        = $this->input->post('tiba_tanggal_IV') ? $this->input->post('tiba_tanggal_IV') : '0000-00-00';
		$data['tiba_kepala_IV']        = $this->input->post('tiba_kepala_IV');
		$data['tiba_nama_IV']        = $this->input->post('tiba_nama_IV');
		$data['tiba_nip_IV']        = $this->input->post('tiba_nip_IV');
		//berangkat IV
		$data['berangkatdi_IV']        = $this->input->post('berangkatdi_IV');
		$data['berangkat_tanggal_IV']        = $this->input->post('berangkat_tanggal_IV') ? $this->input->post('berangkat_tanggal_IV') : '0000-00-00';
		$data['berangkat_kepala_IV']        = $this->input->post('berangkat_kepala_IV');
		$data['berangkat_nama_IV']        = $this->input->post('berangkat_nama_IV');
		$data['berangkat_nip_IV']        = $this->input->post('berangkat_nip_IV');
		
		// tiba V
		$data['tibadi_V']        = $this->input->post('tibadi_V');
		$data['tiba_tanggal_V']        = $this->input->post('tiba_tanggal_V') ? $this->input->post('tiba_tanggal_V') : '0000-00-00';
		$data['tiba_kepala_V']        = $this->input->post('tiba_kepala_V');
		$data['tiba_nama_V']        = $this->input->post('tiba_nama_V');
		$data['tiba_nip_V']        = $this->input->post('tiba_nip_V');
		 
		if($this->input->post('status_atasan')!="")
			$data['status_atasan']        = $this->input->post('status_atasan');
		if($this->input->post('alasan_ditolak')!="")
			$data['alasan_ditolak']       = $this->input->post('alasan_ditolak');

		if ($type == 'insert')
		{
			$id = $this->Sppd_model->insert($data);

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
			$return = $this->Sppd_model->update($id, $data);
		}

		return $return;
	}
	private function save_periksa($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$namahari = "";
		if($this->input->post('Sppd_tanggal_berangkat')!=""){
			$weekday = date('l', strtotime( $this->input->post('Sppd_tanggal_berangkat')));
			$this->load->library('convert');
			$convert = new convert();
			$namahari = $convert->getday($weekday);
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['pejabat']        = $this->input->post('sppd_pejabat');
		$data['pegawai']        = $this->input->post('sppd_pegawai');
		$data['maksud']        	= $this->input->post('sppd_maksud');
		$data['anggaran']       = $this->input->post('sppd_anggaran');
		$data['no_keg']        	= $this->input->post('sppd_no_keg');
		$data['judul']        	= $this->input->post('sppd_judul');
		$data['angkutan']        = $this->input->post('sppd_angkutan');
		$data['tempat_berangkat']        = $this->input->post('sppd_tempat_berangkat');
		$data['instansi_tujuan']        = $this->input->post('sppd_instansi_tujuan');
		$data['tanggal_berangkat']        = $this->input->post('sppd_tanggal_berangkat') ? $this->input->post('sppd_tanggal_berangkat') : '0000-00-00';
		$data['tanggal_kembali']        = $this->input->post('tanggal_kembali') ? $this->input->post('tanggal_kembali') : '0000-00-00';
		$data['hari']        = $namahari;
		$data['jam_berangkat']        = $this->input->post('sppd_jam_berangkat');
		$data['pengemudi']        = $this->input->post('sppd_pengemudi');
		$data['provinsi']        = $this->input->post('provinsi');
		$data['lama']        = $this->input->post('lama');
		

		if($this->input->post('status_atasan')!="")
			$data['status_atasan']        = $this->input->post('status_atasan');
		if($this->input->post('alasan_ditolak')!="")
			$data['alasan_ditolak']       = $this->input->post('alasan_ditolak');
		if($this->input->post('status_pj')!="")
			$data['status_pj']       = $this->input->post('status_pj');


		if($this->input->post('real_transport')!="")
			$data['real_transport']       = $this->input->post('real_transport');
		if($this->input->post('ket_real_transport')!="")
			$data['ket_real_transport']       = $this->input->post('ket_real_transport');
		if($this->input->post('real_penginapan')!="")
			$data['real_penginapan']       = $this->input->post('real_penginapan');
		if($this->input->post('ket_real_penginapan')!="")
			$data['ket_real_penginapan']       = $this->input->post('ket_real_penginapan');
		if($this->input->post('status_spj')!="")
			$data['status_spj']       = $this->input->post('status_spj');

		if($this->input->post('tgl_sp2d')!="")
			$data['tgl_sp2d']       = $this->input->post('tgl_sp2d');
		

		//	if($this->input->post('transport_jml')!="")
				$data['transport_jml']	= $this->input->post('transport_jml');	
		//	if($this->input->post('transport_satu')!="")
				$data['transport_satu']       = $this->input->post('transport_satu');	
				
		//	if($this->input->post('transport')!="")
				$data['transport']       		= $this->input->post('transport');	
		//	if($this->input->post('ket_transport')!="")
				$data['ket_transport']       		= $this->input->post('ket_transport');	
			
	//		if($this->input->post('harian_jml')!="")
				$data['harian_jml']	= $this->input->post('harian_jml');	
	//		if($this->input->post('harian_satu')!="")
				$data['harian_satu']       = $this->input->post('harian_satu');	
				
	//		if($this->input->post('uang_harian')!="")
				$data['uang_harian']       		= $this->input->post('uang_harian');	
	//		if($this->input->post('ket_uang_harian')!="")
				$data['ket_uang_harian']       		= $this->input->post('ket_uang_harian');	
			
	//		if($this->input->post('penginapan_jml')!="")
				$data['penginapan_jml']	= $this->input->post('penginapan_jml');	
	//		if($this->input->post('penginapan_satu')!="")
				$data['penginapan_satu']       = $this->input->post('penginapan_satu') != "" ? $this->input->post('penginapan_satu') : 0;		
				
	//		if($this->input->post('biaya_penginapan')!="")
				$data['biaya_penginapan']       		= $this->input->post('biaya_penginapan') != "" ? $this->input->post('biaya_penginapan') : 0;		
	//		if($this->input->post('ket_biaya_penginapan')!="")
				$data['ket_biaya_penginapan']       		= $this->input->post('ket_biaya_penginapan');	
			
	//		if($this->input->post('representasi_jml')!="")
				$data['representasi_jml']	= $this->input->post('representasi_jml');	
	//		if($this->input->post('representasi_satu')!="")
				$data['representasi_satu']       = $this->input->post('representasi_satu') != "" ? $this->input->post('representasi_satu') : 0;		
				
	//		if($this->input->post('representasi')!="")
				$data['representasi']       		= $this->input->post('representasi') != "" ? $this->input->post('representasi') : 0;		
	//		if($this->input->post('ket_representasi')!="")
				$data['ket_representasi']       		= $this->input->post('ket_representasi');	
	//		if($this->input->post('lain_lain')!="")
				$data['lain_lain']       		= $this->input->post('lain_lain') != "" ? $this->input->post('lain_lain') : 0;	
	//		if($this->input->post('ket_lain_lain')!="")
				$data['ket_lain_lain']       		= $this->input->post('ket_lain_lain');	
				
				
	//		if($this->input->post('real_transport')!="")
				$data['real_transport']       		= $this->input->post('real_transport') != "" ? $this->input->post('real_transport') : 0;	
	//		if($this->input->post('ket_real_transport')!="")
				$data['ket_real_transport']       		= $this->input->post('ket_real_transport');	
	//		if($this->input->post('real_penginapan')!="")
				$data['real_penginapan']       		= $this->input->post('real_penginapan') != "" ? $this->input->post('real_penginapan') : 0;	
			//if($this->input->post('ket_real_penginapan')!="")
				$data['ket_real_penginapan']       		= $this->input->post('ket_real_penginapan');	

		if ($type == 'insert')
		{
			$id = $this->Sppd_model->insert($data);

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
			$return = $this->Sppd_model->update($id, $data);
		}

		return $return;
	}
	public function printkuitansi()
	{
		$id = $this->uri->segment(5);
		if (empty($id))
		{
			Template::set_message(lang('sppd_jabodetabek_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/sppd');
		}
		 
		$datadetil = $this->Sppd_model->find_detilspd($id);
		 
		// PPK
		$ppk = isset($datadetil->pejabat) ? $datadetil->pejabat : "";
		$ppks = $this->pejabat_pemberi_perintah_model->find($ppk);
		Template::set('ppks', $ppks);
		
		$this->load->model('pegawai/pegawai_model', null, true);
		$bendaharas = $this->pegawai_model->find_by("no_absen",$this->settings_lib->item('site.bendahara'));
		Template::set('bendaharas', $bendaharas);
		
		Template::set('id', $id);
		Template::set('sppd', $datadetil);
		Template::set('toolbar_title',' Print Kuitansi SPD');
		Template::set_theme('print');
		
		Template::render();
	}

	//--------------------------------------------------------------------


}