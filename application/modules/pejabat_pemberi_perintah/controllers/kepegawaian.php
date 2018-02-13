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

		$this->auth->restrict('Pejabat_Pemberi_Perintah.Kepegawaian.View');
		$this->load->model('pejabat_pemberi_perintah_model', null, true);
		$this->lang->load('pejabat_pemberi_perintah');
		
		Template::set_block('sub_nav', 'kepegawaian/_sub_nav');

		Assets::add_module_js('pejabat_pemberi_perintah', 'pejabat_pemberi_perintah.js');
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
					$result = $this->pejabat_pemberi_perintah_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('pejabat_pemberi_perintah_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('pejabat_pemberi_perintah_delete_failure') . $this->pejabat_pemberi_perintah_model->error, 'error');
				}
			}
		}

		$records = $this->pejabat_pemberi_perintah_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Pejabat Pemberi Perintah');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Pejabat Pemberi Perintah object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Pejabat_Pemberi_Perintah.Kepegawaian.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_pejabat_pemberi_perintah())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pejabat_pemberi_perintah_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'pejabat_pemberi_perintah');

				Template::set_message(lang('pejabat_pemberi_perintah_create_success'), 'success');
				redirect(SITE_AREA .'/kepegawaian/pejabat_pemberi_perintah');
			}
			else
			{
				Template::set_message(lang('pejabat_pemberi_perintah_create_failure') . $this->pejabat_pemberi_perintah_model->error, 'error');
			}
		}
		Assets::add_module_js('pejabat_pemberi_perintah', 'pejabat_pemberi_perintah.js');

		Template::set('toolbar_title', lang('pejabat_pemberi_perintah_create') . ' Pejabat Pemberi Perintah');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Pejabat Pemberi Perintah data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('pejabat_pemberi_perintah_invalid_id'), 'error');
			redirect(SITE_AREA .'/kepegawaian/pejabat_pemberi_perintah');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Pejabat_Pemberi_Perintah.Kepegawaian.Edit');

			if ($this->save_pejabat_pemberi_perintah('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pejabat_pemberi_perintah_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'pejabat_pemberi_perintah');

				Template::set_message(lang('pejabat_pemberi_perintah_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('pejabat_pemberi_perintah_edit_failure') . $this->pejabat_pemberi_perintah_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Pejabat_Pemberi_Perintah.Kepegawaian.Delete');

			if ($this->pejabat_pemberi_perintah_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('pejabat_pemberi_perintah_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'pejabat_pemberi_perintah');

				Template::set_message(lang('pejabat_pemberi_perintah_delete_success'), 'success');

				redirect(SITE_AREA .'/kepegawaian/pejabat_pemberi_perintah');
			}
			else
			{
				Template::set_message(lang('pejabat_pemberi_perintah_delete_failure') . $this->pejabat_pemberi_perintah_model->error, 'error');
			}
		}
		Template::set('pejabat_pemberi_perintah', $this->pejabat_pemberi_perintah_model->find($id));
		Template::set('toolbar_title', lang('pejabat_pemberi_perintah_edit') .' Pejabat Pemberi Perintah');
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
	private function save_pejabat_pemberi_perintah($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nama']        = $this->input->post('pejabat_pemberi_perintah_nama');
		$data['nama_pejabat']        = $this->input->post('pejabat_pemberi_perintah_nama_pejabat');
		$data['nip']        = $this->input->post('pejabat_pemberi_perintah_nip');

		if ($type == 'insert')
		{
			$id = $this->pejabat_pemberi_perintah_model->insert($data);

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
			$return = $this->pejabat_pemberi_perintah_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}