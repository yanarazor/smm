<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permintaan_barang_model extends BF_Model {

	protected $table_name	= "permintaan_barang";
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
	public function find($id = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status');
		}
		 
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->order_by('tanggal_permintaan',"Desc");
		$this->db->order_by('nomor',"Desc");
		return parent::find($id);

	}
	public function find_all($key="",$bulan = "",$tahun = "",$kg = "",$status = "",$pg = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status');
		}
		if($key!=""){
			$this->db->where('nomor like "%'.$key.'%"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		} 
		if($status != ""){
			$this->db->where('status_permintaan',$status);
		} 
		if($pg != ""){
			$this->db->where('user_request',$pg);
		} 
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->order_by('tanggal_permintaan',"Desc");
		$this->db->order_by('nomor',"Desc");
		return parent::find_all();

	}
	public function count_all($key="",$bulan = "",$tahun = "",$kg = "",$status = "",$pg = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status');
		}
		if($key!=""){
			$this->db->where('nomor like "%'.$key.'%"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		} 
		if($status != ""){
			$this->db->where('status_permintaan',$status);
		} 
		if($pg != ""){
			$this->db->where('user_request',$pg);
		} 
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->order_by('nomor',"Desc");
		$this->db->order_by('tanggal_permintaan',"Desc");
		return parent::count_all();

	}
	public function count_pj_all($key="",$bulan = "",$tahun = "",$kg = "",$status = "",$pj = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status,pj');
		}
		if($key!=""){
			$this->db->where('nomor like "%'.$key.'%"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		}else{
			$this->db->where('tanggal_permintaan like "'.date("Y").'-%"');
		}
		if($status != ""){
			$this->db->where('status_permintaan',$status);
		} 
		 
		if($pj != ""){
			$this->db->where('pj',$pj);
		} 
		//$this->db->where('status_ppk',"1");
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->join('kegiatan', 'permintaan_barang.kegiatan = kegiatan.kode', 'left');  
		$this->db->order_by('tanggal_permintaan',"Desc");
		//$this->db->order_by('nomor',"Desc");
		return parent::count_all();
	}
	public function find_pj_all($key="",$bulan = "",$tahun = "",$kg = "",$status = "",$pj = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status,pj');
		}
		if($key!=""){
			$this->db->where('nomor like "%'.$key.'%"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		}else{
			$this->db->where('tanggal_permintaan like "'.date("Y").'-%"');
		}
		if($status != ""){
			$this->db->where('status_permintaan',$status);
		} 
		 
		if($pj != ""){
			$this->db->where('pj',$pj);
		} 
		//$this->db->where('status_ppk',"1");
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->join('kegiatan', 'permintaan_barang.kegiatan = kegiatan.kode', 'left');  
		$this->db->order_by('tanggal_permintaan',"Desc");
		$this->db->order_by('nomor',"Desc");
		return parent::find_all();
	}
	public function find_ppk_all($key="",$bulan = "",$tahun = "",$kg = "",$status = "",$pg = "",$ppk = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status,ppk');
		}
		if($key!=""){
			$this->db->where('nomor like "%'.$key.'%"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		}else{
			$this->db->where('tanggal_permintaan like "'.date("Y").'-%"');
		}
		if($status != ""){
			$this->db->where('status_permintaan',$status);
		} 
		if($pg != ""){
			$this->db->where('user_request',$pg);
		} 
		if($ppk != ""){
			$this->db->where('ppk',$ppk);
		} 
		$this->db->where('status_ppk',"1");
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->join('permintaan_barang_detil', 'permintaan_barang.id = permintaan_barang_detil.id_permintaan', 'inner'); 
		$this->db->join('kegiatan', 'permintaan_barang.kegiatan = kegiatan.kode', 'left');  
		$this->db->order_by('tanggal_permintaan',"Desc");
		$this->db->order_by('nomor',"Desc");
		$this->db->distinct();
		return parent::find_all();
	}
	public function count_ppk_all($key="",$bulan = "",$tahun = "",$kg = "",$status = "",$pg = "",$ppk = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status');
		}
		if($key!=""){
			$this->db->where('nomor like "%'.$key.'%"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		}else{
			$this->db->where('tanggal_permintaan like "'.date("Y").'-%"');
		}
		if($status != ""){
			$this->db->where('status_permintaan',$status);
		} 
		if($pg != ""){
			$this->db->where('user_request',$pg);
		} 
		if($ppk != ""){
			$this->db->where('ppk',$ppk);
		} 
		$this->db->where('status_ppk',"1");
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->join('permintaan_barang_detil', 'permintaan_barang.id = permintaan_barang_detil.id_permintaan', 'inner'); 
		$this->db->join('kegiatan', 'permintaan_barang.kegiatan = kegiatan.kode', 'left');  
		$this->db->order_by('nomor',"Desc");
		$this->db->order_by('tanggal_permintaan',"Desc");
		$this->db->distinct();
		return parent::count_all();

	}
	public function find_persediaan($key="",$bulan = "",$tahun = "",$kg = "",$status_atasan = "",$pg = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status');
		}
		if($key!=""){
			$this->db->where('nomor like "%'.$key.'%"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		}else{
			$this->db->where('tanggal_permintaan like "'.date("Y").'-%"');
		} 
		if($status_atasan != ""){
			$this->db->where('status_atasan',$status_atasan);
		} 
		if($pg != ""){
			$this->db->where('user_request',$pg);
		} 
		$this->db->where('mark like "52%"');
		$this->db->join('permintaan_barang_detil', 'permintaan_barang.id = permintaan_barang_detil.id_permintaan', 'inner'); 
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->order_by('tanggal_permintaan',"Desc");
		$this->db->order_by('nomor',"Desc");
		$this->db->distinct();
		return parent::find_all();

	}
	public function find_bmn($key="",$bulan = "",$tahun = "",$kg = "",$status_atasan = "",$pg = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama_status');
		}
		if($key!=""){
			$this->db->where('nomor like "%'.$key.'%"');
		} 
		if($bulan!=""){
			$this->db->where('tanggal_permintaan like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_permintaan like "'.$tahun.'-%"');
		}else{
			$this->db->where('tanggal_permintaan like "'.date("Y").'-%"');
		} 
		if($status_atasan != ""){
			$this->db->where('status_atasan',$status_atasan);
		} 
		if($pg != ""){
			$this->db->where('user_request',$pg);
		} 
		$this->db->where('mark like "53%"');
		$this->db->join('permintaan_barang_detil', 'permintaan_barang.id = permintaan_barang_detil.id_permintaan', 'inner'); 
		$this->db->join('users', 'permintaan_barang.user_request = users.id', 'left'); 
		$this->db->join('status_permintaan', 'status_permintaan.id = permintaan_barang.status_permintaan', 'left'); 
		$this->db->order_by('tanggal_permintaan',"Desc");
		$this->db->order_by('nomor',"Desc");
		$this->db->distinct();
		return parent::find_all();

	}

}
