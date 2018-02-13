<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permintaan_barang_detil_model extends BF_Model {

	protected $table_name	= "permintaan_barang_detil";
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
			"field"		=> "permintaan_barang_nomor",
			"label"		=> "Nomor",
			"rules"		=> "required|unique[bf_permintaan_barang.nomor,bf_permintaan_barang.id]|max_length[10]"
		),
		array(
			"field"		=> "permintaan_barang_user_request",
			"label"		=> "User",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "permintaan_barang_tanggal_permintaan",
			"label"		=> "Tanggal Permintaan",
			"rules"		=> ""
		),
		array(
			"field"		=> "permintaan_barang_anggaran",
			"label"		=> "Anggaran",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "permintaan_barang_kegiatan",
			"label"		=> "Kegiatan",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "permintaan_barang_tanggal_selesai",
			"label"		=> "Tanggal Permintaan Selesai",
			"rules"		=> ""
		),
		array(
			"field"		=> "permintaan_barang_status_atasan",
			"label"		=> "Status Atasan",
			"rules"		=> ""
		),
		array(
			"field"		=> "permintaan_barang_status_kabag",
			"label"		=> "Status Kabag",
			"rules"		=> ""
		),
		array(
			"field"		=> "permintaan_barang_status_permintaan",
			"label"		=> "Status Permintaan",
			"rules"		=> "max_length[2]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function find_byidpermintaan($id_permintaan,$mak = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,status as statusbarang,status');
		}
		if($mak != ""){
			$this->db->where('mark like "'.$mak.'%"');
		} 
		
		$this->db->where('id_permintaan',$id_permintaan);
		$this->db->join('status_barang', 'permintaan_barang_detil.status_barang = status_barang.id', 'left'); 
		return parent::find_all();

	} 
	public function find_byidpermintaanppk($id_permintaan,$mak = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,status as statusbarang,status');
		}
		if($mak != ""){
			$this->db->where('mark like "'.$mak.'%"');
		} 
		$this->db->where('status_ppk',1);
		$this->db->where('id_permintaan',$id_permintaan);
		$this->db->join('status_barang', 'permintaan_barang_detil.status_barang = status_barang.id', 'left'); 
		return parent::find_all();

	} 
	  
	public function find_pengadaan($key="",$bulan = "",$tahun = "",$kg = "",$pg = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama_barang,spek_barang,nomor,tanggal_permintaan,anggaran,kegiatan,permintaan_barang.id as idpermintaan,nama_status_pengadaan,display_name');
		}
		if($key!=""){
			$this->db->where('permintaan_barang.nomor like "'.$key.'"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		} 
		if($pg != ""){
			$this->db->where('user_request',$pg);
		} 
		$this->db->join('permintaan_barang', 'permintaan_barang_detil.id_permintaan = permintaan_barang.id', 'left'); 
		$this->db->join('status_pengadaan', 'permintaan_barang_detil.status_pengadaan = status_pengadaan.id', 'left'); 
		$this->db->join('users', 'users.id = permintaan_barang.user_request', 'left'); 
		$this->db->order_by('tgl_kirim_pengadaan',"Desc");
		$this->db->order_by('tanggal_permintaan',"Desc");
		return parent::find_all();

	}
	public function find($id = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama_barang,spek_barang,nomor,tanggal_permintaan,anggaran,kegiatan,permintaan_barang.id as idpermintaan,nama_status_pengadaan,display_name');
		}
		 
		  
		$this->db->join('permintaan_barang', 'permintaan_barang_detil.id_permintaan = permintaan_barang.id', 'left'); 
		$this->db->join('status_pengadaan', 'permintaan_barang_detil.status_pengadaan = status_pengadaan.id', 'left'); 
		$this->db->join('users', 'users.id = permintaan_barang.user_request', 'left'); 
		 
		return parent::find($id);

	}
	public function check_mak($id_permintaan,$mak = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		$this->db->where('id_permintaan',$id_permintaan);
		$this->db->where('mark like "'.$mak.'%"');
		return parent::count_all();

	} 

}
