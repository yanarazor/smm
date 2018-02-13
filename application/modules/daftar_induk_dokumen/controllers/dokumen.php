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

		$this->auth->restrict('Daftar_Induk_Dokumen.Dokumen.View');
		$this->load->model('daftar_induk_dokumen_model', null, true);
		$this->lang->load('daftar_induk_dokumen');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'dokumen/_sub_nav');

		Assets::add_module_js('daftar_induk_dokumen', 'daftar_induk_dokumen.js');
		$this->load->model('user/user_model', null, true);
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		$this->load->model('jenis_dokumen/jenis_dokumen_model', null, true);
		$jenis_docs = $this->jenis_dokumen_model->find_all();
		Template::set('jenis_docs', $jenis_docs);
		
		$this->load->model('bidang/bidang_model', null, true);
		$bidangs = $this->bidang_model->find_all();
		Template::set('bidangs', $bidangs);
		
		$this->load->model('sub_bidang/sub_bidang_model', null, true);
		$sub_bidangs = $this->sub_bidang_model->find_all();
		Template::set('sub_bidangs', $sub_bidangs);
		
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
					$recordresult = $this->daftar_induk_dokumen_model->find($pid);
					if (isset($recordresult) && isset($recordresult->filename))
					{ 
						deletefile ($recordresult->filename,$this->settings_lib->item('site.pathuploaded'));
					}
					$result = $this->daftar_induk_dokumen_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('daftar_induk_dokumen_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('daftar_induk_dokumen_delete_failure') . $this->daftar_induk_dokumen_model->error, 'error');
				}
			}
		}
		$keyword 	= $this->input->get('keyword');
		$bidang 	= $this->input->get('bidang');
		$jenis_dokumen 	= $this->input->get('jenis_dokumen');
		$this->load->library('pagination');
		$this->daftar_induk_dokumen_model->where('status_active',"1");
		$total = count($this->daftar_induk_dokumen_model->find_all($keyword,$bidang,$jenis_dokumen));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?keyword='.$keyword.'&bidang='.$bidang.'&jenis_dokumen='.$jenis_dokumen.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		$this->daftar_induk_dokumen_model->where('status_active',"1");
		$records = $this->daftar_induk_dokumen_model->limit($limit, $offset)->find_all($keyword,$bidang,$jenis_dokumen);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('records', $records);
		Template::set('jenis_dokumen', $jenis_dokumen);
		Template::set('idbidang', $bidang);
		Template::set('filter_type', "active");
		Template::set('toolbar_title', 'Daftar Induk Dokumen Aktif');
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
					$recordresult = $this->daftar_induk_dokumen_model->find($pid);
					if (isset($recordresult) && isset($recordresult->filename))
					{ 
						deletefile ($recordresult->filename,$this->settings_lib->item('site.pathuploaded'));
					}
					$result = $this->daftar_induk_dokumen_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('daftar_induk_dokumen_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('daftar_induk_dokumen_delete_failure') . $this->daftar_induk_dokumen_model->error, 'error');
				}
			}
		}
		$keyword 	= $this->input->get('keyword');
		$bidang 	= $this->input->get('bidang');
		$jenis_dokumen 	= $this->input->get('jenis_dokumen');
		$this->load->library('pagination');
		$this->daftar_induk_dokumen_model->where('status_active',"0");
		$total = count($this->daftar_induk_dokumen_model->find_all($keyword,$bidang,$jenis_dokumen));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?keyword='.$keyword.'&bidang='.$bidang.'&jenis_dokumen='.$jenis_dokumen.'&Act=Cari+';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		$this->daftar_induk_dokumen_model->where('status_active',"0");
		$records = $this->daftar_induk_dokumen_model->limit($limit, $offset)->find_all($keyword,$bidang,$jenis_dokumen);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total); 
		Template::set('keyword', $keyword);
		Template::set('records', $records);
		Template::set('filter_type', "kadaluarsa");
		Template::set('toolbar_title', 'Daftar Dokumen Kadaluarsa');
		Template::set_view('dokumen/index');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Daftar Induk Dokumen object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Daftar_Induk_Dokumen.Dokumen.Create');
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
			if ($insert_id = $this->save_daftar_induk_dokumen($uploadData))
			{
				
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_induk_dokumen_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'daftar_induk_dokumen');

				Template::set_message(lang('daftar_induk_dokumen_create_success'), 'success');
				redirect(SITE_AREA .'/dokumen/daftar_induk_dokumen');
			}
			else
			{
				Template::set_message(lang('daftar_induk_dokumen_create_failure') . $this->daftar_induk_dokumen_model->error, 'error');
			}
		}
		Assets::add_module_js('daftar_induk_dokumen', 'daftar_induk_dokumen.js');

		Template::set('toolbar_title', lang('daftar_induk_dokumen_create') . ' Daftar Induk Dokumen');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Daftar Induk Dokumen data.
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

		if (empty($id))
		{
			Template::set_message(lang('daftar_induk_dokumen_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/daftar_induk_dokumen');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Daftar_Induk_Dokumen.Dokumen.Edit');
			$this->load->helper('handle_upload');
			$uploadData = array();
			$upload = true; 
			if (isset($_FILES['file_upload']) && is_array($_FILES['file_upload']) && $_FILES['file_upload']['error'] != 4)
			{
				//die($this->settings_lib->item('site.pathphoto'));
				$uploadData = handle_upload('file_upload',$this->settings_lib->item('site.pathuploaded'));

				if (isset($uploadData['error']) && !empty($uploadData['error']))
				{
					$upload = false;
				}
				else{
					// Delete file photo jika ada photo baru
					$recordresult = $this->daftar_induk_dokumen_model->find($id);
					if (isset($recordresult) && isset($recordresult->filename))
					{
						deletefile ($recordresult->filename,$this->settings_lib->item('site.pathuploaded'));
					}
				
				}
			} 	
			if ($this->save_daftar_induk_dokumen($uploadData,'update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_induk_dokumen_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_induk_dokumen');

				Template::set_message(lang('daftar_induk_dokumen_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('daftar_induk_dokumen_edit_failure') . $this->daftar_induk_dokumen_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Daftar_Induk_Dokumen.Dokumen.Delete');

			if ($this->daftar_induk_dokumen_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('daftar_induk_dokumen_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'daftar_induk_dokumen');

				Template::set_message(lang('daftar_induk_dokumen_delete_success'), 'success');

				redirect(SITE_AREA .'/dokumen/daftar_induk_dokumen');
			}
			else
			{
				Template::set_message(lang('daftar_induk_dokumen_delete_failure') . $this->daftar_induk_dokumen_model->error, 'error');
			}
		}
		Template::set('daftar_induk_dokumen', $this->daftar_induk_dokumen_model->find($id));
		Template::set('toolbar_title', lang('daftar_induk_dokumen_edit') .' Daftar Induk Dokumen');
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
	private function save_daftar_induk_dokumen($uploadData=false,$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		$this->form_validation->set_rules('daftar_induk_dokumen_judul','Judul','required|max_length[100]');
		$this->form_validation->set_rules('daftar_induk_dokumen_nomor','Nomor','required|max_length[50]');
		$this->form_validation->set_rules('daftar_induk_dokumen_tanggal_berlaku','Tanggal Berlaku','required|');
		
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['judul']        = $this->input->post('daftar_induk_dokumen_judul');
		$data['nomor']        = $this->input->post('daftar_induk_dokumen_nomor');
		$data['revisi']        = $this->input->post('daftar_induk_dokumen_revisi');
		$data['tanggal_berlaku']        = $this->input->post('daftar_induk_dokumen_tanggal_berlaku') ? $this->input->post('daftar_induk_dokumen_tanggal_berlaku') : '0000-00-00';
		$data['distribusi']        = $this->input->post('daftar_induk_dokumen_distribusi');
		$data['tanggal_dibuat']        = $this->input->post('daftar_induk_dokumen_tanggal_dibuat') ? $this->input->post('daftar_induk_dokumen_tanggal_dibuat') : '0000-00-00';
		$data['tanggal_diperiksa']        = $this->input->post('daftar_induk_dokumen_tanggal_diperiksa') ? $this->input->post('daftar_induk_dokumen_tanggal_diperiksa') : '0000-00-00';
		$data['tanggal_disetujui']        = $this->input->post('daftar_induk_dokumen_tanggal_disetujui') ? $this->input->post('daftar_induk_dokumen_tanggal_disetujui') : '0000-00-00';
		$data['pembuat']        = $this->input->post('daftar_induk_dokumen_pembuat');
		$data['pemeriksa']        = $this->input->post('daftar_induk_dokumen_pemeriksa');
		$data['pengesah']        = $this->input->post('daftar_induk_dokumen_pengesah');
		$data['jenis_dokumen']        = $this->input->post('daftar_induk_dokumen_jenis_dokumen');
		$data['keterangan']        = $this->input->post('daftar_induk_dokumen_keterangan');
		$data['bidang']        = $this->input->post('daftar_induk_dokumen_bidang');
		$data['sub_bidang']        = $this->input->post('sub_bidang');
		$data['status_active']        = $this->input->post('daftar_induk_dokumen_status_active');
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
			$id = $this->daftar_induk_dokumen_model->insert($data);

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
			$return = $this->daftar_induk_dokumen_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------
	public function getinfo()
	{
		$kode_dokumen = $this->input->get('id_dokumen');
		$datadetil = $this->daftar_induk_dokumen_model->find($kode_dokumen);
		if( isset($datadetil) ) {
			$datadetil = (array)$datadetil;
		}
		$judul = isset($datadetil['judul']) ? $datadetil['judul'] : '';
		$revisi = isset($datadetil['revisi']) ? $datadetil['revisi'] : '';
		$nomor = isset($datadetil['nomor']) ? $datadetil['nomor'] : '';
		$pembuat = isset($datadetil['pembuat']) ? $datadetil['pembuat'] : '';
		$json= array();
		$json['judul'] = $judul;
		$json['nomor'] = $nomor;
		$json['revisi'] = $revisi;
		$json['pembuat'] = $pembuat;
		echo json_encode($json); //display records in json format using json_encode
		
		exit();
	}

}