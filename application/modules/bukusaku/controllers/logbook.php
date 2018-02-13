<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * logbook controller
 */
class logbook extends Admin_Controller
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

		$this->auth->restrict('Bukusaku.Logbook.View');
		$this->load->model('bukusaku_model', null, true);
		$this->lang->load('bukusaku');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'logbook/_sub_nav');

		Assets::add_module_js('bukusaku', 'bukusaku.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->model('pegawai/pegawai_model', null, true);
		$this->pegawai_model->where("no_absen != ''");
		$pegawais = $this->pegawai_model->find_all();
		Template::set('pegawais', $pegawais);
		$nip = $this->input->get('nip');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->bukusaku_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('bukusaku_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('bukusaku_delete_failure') . $this->bukusaku_model->error, 'error');
				}
			}
		}
		Template::set('nip', $nip);
		Template::set('toolbar_title', 'Manage bukusaku');
		Template::render();
	}
	public function lihat()
	{
 		
		$records = $this->bukusaku_model->find_all();
		$tanggal = $this->input->get('tanggal');
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage bukusaku');
		Template::render();
	}
	public function lihatdetil()
	{
 		$kode = $this->input->get('kode');
		$records = $this->bukusaku_model->find_detil($kode);
		$tanggal = $this->input->get('tanggal');
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage bukusaku');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * gets a bukusaku object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Bukusaku.Logbook.Create');
		$this->load->model('skp/skp_model', null, true);
		$tanggal = $this->input->get('tanggal');
		$tahun = date("Y");
		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_bukusaku())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('bukusaku_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'bukusaku');

				Template::set_message(lang('bukusaku_create_success'), 'success');
				redirect(SITE_AREA .'/logbook/bukusaku');
			}
			else
			{
				Template::set_message(lang('bukusaku_create_failure') . $this->bukusaku_model->error, 'error');
			}
		}
			
		$users = $this->user_model->find($this->current_user->id);
		$nama = isset($users->display_name) ? $users->display_name : "";
		$nip = isset($users->nip) ? $users->nip : "";
		$kegiatans = $this->skp_model->find_all($nip);
		Template::set('kegiatans', $kegiatans);

		Assets::add_module_js('bukusaku', 'bukusaku.js');
		Template::set('tanggal', $tanggal);
		Template::set('toolbar_title', lang('bukusaku_create') . ' bukusaku');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of bukusaku data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('bukusaku_invalid_id'), 'error');
			redirect(SITE_AREA .'/logbook/bukusaku');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Bukusaku.Logbook.Edit');

			if ($this->save_bukusaku('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('bukusaku_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'bukusaku');

				Template::set_message(lang('bukusaku_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('bukusaku_edit_failure') . $this->bukusaku_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Bukusaku.Logbook.Delete');

			if ($this->bukusaku_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('bukusaku_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'bukusaku');

				Template::set_message(lang('bukusaku_delete_success'), 'success');

				redirect(SITE_AREA .'/logbook/bukusaku');
			}
			else
			{
				Template::set_message(lang('bukusaku_delete_failure') . $this->bukusaku_model->error, 'error');
			}
		}

	

		Template::set('bukusaku', $this->bukusaku_model->find($id));
		Template::set('toolbar_title', lang('bukusaku_edit') .' bukusaku');
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
	private function save_bukusaku($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nip_pegawai']        = $this->input->post('bukusaku_nip_pegawai');
		$data['tanggal']        = $this->input->post('bukusaku_tanggal') ? $this->input->post('bukusaku_tanggal') : '0000-00-00';
		$data['pk']        = $this->input->post('bukusaku_pk');
		$data['jam']        = $this->input->post('bukusaku_jam');
		$data['kegiatan']        = $this->input->post('bukusaku_kegiatan');

		if ($type == 'insert')
		{
			$id = $this->bukusaku_model->insert($data);

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
			$return = $this->bukusaku_model->update($id, $data);
		}

		return $return;
	}
	public function savedatalog(){
         // Validate the data
        $type='insert';
        $this->form_validation->set_rules($this->bukusaku_model->get_validation_rules());
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

        $data = $this->bukusaku_model->prep_data($this->input->post());
        if ($type != 'update')
		{
			$data['nip_pegawai']        = $this->current_user->id;
		}
		$data['tanggal']         = $this->input->post('bukusaku_tanggal') ? $this->input->post('bukusaku_tanggal') : '0000-00-00';
		$data['pk']        		 = $this->input->post('pk');
		$data['jam']        	 = $this->input->post('bukusaku_jam');
		$data['sampai_jam']      = $this->input->post('sampai_jam');
		$data['kegiatan']        = $this->input->post('bukusaku_kegiatan');
        $id_data = $this->input->post("id");
        if(isset($id_data) && !empty($id_data)){
            $this->bukusaku_model->update($id_data,$data);
        }
        else $this->bukusaku_model->insert($data);
        $response ['success']= true;
        $response ['msg']= "Transaksi berhasil";
        echo json_encode($response);    

    }
	//--------------------------------------------------------------------
    public function getevent()
	{	
		$ni = "";
		if($this->input->get('nip') == "")
			$nip = $this->current_user->id;
		else
			$nip = $this->input->get('nip');

		$bukusakus = $this->bukusaku_model->find_event($nip);
		$json[] =array();
		if (isset($bukusakus) && is_array($bukusakus) && count($bukusakus)) :
		foreach ($bukusakus as $record) : 
			$json['title'][] = "ada";
			$json['start'][] = $record->start;
			
		endforeach;
		endif;
		  
		echo json_encode($bukusakus); //display records in json format using json_encode
		exit();
	}
	 public function deletebukusaku()
    {
        $this->auth->restrict('Bukusaku.Logbook.Delete');
        $id     = $this->input->post('kode');
        if ($this->bukusaku_model->delete($id)) {
             log_activity($this->auth->user_id(), 'delete bukusaku : ' . $id . ' : ' . $this->input->ip_address(), 'bukusaku');
             echo "Sukses";
        }else{
            echo "Gagal";
        }

        exit();
    }

}