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

		$this->auth->restrict('Jenis_Dokumen.Dokumen.View');
		$this->load->model('jenis_dokumen_model', null, true);
		$this->lang->load('jenis_dokumen');
		
		Template::set_block('sub_nav', 'dokumen/_sub_nav');

		Assets::add_module_js('jenis_dokumen', 'jenis_dokumen.js');
		
		$this->load->model('roles/role_model');
		$roles = $this->role_model->select('role_id, role_name')->where('deleted', 0)->find_all();
		$ordered_roles = array();
		foreach ($roles as $role)
		{
			$ordered_roles[$role->role_id] = $role;
		}
		Template::set('roles', $ordered_roles);

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
					$result = $this->jenis_dokumen_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('jenis_dokumen_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('jenis_dokumen_delete_failure') . $this->jenis_dokumen_model->error, 'error');
				}
			}
		}
		
		$this->load->library('pagination');
		$total = count($this->jenis_dokumen_model->find_all());
		$offset = $this->input->get('per_page');
		$limit = $this->settings_lib->item('site.list_limit');

		$this->pager['base_url'] 			= current_url() .'?';
		$this->pager['total_rows'] 			= $total;
		$this->pager['per_page'] 			= $limit;
		$this->pager['page_query_string']	= TRUE;
		$this->pagination->initialize($this->pager);
		
		 
		$records = $this->jenis_dokumen_model->limit($limit, $offset)->find_all(); 
		Template::set('records', $records);
		
		Template::set('toolbar_title', 'Kelola Jenis Dokumen');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Jenis Dokumen object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Jenis_Dokumen.Dokumen.Create');
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_jenis_dokumen())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jenis_dokumen_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'jenis_dokumen');

				Template::set_message(lang('jenis_dokumen_create_success'), 'success');
				redirect(SITE_AREA .'/dokumen/jenis_dokumen');
			}
			else
			{
				Template::set_message(lang('jenis_dokumen_create_failure') . $this->jenis_dokumen_model->error, 'error');
			}
		}
		Assets::add_module_js('jenis_dokumen', 'jenis_dokumen.js');

		Template::set('toolbar_title', lang('jenis_dokumen_create') . ' Jenis Dokumen');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Jenis Dokumen data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		Assets::add_css('jquery.wysiwyg.css');  
		Assets::add_css('font-awesome.min.css');  
		Assets::add_js('jquery.wysiwyg.js');

		if (empty($id))
		{
			Template::set_message(lang('jenis_dokumen_invalid_id'), 'error');
			redirect(SITE_AREA .'/dokumen/jenis_dokumen');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Jenis_Dokumen.Dokumen.Edit');

			if ($this->save_jenis_dokumen('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jenis_dokumen_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'jenis_dokumen');

				Template::set_message(lang('jenis_dokumen_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('jenis_dokumen_edit_failure') . $this->jenis_dokumen_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Jenis_Dokumen.Dokumen.Delete');

			if ($this->jenis_dokumen_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('jenis_dokumen_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'jenis_dokumen');

				Template::set_message(lang('jenis_dokumen_delete_success'), 'success');

				redirect(SITE_AREA .'/dokumen/jenis_dokumen');
			}
			else
			{
				Template::set_message(lang('jenis_dokumen_delete_failure') . $this->jenis_dokumen_model->error, 'error');
			}
		}
		Template::set('jenis_dokumen', $this->jenis_dokumen_model->find($id));
		Template::set('toolbar_title', lang('jenis_dokumen_edit') .' Jenis Dokumen');
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
	private function save_jenis_dokumen($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}
		
		$this->form_validation->set_rules('jenis_dokumen_jenis','Jenis Dokumen','required|unique[bf_jenis_dokumen.jenis,bf_jenis_dokumen.id]|max_length[50]');
		$this->form_validation->set_rules('jenis_dokumen_pemeriksa','Pemeriksa','is_natural|required|max_length[10]');
		$this->form_validation->set_rules('jenis_dokumen_pengesah','Pengesah','is_natural|max_length[10]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		// make sure we only pass in the fields we want
		
		$data = array();
		$data['jenis']        = $this->input->post('jenis_dokumen_jenis');
		$data['pemeriksa']        = $this->input->post('jenis_dokumen_pemeriksa');
		$data['pengesah']        = $this->input->post('jenis_dokumen_pengesah');
		$data['keterangan']        = $this->input->post('jenis_dokumen_keterangan');

		if ($type == 'insert')
		{
			$id = $this->jenis_dokumen_model->insert($data);

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
			$return = $this->jenis_dokumen_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}