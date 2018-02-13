<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_induk_dokumen_model extends BF_Model {

	protected $table_name	= "daftar_induk_dokumen";
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
			"field"		=> "daftar_induk_dokumen_judul",
			"label"		=> "judul",
			"rules"		=> "required|unique[bf_daftar_induk_dokumen.judul,bf_daftar_induk_dokumen.id]|max_length[100]"
		),
		array(
			"field"		=> "daftar_induk_dokumen_nomor",
			"label"		=> "Nomor",
			"rules"		=> "required|max_length[50]"
		),
		array(
			"field"		=> "daftar_induk_dokumen_revisi",
			"label"		=> "Revisi",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_induk_dokumen_tanggal_berlaku",
			"label"		=> "Tanggal Berlaku",
			"rules"		=> "required"
		),
		array(
			"field"		=> "daftar_induk_dokumen_distribusi",
			"label"		=> "Distribusi Lokasi Pemakaian",
			"rules"		=> "max_length[100]"
		),
		array(
			"field"		=> "daftar_induk_dokumen_tanggal_dibuat",
			"label"		=> "Tanggal Dibuat",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_induk_dokumen_tanggal_diperiksa",
			"label"		=> "Tanggal Diperiksa",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_induk_dokumen_tanggal_disetujui",
			"label"		=> "Tanggal Disetujui",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_induk_dokumen_pembuat",
			"label"		=> "DIbuat Oleh",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_induk_dokumen_pemeriksa",
			"label"		=> "Diperiksa Oleh",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_induk_dokumen_pengesah",
			"label"		=> "Disahkan Oleh",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_induk_dokumen_jenis_dokumen",
			"label"		=> "Jenis Dokumen",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_induk_dokumen_keterangan",
			"label"		=> "Keterangan",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_induk_dokumen_filename",
			"label"		=> "File Name",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_induk_dokumen_status_active",
			"label"		=> "Status",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function find_all($keyword="",$bidang="",$jenis="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pembuat,us.display_name as user_pemeriksa,usr.display_name as user_pengesah,jenis,bidang.bidang as namabidang');
		}
		if($keyword!=""){
			$this->db->where('judul like "%'.$keyword.'%"');
		}
		if($bidang!=""){
			$this->db->where('daftar_induk_dokumen.bidang',$bidang);
		}
		if($jenis!=""){
			$this->db->where('jenis_dokumen',$jenis);
		}
		$this->db->join('users u', 'daftar_induk_dokumen.pembuat = u.id', 'left'); 
		$this->db->join('users us', 'daftar_induk_dokumen.pemeriksa = us.id', 'left'); 
		$this->db->join('users usr', 'daftar_induk_dokumen.pengesah = usr.id', 'left'); 
		$this->db->join('jenis_dokumen', 'daftar_induk_dokumen.jenis_dokumen = jenis_dokumen.id', 'left'); 
		$this->db->join('bidang', 'daftar_induk_dokumen.bidang = bidang.id', 'left'); 
		//$this->db->order_by("nomor","desc");
		return parent::find_all();

	}
	public function cekexist($nomor="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		 
		if($nomor!=""){
			$this->db->where('nomor',$nomor);
		}
		$this->db->where('status_active',"1");
		 
		return parent::count_all();

	} 
	public function distinct_jenis($jenis="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,jenis,count(*) as jumlah');
		}
		 
		if($jenis !=""){
			$this->db->where('jenis_dokumen',$jenis);
		} 
		$this->db->join('jenis_dokumen', 'daftar_induk_dokumen.jenis_dokumen = jenis_dokumen.id', 'left'); 
		$this->db->group_by('jenis'); 
		$this->db->where('status_active',"1");
		return parent::find_all();

	}
	public function distinct_bidang($bidang="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,bidang.bidang as namabidang,count(*) as jumlah');
		}
		 
		if($bidang !=""){
			$this->db->where('bidang.id',$bidang);
		} 
		$this->db->join('bidang', 'daftar_induk_dokumen.bidang = bidang.id', 'left'); 
		$this->db->where('status_active',"1");
		$this->db->group_by('bidang'); 
		return parent::find_all();

	}
	public function BygroupStatus()
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.status_active,count(*) as jumlah');
		}
		  
		$this->db->group_by('status_active'); 
		return parent::find_all();

	}

}
