<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * masters controller
 */
class masters extends Admin_Controller
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

		
		$this->load->model('kegiatan_model', null, true);
		$this->lang->load('kegiatan');
		
		Template::set_block('sub_nav', 'masters/_sub_nav');

		Assets::add_module_js('kegiatan', 'kegiatan.js');
		
		$this->load->model('users/user_model', null, true);
		$this->user_model->where('nip != ""');
		$this->user_model->order_by('display_name',"asc");
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
		$this->auth->restrict('Kegiatan.Masters.View');
		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->kegiatan_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('kegiatan_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('kegiatan_delete_failure') . $this->kegiatan_model->error, 'error');
				}
			}
		}
		$pj = $this->input->get('pj');
		$judul = $this->input->get('judul');
		$tahun = $this->input->get('tahun') != "" ? $this->input->get('tahun') : date("Y");
		
		$records = $this->kegiatan_model->find_all($judul,$pj,$tahun);

		Template::set('records', $records);
		Template::set('judul', $judul);
		Template::set('pj', $pj);
		Template::set('toolbar_title', 'Manage Kegiatan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Kegiatan object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Kegiatan.Masters.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_kegiatan())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('kegiatan_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'kegiatan');

				Template::set_message(lang('kegiatan_create_success'), 'success');
				redirect(SITE_AREA .'/masters/kegiatan');
			}
			else
			{
				Template::set_message(lang('kegiatan_create_failure') . $this->kegiatan_model->error, 'error');
			}
		}
		Assets::add_module_js('kegiatan', 'kegiatan.js');

		Template::set('toolbar_title', lang('kegiatan_create') . ' Kegiatan');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Kegiatan data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('kegiatan_invalid_id'), 'error');
			redirect(SITE_AREA .'/masters/kegiatan');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Kegiatan.Masters.Edit');

			if ($this->save_kegiatan('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('kegiatan_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'kegiatan');

				Template::set_message(lang('kegiatan_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('kegiatan_edit_failure') . $this->kegiatan_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Kegiatan.Masters.Delete');

			if ($this->kegiatan_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('kegiatan_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'kegiatan');

				Template::set_message(lang('kegiatan_delete_success'), 'success');

				redirect(SITE_AREA .'/masters/kegiatan');
			}
			else
			{
				Template::set_message(lang('kegiatan_delete_failure') . $this->kegiatan_model->error, 'error');
			}
		}
		Template::set('kegiatan', $this->kegiatan_model->find($id));
		Template::set('toolbar_title', lang('kegiatan_edit') .' Kegiatan');
		Template::render();
	}
	public function getkegiatan()
	{
		$kegiatan 	= $this->input->get('kegiatan');
		$json = array(); 
		$records = $this->kegiatan_model->getbydipa($kegiatan);
		if(isset($records) && is_array($records) && count($records)):
			foreach ($records as $record) :
				$json['id'][] = $record->kode;
				$json['judul'][] = $record->judul;
			endforeach;
		endif;
		echo json_encode($json);
		die();
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
	private function save_kegiatan($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['tahun']        = $this->input->post('kegiatan_tahun');
		$data['dipa']        = $this->input->post('kegiatan_dipa');
		$data['kode']        = $this->input->post('kegiatan_kode');
		$data['judul']        = $this->input->post('kegiatan_judul');
		$data['pj']        = $this->input->post('pj');
		if ($type == 'insert')
		{
			$id = $this->kegiatan_model->insert($data);

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
			$return = $this->kegiatan_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}