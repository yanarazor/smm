<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends BF_Model {

	protected $table_name	= "pegawai";
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
			"field"		=> "pegawai_nip",
			"label"		=> "NIP",
			"rules"		=> "required|unique[bf_pegawai.nip,bf_pegawai.id]|max_length[25]"
		),
		array(
			"field"		=> "pegawai_no_absen",
			"label"		=> "No Absen",
			"rules"		=> "required|unique[bf_pegawai.no_absen,bf_pegawai.id]|max_length[10]"
		),
		array(
			"field"		=> "pegawai_nama",
			"label"		=> "Nama",
			"rules"		=> "required|max_length[50]"
		),
		array(
			"field"		=> "pegawai_jabatan",
			"label"		=> "Jabatan",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "pegawai_golongan",
			"label"		=> "Golongan",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "pegawai_nomor_rekening",
			"label"		=> "Nomor Rekening",
			"rules"		=> "max_length[30]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function find_all($nip = "",$nama = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama_jabatan,kelas_jabatan,tukin,pangkat,pangkat.golongan as gol,pajak');
		}
		 
		if($nama != ""){
			$this->db->where('nama like "%'.$nama.'%"');
		} 
	 
		if($nip != ""){
			$this->db->where('nip',$nip);
		} 
		$this->db->join('jabatan', 'jabatan.id = pegawai.jabatan', 'left'); 
		$this->db->join('pangkat', 'pangkat.kode_pangkat = pegawai.golongan', 'left'); 
		$this->db->order_by("jabatan.kelas_jabatan","DESC");
		$this->db->order_by('nama',"asc");
		return parent::find_all();

	}
	public function count_all($nip = "",$nama = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama_jabatan,pangkat,pangkat.golongan as gol');
		}
		 
		if($nama != ""){
			$this->db->where('nama like "%'.$nama.'%"');
		} 
	 
		if($nip != ""){
			$this->db->where('nip',$nip);
		} 
		$this->db->join('jabatan', 'jabatan.id = pegawai.jabatan', 'left'); 
		$this->db->join('pangkat', 'pangkat.kode_pangkat = pegawai.golongan', 'left'); 
		$this->db->order_by('nama',"asc");
		return parent::count_all();

	}
	public function find_absen($nip = "",$nama = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama_jabatan,kelas_jabatan,tukin,pangkat.pangkat,pangkat.golongan as gol,pajak');
		}
		 
		if($nama != ""){
			$this->db->where('nama like "%'.$nama.'%"');
		} 
	 
		if($nip != ""){
			$this->db->where('nip',$nip);
		} 
		$this->db->where('no_absen != ""');
		$this->db->join('jabatan', 'jabatan.id = pegawai.jabatan', 'left'); 
		$this->db->join('pangkat', 'pangkat.kode_pangkat = pegawai.golongan', 'left'); 
		$this->db->join('users', 'users.nip = pegawai.no_absen', 'left'); 
		$this->db->order_by("jabatan.kelas_jabatan","DESC");
		$this->db->order_by('nama',"asc");
		return parent::find_all();

	}
	public function find_bynip($nip = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,pangkat,pangkat.golongan as gol,pajak,jabatan as nama_jabatan,jabatan_ft,jabatan_fu');
		}
		 
		if($nip != ""){
			$this->db->where('nip',$nip);
		} 
		//$this->db->join('jabatan', 'jabatan.id = pegawai.jabatan', 'left'); 
		$this->db->join('pangkat', 'pangkat.kode_pangkat = pegawai.golongan', 'left'); 
		$this->db->order_by('nama',"asc");
		return parent::find_by("nip",$nip);

	}
	public function find_detil($nip  = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama_jabatan,kelas_jabatan,tukin,pangkat,pangkat.golongan as gol,pajak');
		}
		  
	 
		if($nip != ""){
			$this->db->where('nip',$nip);
		} 
		$this->db->where('no_absen != ""');
		$this->db->join('jabatan', 'jabatan.id = pegawai.jabatan', 'left'); 
		$this->db->join('pangkat', 'pangkat.kode_pangkat = pegawai.golongan', 'left'); 
		$this->db->order_by("jabatan.kelas_jabatan","DESC");
		$this->db->order_by('nama',"asc");
		return parent::find_all();

	}
	public function find_bynoabsen($no_absen = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		$this->db->where('no_absen',$no_absen); 
		$this->db->where('no_absen != ""');
		return parent::find_all();

	}
	public function isuniq($nip)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama_jabatan,pangkat,pangkat.golongan as gol');
		}
		$this->db->where('nip',$nip);
		$this->db->order_by('nama',"asc");
		return parent::count_all()>0;

	}
}
