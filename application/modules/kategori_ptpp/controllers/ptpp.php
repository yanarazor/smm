<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ptpp controller
 */
class ptpp extends Admin_Controller
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

		$this->auth->restrict('Kategori_Ptpp.Ptpp.View');
		$this->load->model('kategori_ptpp_model', null, true);
		$this->lang->load('kategori_ptpp');
		
		Template::set_block('sub_nav', 'ptpp/_sub_nav');

		Assets::add_module_js('kategori_ptpp', 'kategori_ptpp.js');
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
					$result = $this->kategori_ptpp_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('kategori_ptpp_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('kategori_ptpp_delete_failure') . $this->kategori_ptpp_model->error, 'error');
				}
			}
		}

		$records = $this->kategori_ptpp_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Kelola Kategori Ptpp');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Kategori Ptpp object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Kategori_Ptpp.Ptpp.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_kategori_ptpp())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('kategori_ptpp_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'kategori_ptpp');

				Template::set_message(lang('kategori_ptpp_create_success'), 'success');
				redirect(SITE_AREA .'/ptpp/kategori_ptpp');
			}
			else
			{
				Template::set_message(lang('kategori_ptpp_create_failure') . $this->kategori_ptpp_model->error, 'error');
			}
		}
		Assets::add_module_js('kategori_ptpp', 'kategori_ptpp.js');

		Template::set('toolbar_title', lang('kategori_ptpp_create') . ' Kategori Ptpp');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Kategori Ptpp data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('kategori_ptpp_invalid_id'), 'error');
			redirect(SITE_AREA .'/ptpp/kategori_ptpp');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Kategori_Ptpp.Ptpp.Edit');

			if ($this->save_kategori_ptpp('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('kategori_ptpp_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'kategori_ptpp');

				Template::set_message(lang('kategori_ptpp_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('kategori_ptpp_edit_failure') . $this->kategori_ptpp_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Kategori_Ptpp.Ptpp.Delete');

			if ($this->kategori_ptpp_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('kategori_ptpp_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'kategori_ptpp');

				Template::set_message(lang('kategori_ptpp_delete_success'), 'success');

				redirect(SITE_AREA .'/ptpp/kategori_ptpp');
			}
			else
			{
				Template::set_message(lang('kategori_ptpp_delete_failure') . $this->kategori_ptpp_model->error, 'error');
			}
		}
		Template::set('kategori_ptpp', $this->kategori_ptpp_model->find($id));
		Template::set('toolbar_title', lang('kategori_ptpp_edit') .' Kategori Ptpp');
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
	private function save_kategori_ptpp($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['kategori']        = $this->input->post('kategori_ptpp_kategori');

		if ($type == 'insert')
		{
			$id = $this->kategori_ptpp_model->insert($data);

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
			$return = $this->kategori_ptpp_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}