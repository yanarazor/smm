<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * content controller
 */
class content extends Admin_Controller
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

		$this->auth->restrict('Agenda.Content.View');
		$this->load->model('agenda_model', null, true);
		$this->lang->load('agenda');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'content/_sub_nav');

		Assets::add_module_js('agenda', 'agenda.js');
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
					$result = $this->agenda_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('agenda_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('agenda_delete_failure') . $this->agenda_model->error, 'error');
				}
			}
		}

		$records = $this->agenda_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage agenda');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a agenda object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Agenda.Content.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_agenda())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('agenda_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'agenda');

				Template::set_message(lang('agenda_create_success'), 'success');
				redirect(SITE_AREA .'/content/agenda');
			}
			else
			{
				Template::set_message(lang('agenda_create_failure') . $this->agenda_model->error, 'error');
			}
		}
		Assets::add_module_js('agenda', 'agenda.js');

		Template::set('toolbar_title', lang('agenda_create') . ' agenda');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of agenda data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('agenda_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/agenda');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Agenda.Content.Edit');

			if ($this->save_agenda('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('agenda_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'agenda');

				Template::set_message(lang('agenda_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('agenda_edit_failure') . $this->agenda_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Agenda.Content.Delete');

			if ($this->agenda_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('agenda_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'agenda');

				Template::set_message(lang('agenda_delete_success'), 'success');

				redirect(SITE_AREA .'/content/agenda');
			}
			else
			{
				Template::set_message(lang('agenda_delete_failure') . $this->agenda_model->error, 'error');
			}
		}
		Template::set('agenda', $this->agenda_model->find($id));
		Template::set('toolbar_title', lang('agenda_edit') .' agenda');
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
	private function save_agenda($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['dari']        = $this->input->post('agenda_dari') ? $this->input->post('agenda_dari') : '0000-00-00';
		$data['sampai']        = $this->input->post('agenda_sampai') ? $this->input->post('agenda_sampai') : '0000-00-00';
		$data['kategori']        = $this->input->post('agenda_kategori');
		$data['tempat']        = $this->input->post('agenda_tempat');
		$data['kegiatan']        = $this->input->post('agenda_kegiatan');

		if ($type == 'insert')
		{
			$id = $this->agenda_model->insert($data);

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
			$return = $this->agenda_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}