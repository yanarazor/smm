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

		$this->auth->restrict('Usulan_Dokumen_Eksternal.Dokumen.View');
		$this->load->model('usulan_dokumen_eksternal_model', null, true);
		$this->lang->load('usulan_dokumen_eksternal');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'dokumen/_sub_nav');

		Assets::add_module_js('usulan_dokumen_eksternal', 'usulan_dokumen_eksternal.js');
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
		$this->load->helper('handle_upload');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					// Delete file photo jika ada photo baru
					$recordresult = $this->usulan_dokumen_eksternal_model->find($pid);
					if (isset($recordresult) && isset($recordresult->filename))
					{
						$foto = unserialize($recordresult->filename);
						deletefile ($foto['file_name'],$this->settings_lib->item('site.pathuploaded'));
					}
					
					$result = $this->usulan_dokumen_eksternal_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('usulan_dokumen_eksternal_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('usulan_dokumen_eksternal_delete_failure') . $this->usulan_dokumen_eksternal_model->error, 'error');
				}
			}
		}
		$keyword = $this->input->get('keyword');
		$status = $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1")
			$this->usulan_dokumen_eksternal_model->where('pengusul',$this->current_user->id);
		$total = count($this->usulan_dokumen_eksternal_model->find_all($keyword));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		if($this->current_user->role_id != "1")
			$this->usulan_dokumen_eksternal_model->where('pengusul',$this->current_user->id);
		$records = $this->usulan_dokumen_eksternal_model->limit($limit, $offset)->find_all($keyword);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('status', $status);
		Template::set('records', $records);
		Template::set('filter_type', "all");
		Template::set('action', "edit");
		Template::set('toolbar_title', 'Kelola Usulan Dokumen Eksternal');
		Template::render();
	}
	public function list_periksa()
	{
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');
		// Deleting anything?
		 
		$keyword = $this->input->get('keyword');
		$status = $this->input->get('status');
		if($status=="")
			$status = "0";
		$this->load->library('pagination');
		$this->usulan_dokumen_eksternal_model->or_where('status',$status);
		$this->usulan_dokumen_eksternal_model->or_where('status is null');
		$total = count($this->usulan_dokumen_eksternal_model->find_all($keyword));
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		//if($this->current_user->role_id != "1")
		$this->usulan_dokumen_eksternal_model->or_where('status',$status);
		$this->usulan_dokumen_eksternal_model->or_where('status is null');
		$records = $this->usulan_dokumen_eksternal_model->limit($limit, $offset)->find_all($keyword);
		if(isset($records) && is_array($records) && count($records))
			$total =  $total;
		else
			$total =  "0";
			
		Template::set('total', $total);
		Template::set('keyword', $keyword);
		Template::set('status', $status);
		
		Template::set('records', $records);
		Template::set('filter_type', "periksa");
		Template::set('action', "periksa");
		Template::set('toolbar_title', 'Kelola Usulan Dokumen Eksternal');
		Template::set_view('dokumen/index');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Usulan Dokumen Eksternal object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Usulan_Dokumen_Eksternal.Dokumen.Create');
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
			$pengesah ="";
			$this->load->model('user/user_model', null, true);
				$this->user_model->where('users.role_id',"7");
				$users = $this->user_model->find_all();
				if(isset($users) && is_array($users) && count($users)){
					foreach ($users as $recorduser) :
						$pengesah = $recorduser->id;
					endforeach;
				}
			

			if ($insert_id = $this->save_usulan_dokumen_eksternal($uploadData,$pengesah))
			{
				$user = $this->user_model->find($pengesah);
				if (isset($user))
				{
					$email = $user->email;
				}
				//sending mail
				$subjek       		= "Notifikasi Usulan Dokumen Eksternal";
				$isi        		= "Anda Perlu memeriksa usulan dokumen eksternal yang diupload oleh: ".$this->current_user->display_name;
				
				$this->load->library('emailer/emailer');
				$dataemail = array (
					'subject'	=> $subjek,
					'message'	=> $isi,
				);
				$success_count = 0;
				$resultmail = FALSE;
				 
				$dataemail['to'] = $email;
				$resultmail = $this->emailer->send($dataemail,true);// di set false supaya langsung mengirimkan email dan tidak masuk antrian dulu
			 
				if ($resultmail)
				{
					log_activity($this->current_user->id, 'Sending email to sender from Usulan Dokumen eksternal, ID : ' . $insert_id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
				}else{
					log_activity($this->current_user->id, ' Sending email to sender from Usulan Dokumen eksternal Failed, ID : ' . $insert_id . ' : ' . $this->input->ip_address(), 'usulan_dokumen_internal');
				}
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_dokumen_eksternal_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'usulan_dokumen_eksternal');

				Template::set_message(lang('usulan_dokumen_eksternal_create_success'), 'success');
				redirect(SITE_AREA .'/dokumen/usulan_dokumen_eksternal');
			}
			else
			{
				Template::set_message(lang('usulan_dokumen_eksternal_create_failure') . $this->usulan_dokumen_eksternal_model->error, 'error');
			}
		}
		Assets::add_module_js('usulan_dokumen_eksternal', 'usulan_dokumen_eksternal.js');

		Template::set('toolbar_title', lang('usulan_dokumen_eksternal_create') . ' Usulan Dokumen Eksternal');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Usulan Dokumen Eksternal data.
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
			Template::set_message(lang('usulan_dokumen_eksternal_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/usulan_dokumen_eksternal');
		}

		if (isset($_POST['save']))
		{
			$this->load->helper('handle_upload');
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
					$recordresult = $this->usulan_dokumen_eksternal_model->find($id);
					if (isset($recordresult) && isset($recordresult->filename))
					{
						$foto = unserialize($recordresult->filename); 
						 
						deletefile ($foto['file_name'],$this->settings_lib->item('site.pathuploaded'));
					}
				
				}
			}
			$this->auth->restrict('Usulan_Dokumen_Eksternal.Dokumen.Edit');
			$pengesah ="";
			$this->load->model('user/user_model', null, true);
				$this->user_model->where('users.role_id',"7");
				$users = $this->user_model->find_all();
				if(isset($users) && is_array($users) && count($users)){
					foreach ($users as $recorduser) :
						$pengesah = $recorduser->id;
					endforeach;
				}

			if ($this->save_usulan_dokumen_eksternal($uploadData,$pengesah,'update', $id))
			{
				
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_dokumen_eksternal_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_dokumen_eksternal');

				Template::set_message(lang('usulan_dokumen_eksternal_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('usulan_dokumen_eksternal_edit_failure') . $this->usulan_dokumen_eksternal_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Usulan_Dokumen_Eksternal.Dokumen.Delete');

			if ($this->usulan_dokumen_eksternal_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('usulan_dokumen_eksternal_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_dokumen_eksternal');

				Template::set_message(lang('usulan_dokumen_eksternal_delete_success'), 'success');

				redirect(SITE_AREA .'/dokumen/usulan_dokumen_eksternal');
			}
			else
			{
				Template::set_message(lang('usulan_dokumen_eksternal_delete_failure') . $this->usulan_dokumen_eksternal_model->error, 'error');
			}
		}
		Template::set('usulan_dokumen_eksternal', $this->usulan_dokumen_eksternal_model->find($id));
		Template::set('toolbar_title', lang('usulan_dokumen_eksternal_edit') .' Usulan Dokumen Eksternal');
		Template::render();
	}
	public function periksa()
	{
		$this->load->model('dokumen_eksternal/dokumen_eksternal_model', null, true);
		$id = $this->uri->segment(5);
		Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');
		Assets::add_css('fancybox/jquery.fancybox-1.3.4.css');
		//Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_js('fancybox/jquery.fancybox-1.3.4.js');

		if (empty($id))
		{
			Template::set_message(lang('usulan_dokumen_eksternal_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/usulan_dokumen_eksternal');
		}

		if (isset($_POST['save']))
		{
			 
			

			if ($this->save_usulan_dokumen_eksternal_periksa('update', $id))
			{
				$datadetil = $this->usulan_dokumen_eksternal_model->find($id);
				//die($datadetil->judul);
				$judul = $datadetil->judul;
				$nomor = $datadetil->nomor;
				 
				$pengusul = $datadetil->pengusul;
				$pemeriksa = $datadetil->pemeriksa;
				if($pemeriksa=="")
					$pemeriksa = $this->current_user->id;
				$pengesah = $this->current_user->id;
				
				$filename = $datadetil->filename;
				
				if($this->input->post('usulan_dokumen_eksternal_status')=="1")
				{
						
						$user = $this->user_model->find($pengusul);
						if (isset($user))
						{
							$emailpengusul = $user->email;
						}
						$subjek       		= "Notifikasi Usulan Dokumen";
						$isi        	= "Usulan Dokumen Anda sudah disetujui";
					
						$this->load->library('emailer/emailer');
						$dataemail = array (
							'subject'	=> $subjek,
							'message'	=> $isi,
						);
						$resultmail = FALSE;
					 	$dataemail['to'] = $emailpengusul;
						$resultmail = $this->emailer->send($dataemail,false);
						//end email pengusul
					 
					$isexist = $this->dokumen_eksternal_model->cekexist($this->input->post('usulan_dokumen_eksternal_judul'));
					// die($isexist."masuk");
					if((int)$isexist>0){
						Template::set_message("Dokumen Sudah Terdaftar Pada Daftar Induk Dokumen Eksternal, Silahkan Cek Terlibeih Dahulu Pada Daftar Induk Dokumen Eksternal", 'error');
					}else{
						
						$kode_dok_eksternal = $this->save_dokumen_eksternal($judul,$nomor,$filename,$pengusul,$pemeriksa,$pengesah);
						Template::set_message("Dokumen Telah di Masukan Pada Daftar Induk Dokumen Eksternal..", 'success');
						//$isiemail = "Usulan Dokumen dengan Judul <b>'".$judul."'</b> Telah disahkan dan sudah masuk pada daftar induk dokumen";
					}
				}else{
						$user = $this->user_model->find($pengusul);
						if (isset($user))
						{
							$emailpengusul = $user->email;
						}
						$subjek       		= "Notifikasi Usulan Dokumen";
						$isi        		= "Mohon Periksa Kembali Usulan Dokumen Ekternal Anda";
					
						$this->load->library('emailer/emailer');
						$dataemail = array (
							'subject'	=> $subjek,
							'message'	=> $isi,
						);
						$resultmail = FALSE;
					 	$dataemail['to'] = $emailpengusul;
						$resultmail = $this->emailer->send($dataemail,false);
						//end email pengusul
				}
				
				// Log the activity
				log_activity($this->current_user->id, "Pengesahan Daftar Induk Dokumen Eksternal, ".lang('usulan_dokumen_eksternal_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'usulan_dokumen_eksternal');

				Template::set_message(lang('usulan_dokumen_eksternal_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('usulan_dokumen_eksternal_edit_failure') . $this->usulan_dokumen_eksternal_model->error, 'error');
			}
		}
		 
		Template::set('usulan_dokumen_eksternal', $this->usulan_dokumen_eksternal_model->find($id));
		Template::set('toolbar_title', lang('usulan_dokumen_eksternal_edit') .' Usulan Dokumen Eksternal');
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
	private function save_usulan_dokumen_eksternal($uploadData=false,$pemeriksa="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['judul']        = $this->input->post('usulan_dokumen_eksternal_judul');
		$data['nomor']        = $this->input->post('usulan_dokumen_eksternal_nomor');
		$data['pengusul']        = $this->current_user->id;
		$data['pemeriksa']        = $pemeriksa;
		//$data['catatan']        = $this->input->post('usulan_dokumen_eksternal_catatan');
		//$data['status']        = $this->input->post('usulan_dokumen_eksternal_status');
		$data['tanggal_pengusulan']        = date("Y-m-d");
		//$data['tanggal_pengesahan']        = $this->input->post('usulan_dokumen_eksternal_tanggal_pengesahan') ? $this->input->post('usulan_dokumen_eksternal_tanggal_pengesahan') : '0000-00-00';
		//$data['filename']        = $this->input->post('usulan_dokumen_eksternal_filename');
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
			$id = $this->usulan_dokumen_eksternal_model->insert($data);

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
			$return = $this->usulan_dokumen_eksternal_model->update($id, $data);
		}

		return $return;
	}
	private function save_usulan_dokumen_eksternal_periksa($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		//$data['judul']        = $this->input->post('usulan_dokumen_eksternal_judul');
		//$data['nomor']        = $this->input->post('usulan_dokumen_eksternal_nomor');
		//$data['pengusul']        = $this->current_user->id;
		//$data['pemeriksa']        = $pemeriksa;
		$data['catatan']        = $this->input->post('usulan_dokumen_eksternal_catatan');
		$data['status']        = $this->input->post('usulan_dokumen_eksternal_status');
		//$data['tanggal_pengusulan']        = date("Y-m-d");
		$data['tanggal_pengesahan']        = date("Y-m-d");
		//$data['filename']        = $this->input->post('usulan_dokumen_eksternal_filename');
		 
		if ($type == 'insert')
		{
			$id = $this->usulan_dokumen_eksternal_model->insert($data);

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
			$return = $this->usulan_dokumen_eksternal_model->update($id, $data);
		}

		return $return;
	}
	private function save_dokumen_eksternal($judul="",$nomor="",$filename="",$pengusul="",$pemeriksa="",$pengesah="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['judul']        = $judul;
		$data['nomor']        = $nomor;
		$data['tanggal_berlaku']        = date("Y-m-d");
		//$data['distribusi']        = $this->input->post('dokumen_eksternal_distribusi');
		$data['pengusul']        = $pengusul;
		$data['pemeriksa']        = $pemeriksa;
		$data['pengesah']        = $pengesah;
		
		if ($type != 'update')
		{
			$data['created_by']        = $this->current_user->id;
		}
		$data['created_date']        = date("Y-m-d");
		$data['updated_by']        = $this->current_user->id;
		$data['updated_date']        = date("Y-m-d");
		$data['filename']        = $filename;
		 
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


}