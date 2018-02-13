<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * perbaikan controller
 */
class perbaikan extends Admin_Controller
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

		
		$this->load->model('perbaikan_sarpras_model', null, true);
		$this->lang->load('perbaikan_sarpras');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'perbaikan/_sub_nav');
		$this->load->model('jenis_pemeliharaan/jenis_pemeliharaan_model', null, true);
		$jenis_pemeliharaans = $this->jenis_pemeliharaan_model->find_all();
		Template::set('jenis_pemeliharaans', $jenis_pemeliharaans);
		
		$this->load->model('status_pemeliharaan/status_pemeliharaan_model', null, true);
		$status_pemeliharaans = $this->status_pemeliharaan_model->find_all();
		Template::set('status_pemeliharaans', $status_pemeliharaans);
		
		$this->load->model('users/user_model', null, true);
		$this->user_model->where('nip != ""');
		$this->user_model->order_by('display_name',"asc");
		$users = $this->user_model->find_all();
		Template::set('users', $users);
		
		Assets::add_module_js('perbaikan_sarpras', 'perbaikan_sarpras.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.View');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->perbaikan_sarpras_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('perbaikan_sarpras_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('perbaikan_sarpras_delete_failure') . $this->perbaikan_sarpras_model->error, 'error');
				}
			}
		}
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$total = $this->perbaikan_sarpras_model->count_all($keyword,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&status=".$status."&user=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$records = $this->perbaikan_sarpras_model->limit($limit, $offset)->find_all($keyword,$status,$pg);
		Template::set('total', $total); 
		Template::set('pg', $pg);
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Perbaikan sarpras');
		Template::render();
	}
	public function periksakpu()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Kpu');
		 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$total = $this->perbaikan_sarpras_model->count_all($keyword,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&status=".$status."&user=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$records = $this->perbaikan_sarpras_model->limit($limit, $offset)->find_all($keyword,$status,$pg);
		Template::set('total', $total); 
		Template::set('pg', $pg);
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Perbaikan sarpras');
		Template::render();
	}
	public function periksappk()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Ppk');
		 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		$total = $this->perbaikan_sarpras_model->count_allppk($keyword,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&status=".$status."&user=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		$records = $this->perbaikan_sarpras_model->limit($limit, $offset)->find_allppk($keyword,$status,$pg);
		Template::set('total', $total); 
		Template::set('pg', $pg);
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Perbaikan [PPK]');
		Template::render();
	}
	 
	public function gedunglist()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Gedung');
		 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"1");
		$total = $this->perbaikan_sarpras_model->count_all($keyword,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&status=".$status."&user=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"1");
		$records = $this->perbaikan_sarpras_model->limit($limit, $offset)->find_all($keyword,$status,$pg);
		Template::set('total', $total); 
		Template::set('pg', $pg);
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Perbaikan Gedung');
		Template::render();
	}

	public function jarkomlist()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Jarkom');
		 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"2");
		$total = $this->perbaikan_sarpras_model->count_all($keyword,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&status=".$status."&user=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"2");
		$records = $this->perbaikan_sarpras_model->limit($limit, $offset)->find_all($keyword,$status,$pg);
		Template::set('total', $total); 
		Template::set('pg', $pg);
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Perbaikan Jaringan/Komputer');
		Template::render();
	}
	public function perlengkapanlist()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Perlengkapan');
		 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"3");
		$total = $this->perbaikan_sarpras_model->count_all($keyword,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&status=".$status."&user=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"3");
		$records = $this->perbaikan_sarpras_model->limit($limit, $offset)->find_all($keyword,$status,$pg);
		Template::set('total', $total); 
		Template::set('pg', $pg);
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Perbaikan Perlengkapan Kantor');
		Template::render();
	}
	public function lablist()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Lab');
		 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"4");
		$total = $this->perbaikan_sarpras_model->count_all($keyword,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&status=".$status."&user=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"4");
		$records = $this->perbaikan_sarpras_model->limit($limit, $offset)->find_all($keyword,$status,$pg);
		Template::set('total', $total); 
		Template::set('pg', $pg);
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Perbaikan Mesin Lab');
		Template::render();
	}
	public function kalibrasilist()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Kalibrasi');
		 
		$keyword = $this->input->get('keyword');
		$pg 	= $this->input->get('pg');
		$status		= $this->input->get('status');
		$this->load->library('pagination');
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"5");
		$total = $this->perbaikan_sarpras_model->count_all($keyword,$status,$pg);
		 
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url()."?keyword=".$keyword."&status=".$status."&user=".$pg;
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);	
		if($this->current_user->role_id != "1" and $this->current_user->role_id != "16")
		{
			//$this->perbaikan_sarpras_model->where('user',$this->current_user->id);
		}
		$this->perbaikan_sarpras_model->where('perbaikan_sarpras.jenis',"5");
		$records = $this->perbaikan_sarpras_model->limit($limit, $offset)->find_all($keyword,$status,$pg);
		Template::set('total', $total); 
		Template::set('pg', $pg);
		Template::set('status', $status); 
		Template::set('keyword', $keyword); 
		Template::set('records', $records);
		Template::set('toolbar_title', 'Perbaikan dan Pemeliharaan Mobil');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Perbaikan sarpras object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Create');
		// get nomor otomatis
		$noauto = date("y").sprintf( '%05d', "01" );
		// get kode terakhis pada hari ini
		$nomorpermintaan = date("Y");
		$this->perbaikan_sarpras_model->where("tanggal_kirim like '".$nomorpermintaan."-%'");
		$this->perbaikan_sarpras_model->order_by("id","desc");
		$recordsst = $this->perbaikan_sarpras_model->limit(1)->find_all();
		//print_r($recordsst);
		if(isset($recordsst) && is_array($recordsst) && count($recordsst))
		{
			$nomor = (int)$recordsst[0]->nomor + 1;
			if($nomor <= 9)
				$nomor = "0".$nomor;
				
			 $noauto = $nomor;
		}
		
		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_perbaikan_sarpras())
			{
				// kirim email ke penanggung jawab peralatan
				$jenispemeliharaan = $this->input->post('perbaikan_sarpras_jenis');
				$recordjenis = $this->jenis_pemeliharaan_model->find_by("id",$jenispemeliharaan);
				$penanggungjawab = isset($recordjenis->petugas) ? $recordjenis->petugas : "207";// 207 : nandang
				
				$tambahan_email = "<br>Dari : ".$this->current_user->display_name."<br>";
				$tambahan_email .= "Nomor Usulan : ".$noauto."<br>";
				
				$msg = "Mohon ditindaklanjuti permintaan perbaikan/pemeliharaan,<br>";
				$resultmail = $this->sendmail("",$penanggungjawab,$msg.$tambahan_email."<br/>Klik <a href='".base_url()."index.php/admin/perbaikan/perbaikan_sarpras/perbaikanedit/".$insert_id."'>link</a>");		
				
				// end kirim email
				// Log the activity
				log_activity($this->current_user->id, lang('perbaikan_sarpras_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'perbaikan_sarpras');

				Template::set_message(lang('perbaikan_sarpras_create_success'), 'success');
				redirect(SITE_AREA .'/perbaikan/perbaikan_sarpras');
			}
			else
			{
				Template::set_message(lang('perbaikan_sarpras_create_failure') . $this->perbaikan_sarpras_model->error, 'error');
			}
		}
		Assets::add_module_js('perbaikan_sarpras', 'perbaikan_sarpras.js');
		Template::set('noauto', $noauto);
		Template::set('toolbar_title', lang('perbaikan_sarpras_create') . ' Perbaikan sarpras');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Perbaikan sarpras data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Edit');
		if (empty($id))
		{
			Template::set_message(lang('perbaikan_sarpras_invalid_id'), 'error');
			redirect(SITE_AREA .'/perbaikan/perbaikan_sarpras');
		}

		if (isset($_POST['save']))
		{
			

			if ($this->save_perbaikan_sarpras('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('perbaikan_sarpras_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'perbaikan_sarpras');

				Template::set_message(lang('perbaikan_sarpras_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('perbaikan_sarpras_edit_failure') . $this->perbaikan_sarpras_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Delete');

			if ($this->perbaikan_sarpras_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('perbaikan_sarpras_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'perbaikan_sarpras');

				Template::set_message(lang('perbaikan_sarpras_delete_success'), 'success');

				redirect(SITE_AREA .'/perbaikan/perbaikan_sarpras');
			}
			else
			{
				Template::set_message(lang('perbaikan_sarpras_delete_failure') . $this->perbaikan_sarpras_model->error, 'error');
			}
		}
		Template::set('perbaikan_sarpras', $this->perbaikan_sarpras_model->find($id));
		Template::set('toolbar_title', lang('perbaikan_sarpras_edit') .' Perbaikan sarpras');
		Template::render();
	}
	public function periksa()
	{
		$id = $this->uri->segment(5);
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Kpu');
		if (empty($id))
		{
			Template::set_message(lang('perbaikan_sarpras_invalid_id'), 'error');
			redirect(SITE_AREA .'/perbaikan/perbaikan_sarpras');
		}

		if (isset($_POST['save']))
		{
			

			if ($this->save_perbaikan_sarprasPerbaikanKpu('update', $id))
			{
				if($this->input->post('status_kpu') == "1") // jika setuju
				{
					$userppk = "1";// 1 : Yana
					$anggaran = $this->input->post('anggaran');
					if($anggaran == "Rutin"){
						$userppk = "27";
					}else{
						$userppk = "37";
					}
					
					$datadetil = $this->perbaikan_sarpras_model->find_detil($id);
					$nomorpermintaan = $datadetil->nomor;
					$userrequest = $datadetil->display_name;
					$jenis_perbaikan = $datadetil->jenis_perbaikan;
				
					$msg = "<br>";
					$msg .= "Nomor permintaan : #".$nomorpermintaan.",<br>";
					$msg .= "Dari : ".$userrequest.",<br>";
					$msg .= "Jenis Pemeliharaan : ".$jenis_perbaikan.",<br>";
					$msg .= 'Rekomendasi : "'.$this->input->post('rekomendasi').'"<br>';
					$msg .= '"'.$this->input->post('catatan').'"<br>';
					$resultmail = $this->sendmail("",$userppk,$msg."<br/>Klik <a href='".base_url()."index.php/admin/perbaikan/perbaikan_sarpras/periksasub/".$id."'>link</a>");		
					// end user kabid sarprass
				}
				// Log the activity
				log_activity($this->current_user->id, lang('perbaikan_sarpras_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'perbaikan_sarpras');

				Template::set_message(lang('perbaikan_sarpras_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('perbaikan_sarpras_edit_failure') . $this->perbaikan_sarpras_model->error, 'error');
			}
		}
		Template::set('perbaikan_sarpras', $this->perbaikan_sarpras_model->find($id));
		Template::set('toolbar_title', lang('perbaikan_sarpras_edit') .' Perbaikan sarpras');
		Template::render();
	}
	public function periksasub()
	{
		$id = $this->uri->segment(5);
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.ppk');
		if (empty($id))
		{
			Template::set_message(lang('perbaikan_sarpras_invalid_id'), 'error');
			redirect(SITE_AREA .'/perbaikan/perbaikan_sarpras');
		}

		if (isset($_POST['save']))
		{
			

			if ($this->save_perbaikan_sarprassub('update', $id))
			{
				
					$datadetil = $this->perbaikan_sarpras_model->find_detil($id);
					$nomorpermintaan = $datadetil->nomor;
					$userrequest = $datadetil->display_name;
					$jenis_perbaikan = $datadetil->jenis_perbaikan;
					$msg = ",Mohon ditindaklanjuti permintaan perbaikan/pemeliharaan,<br>";
					$msg .= "Nomor permintaan : #".$nomorpermintaan.",<br>";
					$msg .= "Dari : ".$userrequest.",<br>";
					$msg .= "Jenis Pemeliharaan : ".$jenis_perbaikan.",<br>";
					$msg .= 'Rekomendasi : "'.$this->input->post('rekomendasi').'"<br>';
					$msg .= '"'.$this->input->post('catatan').'"<br>';
					
				// kirim email ke penanggung jawab peralatan
				 	$jenispemeliharaan = $this->input->post('perbaikan_sarpras_jenis');
					$recordjenis = $this->jenis_pemeliharaan_model->find_by("id",$jenispemeliharaan);
					$penanggungjawab = isset($recordjenis->petugas) ? $recordjenis->petugas : "1";// 207 : nandang
					
					$msg .= '"'.$this->input->post('catatan_subid').'"<br>';
					$resultmail = $this->sendmail("",$penanggungjawab,$msg."<br/>Klik <a href='".base_url()."index.php/admin/perbaikan/perbaikan_sarpras/perbaikanedit/".$id."'>link</a>");		

				// Log the activity
				log_activity($this->current_user->id, lang('perbaikan_sarpras_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'perbaikan_sarpras');

				Template::set_message(lang('perbaikan_sarpras_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('perbaikan_sarpras_edit_failure') . $this->perbaikan_sarpras_model->error, 'error');
			}
		}
		 
		Template::set('perbaikan_sarpras', $this->perbaikan_sarpras_model->find($id));
		Template::set('toolbar_title', lang('perbaikan_sarpras_edit') .' Perbaikan sarpras');
		Template::render();
	}
	public function perbaikanedit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('perbaikan_sarpras_invalid_id'), 'error');
			redirect(SITE_AREA .'/perbaikan/perbaikan_sarpras');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Edit');

			if ($this->save_perbaikan_sarprasPerbaikan('update', $id))
			{
				$datadetil = $this->perbaikan_sarpras_model->find_detil($id);
				$nomorpermintaan = $datadetil->nomor;
				$userrequest = $datadetil->display_name;
				$user = $datadetil->user;
				$jenis_perbaikan = $datadetil->jenis_perbaikan;
				if($this->input->post('status') == "8")	{
					// setelah di save kirim email ke tiga tiganya
					$msg = "Permintaan perbaikan anda dengan Nomor permintaan : #".$nomorpermintaan." Telah selesai,<br>";
					$resultmail = $this->sendmail("",$user,$msg."<br/>Klik <a href='".base_url()."index.php/admin/perbaikan/perbaikan_sarpras/?keyword=".$nomorpermintaan."'>link</a>");		
					
				}else{
					// setelah di save kirim email ke tiga tiganya
					$msg = "Nomor permintaan : #".$nomorpermintaan.",<br>";
					$msg .= "Dari : ".$userrequest.",<br>";
					$msg .= "Jenis Pemeliharaan : ".$jenis_perbaikan.",<br>";
					$msg .= 'Rekomendasi : "'.$this->input->post('rekomendasi').'"<br>';
					// 2. Kasub KPU
					$this->user_model->where('users.role_id','16');
					$this->user_model->order_by('display_name',"asc");
					$users = $this->user_model->find_all();
					if (isset($users) && is_array($users) && count($users)):
						foreach($users as $rec):
							if($rec->email != ""):
								$email = $rec->email;
								$resultmail = $this->sendmail("1",$email,$msg."<br/>Klik <a href='".base_url()."index.php/admin/perbaikan/perbaikan_sarpras/periksakpu?keyword=".$nomorpermintaan."'>link</a>");		
							endif;
						endforeach;
					endif;
					// end user kabid sarprass
					// 3. user
					//$resultmail = $this->sendmail("",$userrequest,$msg."<br/>Klik <a href='".base_url()."index.php/admin/perbaikan/perbaikan_sarpras?keyword=".$nomorpermintaan."'>link</a>");		
					// end kirim email
				
				}
				
				
				// Log the activity
				log_activity($this->current_user->id, lang('perbaikan_sarpras_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'perbaikan_sarpras');

				Template::set_message(lang('perbaikan_sarpras_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('perbaikan_sarpras_edit_failure') . $this->perbaikan_sarpras_model->error, 'error');
			}
		}
		 
		Template::set('perbaikan_sarpras', $this->perbaikan_sarpras_model->find($id));
		Template::set('toolbar_title', lang('perbaikan_sarpras_edit') .' Perbaikan sarpras');
		Template::render();
	}
	public function perbaikankalibrasi()
	{
		$id = $this->uri->segment(5);
		$this->auth->restrict('Perbaikan_sarpras.Perbaikan.Kalibrasi');
		if (empty($id))
		{
			Template::set_message(lang('perbaikan_sarpras_invalid_id'), 'error');
			redirect(SITE_AREA .'/perbaikan/perbaikan_sarpras');
		}

		if (isset($_POST['save']))
		{
			

			if ($this->save_perbaikan_sarpraskalibrasi('update', $id))
			{
				$datadetil = $this->perbaikan_sarpras_model->find($id);
				$nomorpermintaan = $datadetil->nomor;
				$userrequest = $datadetil->user;
				// setelah di save kirim email ke tiga tiganya
				$msg = "Telah dilakukan perubahan status untuk nomor permintaan : #".$nomorpermintaan." oleh penanggung jawab pekerjaan,<br>";
				$msg .= 'Rekomendasi : "'.$this->input->post('rekomendasi').'"<br>';
				// 2. Kasub KPU
				$this->user_model->where('users.role_id','16');
				$this->user_model->order_by('display_name',"asc");
				$users = $this->user_model->find_all();
				if (isset($users) && is_array($users) && count($users)):
					foreach($users as $rec):
						if($rec->email != ""):
							$email = $rec->email;
							$resultmail = $this->sendmail("1",$email,$msg."<br/>Klik <a href='".base_url()."index.php/admin/perbaikan/perbaikan_sarpras/periksakpu?keyword=".$nomorpermintaan."'>link</a>");		
						endif;
					endforeach;
				endif;
				// end user kabid sarprass
				// 3. user
				$resultmail = $this->sendmail("",$userrequest,$msg."<br/>Klik <a href='".base_url()."index.php/admin/perbaikan/perbaikan_sarpras?keyword=".$nomorpermintaan."'>link</a>");		
				// end kirim email
				// Log the activity
				log_activity($this->current_user->id, lang('perbaikan_sarpras_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'perbaikan_sarpras');

				Template::set_message(lang('perbaikan_sarpras_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('perbaikan_sarpras_edit_failure') . $this->perbaikan_sarpras_model->error, 'error');
			}
		}
		 
		Template::set('perbaikan_sarpras', $this->perbaikan_sarpras_model->find($id));
		Template::set('toolbar_title', lang('perbaikan_sarpras_edit') .' Perbaikan sarpras');
		Template::render();
	}
	private function sendmail($kode,$user,$tambahan="")
	{
		if($kode != "1"){
			 $user = $this->user_model->find($user);
			 $email = "";
			 if (isset($user))
			 {
				 $email = $user->email;
			 }
			 //die($email);
		}else{
			$email = $user;
		}
		//sending mail
		$subjek       		= "Notifikasi Permintaan perbaikan ";
		$isi        	= "Anda Perlu memeriksa Permintaan perbaikan ".$tambahan;
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
	private function save_perbaikan_sarpras($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nomor']        = $this->input->post('perbaikan_sarpras_nomor');
		$data['jenis']        = $this->input->post('perbaikan_sarpras_jenis');
		$data['nama_sarpras']        = $this->input->post('perbaikan_sarpras_nama_sarpras');
		$data['nomor_inventaris']        = $this->input->post('perbaikan_sarpras_nomor_inventaris');
		$data['keluhan']        = $this->input->post('perbaikan_sarpras_keluhan');
		$data['status']        = $this->input->post('status') != "" ? $this->input->post('lokasi') : "1";
		$data['lokasi']        = $this->input->post('lokasi');
		$data['merek']        = $this->input->post('merek');
		$data['spesifikasi_alat']        	= $this->input->post('spesifikasi_alat');
		$data['kalibrasi_diminta']        	= $this->input->post('kalibrasi_diminta');
		if ($type == 'insert')
		{
			$data['user']       			= $this->current_user->id;
			$data['tanggal_kirim']       		= date("Y-m-d");
			$id = $this->perbaikan_sarpras_model->insert($data);

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
			$return = $this->perbaikan_sarpras_model->update($id, $data);
		}

		return $return;
	}
	private function save_perbaikan_sarprasPerbaikan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['rekomendasi']        = $this->input->post('rekomendasi');
		$data['status']        = $this->input->post('status');
		$data['biaya_kalibrasi']        = $this->input->post('biaya_kalibrasi');
		if ($type == 'insert')
		{
			
			$id = $this->perbaikan_sarpras_model->insert($data);

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
			$data['tgl_proses']       		= date("Y-m-d");
			$return = $this->perbaikan_sarpras_model->update($id, $data);
		}

		return $return;
	}
	private function save_perbaikan_sarpraskalibrasi($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['lab_kalibrasi']        = $this->input->post('lab_kalibrasi');
		$data['biaya_kalibrasi']        = $this->input->post('biaya_kalibrasi');
		$data['status']        = $this->input->post('status');
		
		if ($type == 'insert')
		{
			
			$id = $this->perbaikan_sarpras_model->insert($data);

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
			$data['tgl_proses']       		= date("Y-m-d");
			$return = $this->perbaikan_sarpras_model->update($id, $data);
		}

		return $return;
	}
	private function save_perbaikan_sarprasPerbaikanKpu($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['catatan_kpu']        	= $this->input->post('catatan');
		$data['status_kpu']        		= $this->input->post('status_kpu');
		$data['biaya_kalibrasi']        = $this->input->post('biaya_kalibrasi');
		$data['anggaran']        = $this->input->post('anggaran');
		if ($type == 'insert')
		{
			
			$id = $this->perbaikan_sarpras_model->insert($data);

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
			$return = $this->perbaikan_sarpras_model->update($id, $data);
		}

		return $return;
	}
	private function save_perbaikan_sarprassub($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['catatan_subid']        = $this->input->post('catatan_subid');
		$data['status_ppk']        = $this->input->post('status_ppk');
		if ($type == 'insert')
		{
			
			$id = $this->perbaikan_sarpras_model->insert($data);

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
			$return = $this->perbaikan_sarpras_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}