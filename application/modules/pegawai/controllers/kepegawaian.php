<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * masters controller
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

		
		$this->load->model('pegawai_model', null, true);
		$this->lang->load('pegawai');
		
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');
		$this->load->model('jabatan/jabatan_model', null, true);
		$jabatans = $this->jabatan_model->find_all();
		Template::set('jabatans', $jabatans);
		
		$this->load->model('pangkat/pangkat_model', null, true);
		$golongans = $this->pangkat_model->find_all();
		Template::set('golongans', $golongans);
		
		Assets::add_module_js('pegawai', 'pegawai.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->auth->restrict('Pegawai.Kepegawaian.View');
		$this->load->model('surat_izin/surat_izin_model', null, true);
		$datacutis 		= array(); 
		$tahun = date("Y");
		//$this->surat_izin_model->where('user',$this->current_user->id);
		$recordcuti  	= $this->surat_izin_model->getjmlizincuti($tahun,"13");
		if(isset($recordcuti) && is_array($recordcuti) && count($recordcuti)):
			foreach ($recordcuti as $record) :
					$datacutis[$record->user] = $record->jumlah; 
			endforeach;
		endif;
		Template::set('datacutis', $datacutis);
		//print_r($datacutis); 
		//die();
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->pegawai_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('pegawai_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('pegawai_delete_failure') . $this->pegawai_model->error, 'error');
				}
			}
		}
		$nip 	= $this->input->get('nip');
		$nama		= $this->input->get('nama');
		$this->load->library('pagination');
		$total = $this->pegawai_model->count_all($nip,$nama);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?nip=".$nip."&nama=".$nama;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		 
		$records = $this->pegawai_model->limit($limit, $offset)->find_all($nip,$nama);

		Template::set('nip', $nip); 
		Template::set('nama', $nama); 
		Template::set('total', $total); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Pegawai');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Pegawai object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Pegawai.Kepegawaian.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_pegawai())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pegawai_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'pegawai');

				Template::set_message(lang('pegawai_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/pegawai');
			}
			else
			{
				Template::set_message(lang('pegawai_create_failure') . $this->pegawai_model->error, 'error');
			}
		}
		Assets::add_module_js('pegawai', 'pegawai.js');

		Template::set('toolbar_title', lang('pegawai_create') . ' Pegawai');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Pegawai data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('pegawai_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/pegawai');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Pegawai.Kepegawaian.Edit');

			if ($this->save_pegawai('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pegawai_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'pegawai');

				Template::set_message(lang('pegawai_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('pegawai_edit_failure') . $this->pegawai_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Pegawai.Kepegawaian.Delete');

			if ($this->pegawai_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pegawai_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'pegawai');

				Template::set_message(lang('pegawai_delete_success'), 'success');

				redirect(SITE_AREA .'/kepegawaian/pegawai');
			}
			else
			{
				Template::set_message(lang('pegawai_delete_failure') . $this->pegawai_model->error, 'error');
			}
		}
		Template::set('pegawai', $this->pegawai_model->find($id));
		Template::set('toolbar_title', lang('pegawai_edit') .' Pegawai');
		Template::render();
	}
	public function getinfouser()
	{
		$id_pegawai = $this->input->get('id_pegawai');
		//die($id_pegawai);
		$datadetil = $this->pegawai_model->find_detil($id_pegawai);
		$pangkat = "";
		$jabatan = "";
		if( isset($datadetil) ) {
			//print_r($datadetil);
			
			$pangkat = isset($datadetil[0]->gol) ? $datadetil[0]->gol : '';
			$jabatan = isset($datadetil[0]->nama_jabatan) ? $datadetil[0]->nama_jabatan : '';
		}
		$output = "";
		
		$json= array();
		$json['pangkat'] = $pangkat;
		$json['jabatan'] = $jabatan;
		$output .= $this->load->view('kepegawaian/infouser',array("pangkat"=>$pangkat,"jabatan"=>$jabatan),true);	
		 
		echo $output;
		//echo json_encode($json); //display records in json format using json_encode
		
		exit();
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
	private function save_pegawai($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		// make sure we only pass in the fields we want
		$this->form_validation->set_rules('pegawai_nip','NIP','required|unique[bf_pegawai.nip,bf_pegawai.id]|max_length[21]');
		$this->form_validation->set_rules('pegawai_no_absen','No Absen','required|unique[bf_pegawai.no_absen,bf_pegawai.id]|max_length[10]');
		$this->form_validation->set_rules('pegawai_nama','Nama','required|max_length[100]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nip']        = $this->input->post('pegawai_nip');
		$data['no_absen']        = $this->input->post('pegawai_no_absen');
		$data['nama']        = $this->input->post('pegawai_nama');
		$data['jabatan']        = $this->input->post('pegawai_jabatan');
		$data['jabatan']        = $this->input->post('jabatan_1');
		$data['jabatan_ft']        = $this->input->post('jabatan_ft');
		$data['jabatan_fu']        = $this->input->post('jabatan_fu');
		$data['golongan']        = $this->input->post('pegawai_golongan');
		$data['nomor_rekening']        = $this->input->post('pegawai_nomor_rekening');
		$data['skp']        = $this->input->post('skp');
		$data['sisa_cuti']        = $this->input->post('sisa_cuti');
		if ($type == 'insert')
		{
			$id = $this->pegawai_model->insert($data);

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
			$return = $this->pegawai_model->update($id, $data);
		}

		return $return;
	}
	public function ambildata()
	{

		Template::set('toolbar_title', 'Ambil Data');
		Template::render();
	}
	public function generatedatasdm()
	{
		$this->auth->restrict('Pegawai.Kepegawaian.Create');
		$this->load->model('pegawai/pegawai_model', null, true);
		$this->load->model('users/user_model');
		$this->load->library('apiservicebosdm');
		$usersimpeg = $this->settings_lib->item('site.usersimpeg');
		$passsimpeg = $this->settings_lib->item('site.passsimpeg');
		$tokensimpeg = $this->settings_lib->item('site.tokensimpeg');
		// getdata drp dt
		$result = $this->apiservicebosdm->getdatapegawai("-1","",$usersimpeg,$passsimpeg,$tokensimpeg);
		
		$datadecode = json_decode($result);
		$index = 0;
		$updated = 0;
		$gagal = 0;
		$jumlah = isset($datadecode->total) ? (int)$datadecode->total : 0;
		if($jumlah == 0){
			die("<br>data tidak ditemukan");
		} 
		foreach ($datadecode->data as $record) {
			//echo $record->sex."<br>";
			$insert_id = "";
			if($this->pegawai_model->isuniq($record->nip)){
				$datapegawai = $this->pegawai_model->find_by("nip",$record->nip);
				$id_pegawai = $datapegawai->id;
				
				$nip = isset($record->nip) ? $record->nip : "";
				$nama = isset($record->name) ? $record->name : "";
				// save user
				$recusers = $this->user_model->find_by("nip",$nip);
				if(!isset($recusers->id)){
					$datauser =  array();
					$datauser['timezone'] 		= "UTC";
					$datauser['password'] 		= "123456789"; 
					$datauser['active'] 		= 1; 
					$datauser['nip'] 			= $nip;
					$datauser['display_name'] 	= $nama;
					$datauser['username'] 		= $nip;
					$datauser['email']			= $nama."@gmail.com";
					$datauser['role_id'] 		= "4";
					$datauser['active'] 		= 1;
					$insert_id = $this->user_model->insert($datauser);
				}

				$data = array();
				//$data['nip']        				= isset($record->nip) ? $record->nip : "";
				if($insert_id != "")
					$data['no_absen']        			= $insert_id;
				
				//$data['nama']        				= isset($record->name) ? $record->name : "";
				$data['jabatan']        			= isset($record->jabatan_struktural_text) ? $record->jabatan_struktural_text : "";
				$data['jabatan_ft']        			= isset($record->jabatan_ft_text) ? $record->jabatan_ft_text : "";
				$data['jabatan_fu']        			= isset($record->jabatan_fu_text) ? $record->jabatan_fu_text : "";
				$data['golongan']       			= isset($record->pangkat_id) ? $record->pangkat_id : "";
				//$data['nomor_rekening'] 			= isset($record->nomor_rekening) ? $record->nomor_rekening : "";
				$data['grade']        				= isset($record->jabatan_struktural_grade) ? $record->jabatan_struktural_grade : "";
				$data['grade_ft']        			= isset($record->jabatan_ft_grade) ? $record->jabatan_ft_grade : "";
				$data['grade_fu']        			= isset($record->jabatan_fu_grade) ? $record->jabatan_fu_grade : "";
				$data['nip_atasan_langsung']      	= isset($record->al_nip) ? $record->al_nip : "";
				$data['email_atasan_langsung']    	= isset($record->al_email) ? $record->al_email : "";
				$result = $this->pegawai_model->update($id_pegawai,$data);
				if($result){
					$updated++;
				}else{
					$gagal++;
				}
			}else{
				$nip = isset($record->nip) ? $record->nip : "";
				$nama = isset($record->name) ? $record->name : "";
				// save user
				$recusers = $this->user_model->find_by("nip",$nip);
				if(!isset($recusers->id)){
					$datauser =  array();
					$datauser['timezone'] 		= "UTC";
					$datauser['password'] 		= "123456789"; 
					$datauser['active'] 		= 1; 
					$datauser['nip'] 			= $nip;
					$datauser['display_name'] 	= $nama;
					$datauser['username'] 		= $nip;
					$datauser['email']			= $nama."@gmail.com";
					$datauser['role_id'] 		= "4";
					$datauser['active'] 		= 1;
					$insert_id = $this->user_model->insert($datauser);
				}

			  	$data = array();
				$data['nip']        				= isset($record->nip) ? $record->nip : "";
				if($insert_id != "")
					$data['no_absen']        			= $insert_id;

				$data['nama']        				= isset($record->name) ? $record->name : "";
				$data['jabatan']        			= isset($record->jabatan_struktural_text) ? $record->jabatan_struktural_text : "";
				$data['jabatan_ft']        			= isset($record->jabatan_ft_text) ? $record->jabatan_ft_text : "";
				$data['jabatan_fu']        			= isset($record->jabatan_fu_text) ? $record->jabatan_fu_text : "";
				$data['golongan']       			= isset($record->pangkat_id) ? $record->pangkat_id : "";
				$data['nomor_rekening'] 			= isset($record->nomor_rekening) ? $record->nomor_rekening : "";
				$data['grade']        			= isset($record->jabatan_struktural_grade) ? $record->jabatan_struktural_grade : "";
				$data['grade_ft']        				= isset($record->jabatan_ft_grade) ? $record->jabatan_ft_grade : "";
				$data['grade_fu']        				= isset($record->jabatan_fu_grade) ? $record->jabatan_fu_grade : "";
				$data['nip_atasan_langsung']      = isset($record->al_nip) ? $record->al_nip : "";
				$data['email_atasan_langsung']    = isset($record->al_email) ? $record->al_email : "";
				  if($id = $this->pegawai_model->insert($data)){
					 $index++;
				  }else{
				  	$gagal++;
					  //echo "gagal".$this->pegawai_model->error;
				  } 
			  }
		}
		Template::set_message("Update data ".$updated.", Save data".$index, 'warning');
		die("Update data ".$updated.", Data baru : ".$index.", Gagal : ".$gagal);
		exit();
	}
	//--------------------------------------------------------------------
	private function save_user($type='insert', $id=0, $meta_fields=array(), $cur_role_name = '')
	{
        
        $extra_unique_rule = '';
		$username_required = '';

        if ($type != 'insert') {
			$_POST['id'] = $id;
    		$extra_unique_rule = ',users.id';
		}
  
		 

		// Compile our core user elements to save.
		$data =  array();
        $data['timezone'] 		= "UTC";
        $data['password'] 		= "123456789"; 
		$data['active'] 		= 1; 
		$nim 					= $this->input->post('mastermahasiswa_nim_mhs');
		$data['nim'] 			= $nim;
		$data['display_name'] 	= $this->input->post('mastermahasiswa_nama_mahasiswa');
		$data['username'] 		= $nim;
		$data['email']			= $nim."@gmail.com";
		$data['role_id'] 		= "7";
		if ($type == 'insert') {
			$activation_method = $this->settings_lib->item('auth.user_activation_method');
			
			// No activation method
			if ($activation_method == 0) {
				// Activate the user automatically
				$data['active'] = 1;
			}

			$return = $this->user_model->insert($data);
			
			$id = $return;
		} else {	// Update
			$return = $this->user_model->update($id, $data);
		}
		
		return $return;

	}//end save_user()

}