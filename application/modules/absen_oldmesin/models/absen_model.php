<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absen_model extends BF_Model {

	protected $table_name	= "bf_viewabsen";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= false;
	protected $set_modified = false;

	/*
		Customize the operations of the model without recreating the insert, update,
		etc methods by adding the method names to act as callbacks here.
	 */
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 		= array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	/*
		For performance reasons, you may require your model to NOT return the
		id of the last inserted row as it is a bit of a slow method. This is
		primarily helpful when running big loops over data.
	 */
	protected $return_insert_id 	= TRUE;

	// The default type of element data is returned as.
	protected $return_type 			= "object";

	// Items that are always removed from data arrays prior to
	// any inserts or updates.
	protected $protected_attributes = array();

	/*
		You may need to move certain rules (like required) into the
		$insert_validation_rules array and out of the standard validation array.
		That way it is only required during inserts, not updates which may only
		be updating a portion of the data.
	 */
	protected $validation_rules 		= array(
		array(
			"field"		=> "absen_nik",
			"label"		=> "Nik",
			"rules"		=> "required|max_length[30]"
		),
		array(
			"field"		=> "absen_nama",
			"label"		=> "Nama",
			"rules"		=> "required|max_length[100]"
		),
		array(
			"field"		=> "absen_tanggal",
			"label"		=> "Tanggal",
			"rules"		=> "required"
		),
		array(
			"field"		=> "absen_jam",
			"label"		=> "Jam",
			"rules"		=> ""
		),
		array(
			"field"		=> "absen_sn_mesin",
			"label"		=> "SN mesin",
			"rules"		=> "max_length[30]"
		),
		array(
			"field"		=> "absen_verifikasi",
			"label"		=> "Verifikasi",
			"rules"		=> "max_length[20]"
		),
		array(
			"field"		=> "absen_model",
			"label"		=> "Model",
			"rules"		=> "max_length[20]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function find_all($nip="",$nama="",$tanggal="",$bulan="",$tahun="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		if($nip!=""){
			$this->db->where('nik like "%'.$nip.'%"');
		}
		if($nama!=""){
			$this->db->where('nama like "%'.$nama.'%"');
		}
		if($tanggal!=""){
			$this->db->where('tanggal',$tanggal);
		}
		if($bulan!=""){
			$this->db->where('tanggal like "%-'.$bulan.'-%"');
		} 
		if($tahun!=""){
			$this->db->where('tanggal like "%'.$tahun.'-%"');
		} 
		$this->db->order_by("tanggal","DESC");
		return parent::find_all();

	}
	public function count_all($nip="",$nama="",$tanggal="",$bulan="",$tahun="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		if($nip!=""){
			$this->db->where('nik like "%'.$nip.'%"');
		}
		if($nama!=""){
			$this->db->where('nama like "%'.$nama.'%"');
		}
		if($tanggal!=""){
			$this->db->where('tanggal',$tanggal);
		}
		if($bulan!=""){
			$this->db->where('tanggal like "%-'.$bulan.'-%"');
		} 
		if($tahun!=""){
			$this->db->where('tanggal like "%'.$tahun.'-%"');
		} 
		return parent::count_all();

	}
	public function rekap($nip="",$nama="",$bulan="",$tahun="")
	{
		$sql = "select * from bf_viewabsen";
		$sql .=' where nik != ""';
		if($nip!=""){
			$sql .=' and nik like "%'.$nip.'%"';
		}
		if($nama!=""){
			$sql .=' and nama like "%'.$nip.'%"';	 
		}
		if($bulan!=""){
			$sql .=' and tanggal like "%-'.$bulan.'-%"';
		}else{
			$sql .=' and tanggal like "%-'.date("m").'-%"';
		}
		if($tahun!=""){
			$sql .=' and tanggal like "%'.$tahun.'-%"';
		}else{
			$sql .=' and tanggal like "%'.date("Y").'-%"';
		}
		return $this->db->query($sql)->result();
	}
	public function rekapold($nip="",$nama="",$bulan="",$tahun="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		if($nip!=""){
			$this->db->where('nik like "%'.$nip.'%"');
		}
		if($nama!=""){
			$this->db->where('nama like "%'.$nama.'%"');
		}
		if($bulan!=""){
			$this->db->where('tanggal like "%-'.$bulan.'-%"');
		}else{
			$this->db->where('tanggal like "%-'.date("m").'-%"');
		}
		if($tahun!=""){
			$this->db->where('tanggal like "%'.$tahun.'-%"');
		}else{
			$this->db->where('tanggal like "%'.date("Y").'-%"');
		}
		return parent::find_all();

	}
	public function cekuniq($nip="",$tanggal="",$model="")
	{
		if(empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
			$this->db->where('nik',$nip);
			$this->db->where('tanggal',$tanggal);
			$this->db->where('model',$model);
			   
		return parent::count_all()>0;
	}

}
