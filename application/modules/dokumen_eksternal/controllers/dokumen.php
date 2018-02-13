<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * dokumen controller
 */
class dokumen extends Admin_Controller
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

		$this->auth->restrict('Dokumen_Eksternal.Dokumen.View');
		$this->load->model('dokumen_eksternal_model', null, true);
		$this->lang->load('dokumen_eksternal');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'dokumen/_sub_nav');

		Assets::add_module_js('dokumen_eksternal', 'dokumen_eksternal.js');
		$this->load->model('user/user_model', null, true);
		$users = $this->user_model->find_all();
		Template::set('users', $users);
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		//Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$this->load->helper('handle_upload');
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$recordresult = $this->dokumen_eksternal_model->find($pid);
					if (isset($recordresult) && isset($recordresult->filename))
					{
						//die($recordresult->filename);
						//$foto = unserialize($recordresult->filename); 
						//die($this->settings_lib->item('site.pathuploaded').$foto['file_name']);
						deletefile ($recordresult->filename,$this->settings_lib->item('site.pathuploaded'));
					}
					$result = $this->dokumen_eksternal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('dokumen_eksternal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('dokumen_eksternal_delete_failure') . $this->dokumen_eksternal_model->error, 'error');
				}
			}
		}
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		$this->dokumen_eksternal_model->where('status_active',"1");
		$total = count($this->dokumen_eksternal_model->find_all($keyword));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		$this->dokumen_eksternal_model->where('status_active',"1");
		$records = $this->dokumen_eksternal_model->limit($limit, $offset)->find_all($keyword);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('records', $records);
		Template::set('filter_type', "active");
		Template::set('toolbar_title', 'Kelola Dokumen Eksternal');
		Template::render();
	}
	public function kadaluarsa()
	{
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		//Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$this->load->helper('handle_upload');
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$recordresult = $this->dokumen_eksternal_model->find($pid);
					if (isset($recordresult) && isset($recordresult->filename))
					{
						//die($recordresult->filename);
						//$foto = unserialize($recordresult->filename); 
						//die($this->settings_lib->item('site.pathuploaded').$foto['file_name']);
						deletefile ($recordresult->filename,$this->settings_lib->item('site.pathuploaded'));
					}
					$result = $this->dokumen_eksternal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('dokumen_eksternal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('dokumen_eksternal_delete_failure') . $this->dokumen_eksternal_model->error, 'error');
				}
			}
		}
		$keyword = $this->input->get('keyword');
		$this->load->library('pagination');
		$this->dokumen_eksternal_model->where('status_active',"0");
		$total = count($this->dokumen_eksternal_model->find_all($keyword));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		$this->dokumen_eksternal_model->where('status_active',"0");
		$records = $this->dokumen_eksternal_model->limit($limit, $offset)->find_all($keyword);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('records', $records);
		Template::set('filter_type', "kadaluarsa");
		Template::set('toolbar_title', 'Kelola Dokumen Eksternal');
		Template::set_view('dokumen/index');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Dokumen Eksternal object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Dokumen_Eksternal.Dokumen.Create');
		Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (isset($_POST['save']))
		{
			$this->load->helper('handle_upload');
			$uploadData = array();
			$upload = true; 
			if (isset($_FILES['file_upload']) && is_array($_FILES['file_upload']) && $_FILES['file_upload']['error'] != 4)
			{
				//die($this->settings_lib->item('site.pathphoto'));
				$uploadData = handle_upload('file_upload',$this->settings_lib->item('site.pathuploaded'));
				//print_r($uploadData);
				if (isset($uploadData['error']) && !empty($uploadData['error']))
				{
					$upload = false;
				}
			} 	
			if ($insert_id = $this->save_dokumen_eksternal($uploadData))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('dokumen_eksternal_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'dokumen_eksternal');

				Template::set_message(lang('dokumen_eksternal_create_success'), 'success');
				redirect(SITE_AREA .'/dokumen/dokumen_eksternal');
			}
			else
			{
				Template::set_message(lang('dokumen_eksternal_create_failure') . $this->dokumen_eksternal_model->error, 'error');
			}
		}
		Assets::add_module_js('dokumen_eksternal', 'dokumen_eksternal.js');

		Template::set('toolbar_title', lang('dokumen_eksternal_create') . ' Dokumen Eksternal');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Dokumen Eksternal data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');
		$this->load->helper('handle_upload');

		if (empty($id))
		{
			Template::set_message(lang('dokumen_eksternal_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/dokumen_eksternal');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Dokumen_Eksternal.Dokumen.Edit');
			
			$uploadData = array();
			$upload = true; 
			if (isset($_FILES['file_upload']) && is_array($_FILES['file_upload']) && $_FILES['file_upload']['error'] != 4)
			{
				
				$uploadData = handle_upload('file_upload',$this->settings_lib->item('site.pathuploaded'));
				 
				if (isset($uploadData['error']) && !empty($uploadData['error']))
				{
					$upload = false;
				}
				else{
					// Delete file photo jika ada photo baru
					$recordresult = $this->dokumen_eksternal_model->find($id);
					if (isset($recordresult) && isset($recordresult->filename))
					{
						  
						deletefile ($recordresult->filename,$this->settings_lib->item('site.pathuploaded'));
					}
				
				}
			}  

			if ($this->save_dokumen_eksternal($uploadData,'update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('dokumen_eksternal_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'dokumen_eksternal');

				Template::set_message(lang('dokumen_eksternal_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('dokumen_eksternal_edit_failure') . $this->dokumen_eksternal_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Dokumen_Eksternal.Dokumen.Delete');
			// Delete file photo jika ada photo baru
			$recordresult = $this->dokumen_eksternal_model->find($id);
			if (isset($recordresult) && isset($recordresult->filename))
			{
				$foto = unserialize($recordresult->filename); 
				 
				deletefile ($foto['file_name'],$this->settings_lib->item('site.pathuploaded'));
			}
			if ($this->dokumen_eksternal_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('dokumen_eksternal_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'dokumen_eksternal');

				Template::set_message(lang('dokumen_eksternal_delete_success'), 'success');

				redirect(SITE_AREA .'/dokumen/dokumen_eksternal');
			}
			else
			{
				Template::set_message(lang('dokumen_eksternal_delete_failure') . $this->dokumen_eksternal_model->error, 'error');
			}
		}
		Template::set('dokumen_eksternal', $this->dokumen_eksternal_model->find($id));
		Template::set('toolbar_title', lang('dokumen_eksternal_edit') .' Dokumen Eksternal');
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
	private function save_dokumen_eksternal($uploadData=false,$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['judul']        = $this->input->post('dokumen_eksternal_judul');
		$data['nomor']        = $this->input->post('dokumen_eksternal_nomor');
		$data['tanggal_berlaku']        = $this->input->post('dokumen_eksternal_tanggal_berlaku') ? $this->input->post('dokumen_eksternal_tanggal_berlaku') : '0000-00-00';
		$data['distribusi']        = $this->input->post('dokumen_eksternal_distribusi');
		$data['pengusul']        = $this->input->post('dokumen_eksternal_pengusul');
		$data['pemeriksa']        = $this->input->post('dokumen_eksternal_pemeriksa');
		$data['pengesah']        = $this->input->post('dokumen_eksternal_pengesah');
		
		if ($type != 'update')
		{
			$data['created_by']        = $this->current_user->id;
			$data['status_active']        = $this->input->post('dokumen_eksternal_status_active');
		}else{
			$data['status_active']        = $this->input->post('dokumen_eksternal_status_active');
		}
		$data['created_date']        = date("Y-m-d");
		$data['updated_by']        = $this->current_user->id;
		$data['updated_date']        = date("Y-m-d");
		//$data['filename']        = $this->input->post('dokumen_eksternal_filename');
		if ($uploadData !== false && is_array($uploadData) && count($uploadData) > 0)
		{
			if (!isset($uploadData['error']) && empty($uploadData['error']))
			{
				//die("masuk");
				$data = $data + array('filename'=>serialize($uploadData['data']));
			}
			
		} 
		if ($type == 'insert')
		{
			$id = $this->dokumen_eksternal_model->insert($data);

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
			$return = $this->dokumen_eksternal_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------
	public function getinfo()
	{
		$kode_dokumen = $this->input->get('id_dokumen');
		$datadetil = $this->dokumen_eksternal_model->find($kode_dokumen);
		if( isset($datadetil) ) {
			$datadetil = (array)$datadetil;
		}
		$judul = isset($datadetil['judul']) ? $datadetil['judul'] : '';
		//$revisi = isset($datadetil['revisi']) ? $datadetil['revisi'] : '';
		$nomor = isset($datadetil['nomor']) ? $datadetil['nomor'] : '';
		$pembuat = isset($datadetil['pengusul']) ? $datadetil['pengusul'] : '';
		$json= array();
		$json['judul'] = $judul;
		$json['nomor'] = $nomor;
		//$json['revisi'] = $revisi;
		$json['pembuat'] = $pembuat;
		echo json_encode($json); //display records in json format using json_encode
		
		exit();
	}

}