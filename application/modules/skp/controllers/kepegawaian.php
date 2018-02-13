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

		$this->auth->restrict('Skp.Kepegawaian.View');
		$this->load->model('skp_model', null, true);
		$this->lang->load('skp');
		
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');

		Assets::add_module_js('skp', 'skp.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$tahun = date("Y");
		$nip = "";
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->skp_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('skp_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('skp_delete_failure') . $this->skp_model->error, 'error');
				}
			}
		}
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16" and $this->current_user->role_id != "12"  and $this->current_user->role_id != "10")
		{
			$users = $this->user_model->find($this->current_user->id);
			$nama = isset($users->display_name) ? $users->display_name : "";
			$nip = isset($users->nip) ? $users->nip : "";
			
		}
		if($this->current_user->role_id == "10")
		{
			$this->skp_model->where('atasan',$this->current_user->id);
		}
		$records = $this->skp_model->find_distinct($nip,$tahun);

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage skp');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a skp object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Skp.Kepegawaian.Create');
		$this->load->model('users/user_model', null, true);
		$tahun = date("Y");
		$users = $this->user_model->find($this->current_user->id);
		$nama = isset($users->display_name) ? $users->display_name : "";
		$nip = isset($users->nip) ? $users->nip : "";
		$atasan = isset($users->atasan) ? $users->atasan : "";

		$atasans = $this->user_model->find($atasan);
		$namaatasan = isset($atasans->display_name) ? $atasans->display_name : "";

		Template::set('nama', $nama);
		Template::set('namaatasan', $namaatasan);
		Template::set('nip', $nip);
		Template::set('tahun', $tahun);
		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_skp())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('skp_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'skp');

				Template::set_message(lang('skp_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/skp');
			}
			else
			{
				Template::set_message(lang('skp_create_failure') . $this->skp_model->error, 'error');
			}
		}

		$records = $this->skp_model->find_all($nip,$tahun);
		if (isset($records) && is_array($records) && count($records)){
			redirect(SITE_AREA .'/kepegawaian/skp/edit/'.$tahun."/".$nip);
		}
		Template::set('records', $records);

		Assets::add_module_js('skp', 'skp.js');

		Template::set('toolbar_title', lang('skp_create') . ' skp');
		Template::render();
	}
	public function edit()
	{
		$this->auth->restrict('Skp.Kepegawaian.Create');
		$this->load->model('users/user_model', null, true);

		$tahun = $this->uri->segment(5);
		$nip = $this->uri->segment(6);

		//$tahun = date("Y");
		$users 	= $this->user_model->find_by("nip",$nip);
		$nama 	= isset($users->display_name) ? $users->display_name : "";
		$nip 	= isset($users->nip) ? $users->nip : "";
		$atasan = isset($users->atasan) ? $users->atasan : "";

		$atasans = $this->user_model->find($atasan);
		$namaatasan = isset($atasans->display_name) ? $atasans->display_name : "";

		Template::set('nama', $nama);
		Template::set('namaatasan', $namaatasan);
		Template::set('nip', $nip);
		Template::set('tahun', $tahun);
		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_skp())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('skp_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'skp');

				Template::set_message(lang('skp_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/skp');
			}
			else
			{
				Template::set_message(lang('skp_create_failure') . $this->skp_model->error, 'error');
			}
		}

		$records = $this->skp_model->find_all($nip,$tahun);
		Template::set('records', $records);

		Assets::add_module_js('skp', 'skp.js');

		Template::set('toolbar_title', 'Update skp');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of skp data.
	 *
	 * @return void
	 */
	 
	public function laporan()
	{
		$tahun = $this->uri->segment(5);
		$nip = $this->uri->segment(6);

		if (empty($tahun))
		{
			Template::set_message(lang('skp_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/skp');
		}

		$this->load->model('users/user_model', null, true);
		$tahun 	= date("Y");
		$users 	= $this->user_model->find_by("nip",$nip);
		$nama 	= isset($users->display_name) ? $users->display_name : "";
		$nip 	= isset($users->nip) ? $users->nip : "";
		$atasan = isset($users->atasan) ? $users->atasan : "";

		$atasans 	= $this->user_model->find($atasan);
		$namaatasan = isset($atasans->display_name) ? $atasans->display_name : "";

		Template::set('nama', $nama);
		Template::set('namaatasan', $namaatasan);
		Template::set('nip', $nip);
		Template::set('tahun', $tahun);
		 
		$records = $this->skp_model->find_withskp($nip,$tahun);
		Template::set('records', $records);

		Assets::add_module_js('skp', 'skp.js');

		Template::set('toolbar_title', lang('skp_create') . ' skp');
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
	private function save_skp($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['tahun']        		= $this->input->post('skp_tahun');
		$data['nip']        		= $this->input->post('skp_nip');
		$data['kegiatan']        	= $this->input->post('skp_kegiatan');
		$data['target']        		= $this->input->post('skp_target');
		$data['waktu']        		= $this->input->post('skp_waktu');
		$data['capaian']        	= $this->input->post('skp_capaian');
		$data['pemantauan']        	= $this->input->post('skp_pemantauan');

		if ($type == 'insert')
		{
			$id = $this->skp_model->insert($data);

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
			$return = $this->skp_model->update($id, $data);
		}

		return $return;
	}
	public function additem()
	{
		$index = $this->input->post('index');
		 
		$output="";
			$output .= $this->load->view('kepegawaian/dinamicedit',array("index"=>$index),true);	
		 
		echo $output;
		die();
	}
	//--------------------------------------------------------------------
	public function saveskp(){
		$this->auth->restrict('Skp.Kepegawaian.Create');
         // Validate the data
        $type='insert';
        $this->form_validation->set_rules($this->skp_model->get_validation_rules());
        $response = array(
            'success'=>false,
            'msg'=>'Unknown error'
        );
        if ($this->form_validation->run() === false) {
            $response['msg'] = "
            <div class='alert alert-block alert-error fade in'>
                <a class='close' data-dismiss='alert'>&times;</a>
                <h4 class='alert-heading'>
                    Error
                </h4>
                ".validation_errors()."
            </div>
            ";
            echo json_encode($response);
            exit();
        }
        $tahun 				= $this->input->post('tahun');
        $nip 				= $this->input->post('nip');
        $kegiatan 			= $this->input->post('kegiatan');
		$target 			= $this->input->post('target');
		$satuan 			= $this->input->post('satuan');
		$waktu 				= $this->input->post('waktu');
		$capaian 			= $this->input->post('capaian');
		$pemantauan 		= $this->input->post('pemantauan');

		$kual 				= $this->input->post('kual');
		$ak 				= $this->input->post('ak');
		$pemantauan 		= $this->input->post('pemantauan');
		$biaya 				= $this->input->post('biaya');
		$id 				= $this->input->post('id');
		if(isset($_POST['kegiatan'])){
			$index = 0;
			$nomordetil = 1;

			foreach($this->input->post("kegiatan") as $value )
			{

				if($value != "")
				{
					$data['tahun']       = $tahun;
					$data['nip']       	 = $nip;
					$data['kegiatan']    = $value;
					$data['target']      = $target[$index];
					$data['satuan']      = $satuan[$index];
					$data['waktu']       = $waktu[$index];
					$data['kual']    	= $kual[$index];
					$data['ak']    		= $ak[$index];
					$data['capaian']    = $capaian[$index];
					$data['biaya']    	= $biaya[$index];
			        $id_data 			= isset($id[$index]) ? $id[$index] : "";
			        if(isset($id_data) && !empty($id_data)){
			            $this->skp_model->update($id_data,$data);
			        }
			        else {
			        	if($this->skp_model->insert($data))
			        	{
			        		//die("berhasil");
			        	}else{
			        		log_activity($this->current_user->id, 'ada masalah : '. $this->skp_model->error .' : '. $this->input->ip_address(), 'skp');
			        		$response = array(
					            'success'=>false,
					            'msg'=>$this->skp_model->error
					        );
			        	}
			        }
					$nomordetil++;
				}
				$index++;
			}
		}
        $response ['success']= true;
        $response ['msg']= "Simpan Sukses";
        echo json_encode($response);    

    }
    public function deletedata()
	{
		$this->auth->restrict('Skp.Kepegawaian.Delete');
		$this->load->helper('handle_upload');
		$id 	= $this->input->post('kode');
		$record = $this->skp_model->find($id);
		 
		if ($this->skp_model->delete($id)) {
			 log_activity($this->auth->user_id(),'Delete SKP : ' . $id . ' : ' . $this->input->ip_address(), 'skp');
			 echo "Sukses";
		}else{
			echo "Gagal";
		}

		exit();
	}

}