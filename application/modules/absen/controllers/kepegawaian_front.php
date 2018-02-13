<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * kepegawaian controller
 */
class kepegawaian_front extends Front_Controller
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

		//$this->auth->restrict('Absen.Kepegawaian.View');
		$this->load->model('absen_model', null, true);
		  
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	 
	public function upload()
	{
		Assets::add_css('uploadify.css');
		Assets::add_js('jquery.uploadify.js');
		Assets::add_js('jquery.uniform.min.js');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_js('jquery.cleditor.min.js');
		Assets::add_js('jquery.imagesloaded.js');
		Assets::add_js('custom.js');
		 
		$nip = $this->input->get('nip');
		$nama = $this->input->get('nama');
		$tgl = $this->input->get('tgl');
		  
		Template::set('toolbar_title', 'Upload Absen');
		Template::render();
	}
	public function import_data()
	{
		$original_session_id = $this->input->get('session_id');
		$user_id = $this->input->get('user_id');
		$provinsi = $this->input->get('provinsi');
		$sudahada = 0;
		$success = 0;
		$newdata = array(
            'session_id'  => $original_session_id,                   
               );
		$this->session->set_userdata($newdata);
		
		// handle upload
		$this->load->helper('handle_upload');
		$uploadData = array();
		$upload = true;
		  if (isset($_FILES['Filedata']) && is_array($_FILES['Filedata']) && $_FILES['Filedata']['error'] != 4)
		  {
			  $uploadData = handle_upload('Filedata',$this->settings_lib->item('site.pathuploaded').'excell-absen/');
			  //die($uploadData);
			  //print_r($uploadData);
			  
			  if (isset($uploadData['error']) && !empty($uploadData['error']))
			  {
				  $upload = false;
				  die("Upload error");
			  }else{
				  // end handle upload
				  $this->load->library('Convert');
				  $Class_Convert = new Convert;
				  //$file = $this->settings_lib->item('site.pathuploaded').'excell-absen/absenmaret.xlsx';
				  if(isset($uploadData['data']['file_name']))
					  $file = $this->settings_lib->item('site.pathuploaded').'excell-absen/'.$uploadData['data']['file_name'];
				  else
					  $file ="";
				  $this->load->library('Excel');
				  $objPHPExcel = PHPExcel_IOFactory::load($file);
		 
				  //  Get worksheet dimensions
				  $sheet = $objPHPExcel->getSheet(0); 
				  $highestRow = $sheet->getHighestRow(); 
				  $highestColumn = $sheet->getHighestColumn();

				  //  Loop through each row of the worksheet in turn
				  for ($row = 2; $row <= $highestRow; $row++){ 
					  //  Read a row of data into an array
					  $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
													  NULL,
													  TRUE,
													  FALSE);
					  //  Insert row data array into your database of choice here
					  $tanggal = $Class_Convert->fmtDate2($rowData[0][3],"yyyy-mm-dd");
			 
					  $nip =  preg_replace("/\s+/", "",$rowData[0][1]);
					  if(!$this->absen_model->cekuniq($nip,$tanggal,$rowData[0][8]))
					  {
					  	$success++;
					  	$this->generate_save($nip,$rowData[0][2],$tanggal,$rowData[0][4],$rowData[0][5],$rowData[0][7],$rowData[0][8]);
					  }else{
					  	$sudahada++;
					  }
					  //echo $nomor;	
			  }
		  } 	
		
		}
		$msgsudahada = "";
		$msgsuccess = "";
		if($sudahada>0)
			$msgsudahada .= "Duplikasi data : ".$sudahada." data";
		if($success>0)
			$msgsuccess .= "Berhasil : ".$success." data";
		echo $msgsuccess.$msgsudahada."\nUpload Selesai";
	   //send the data in an array format
	 	exit;
		 
	}

	 
	private function generate_save($nik="",$nama="",$tanggal="",$jam="",$snmesin="",$verifikasi="",$model="",$type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['nik']        = $nik;
		$data['nama']        = $nama;
		$data['tanggal']        = $tanggal ? $tanggal : '0000-00-00';
		$data['jam']        = $jam;
		$data['sn_mesin']        = $snmesin;
		$data['verifikasi']        = $verifikasi;
		$data['model']        = $model;

		if ($type == 'insert')
		{
			$id = $this->absen_model->insert($data);

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
			$return = $this->absen_model->update($id, $data);
		}

		return $return;
	}
	//--------------------------------------------------------------------


}