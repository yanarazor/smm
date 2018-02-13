<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Surat_izin_model extends BF_Model {

	protected $table_name	= "surat_izin";
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
			"field"		=> "surat_izin_user",
			"label"		=> "User",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "surat_izin_nip",
			"label"		=> "Nip",
			"rules"		=> "max_length[20]"
		),
		array(
			"field"		=> "surat_izin_izin",
			"label"		=> "izin",
			"rules"		=> "max_length[2]"
		),
		array(
			"field"		=> "surat_izin_lama",
			"label"		=> "Selama",
			"rules"		=> "required|max_length[20]"
		),
		array(
			"field"		=> "surat_izin_satuan",
			"label"		=> "Satuan",
			"rules"		=> "required|max_length[50]"
		),
		array(
			"field"		=> "surat_izin_hari",
			"label"		=> "Hari",
			"rules"		=> "max_length[30]"
		),
		array(
			"field"		=> "surat_izin_tanggal",
			"label"		=> "Tanggal",
			"rules"		=> "required"
		),
		array(
			"field"		=> "surat_izin_alasan",
			"label"		=> "Alasan",
			"rules"		=> "required"
		),
		array(
			"field"		=> "surat_izin_status_atasan",
			"label"		=> "Status Atasan",
			"rules"		=> ""
		),
		array(
			"field"		=> "surat_izin_tanggal_dibuat",
			"label"		=> "Tanggal Dibuat",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function find_all($user="",$izin="",$status="",$bulan="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul,nama_izin');
		}
		if($izin!=""){
			$this->db->where('izin',$izin);
		}
		if($user!=""){
			$this->db->where('((display_name like "%'.$user.'%") or (hari like "%'.$user.'%"))');
			//$this->db->where('hari like "%'.$user.'%"');
		}
		if($bulan!=""){
			$this->db->where('tanggal like "%-'.$bulan.'-%"');
		}
		if($status!=""){
			$this->db->where('status_atasan',$status);
		}
		$this->db->join('users u', 'surat_izin.user = u.id', 'left'); 
		$this->db->join('master_izin m', 'surat_izin.izin = m.id', 'left'); 
		$this->db->order_by("status_atasan","asc");
		$this->db->order_by("tanggal","DESC");
		return parent::find_all();

	} 
	public function find_rekap($bulan="",$tahun="",$nip="",$nama="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul,m.id as izin,nama_izin,u.nip,kode');
		}
		if($bulan!=""){
			$this->db->where('tanggal like "%-'.$bulan.'-%"');
		} 
		if($tahun!=""){
			$this->db->where('tanggal like "%'.$tahun.'-%"');
		} 
		if($nip!=""){
			$this->db->where('surat_izin.nip',$nip);
		}
		if($nama!=""){
			$this->db->where('display_name like "%'.$nama.'%"');
		}
		 
		$this->db->where('status_atasan',1);
		 
		$this->db->join('users u', 'surat_izin.user = u.id', 'inner'); 
		$this->db->join('master_izin m', 'surat_izin.izin = m.id', 'inner'); 
		return parent::find_all();

	} 
	public function count_all($user="",$izin="",$status="",$bulan = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul,nama_izin');
		}
		if($izin!=""){
			$this->db->where('izin',$izin);
		}
		if($user!=""){
			$this->db->where('((display_name like "%'.$user.'%") or (hari like "%'.$user.'%"))');
			//$this->db->where('hari like "%'.$user.'%"');
		}
		if($bulan!=""){
			$this->db->where('tanggal like "%-'.$bulan.'-%"');
		}
		if($status!=""){
			$this->db->where('status_atasan',$status);
		}
		$this->db->join('users u', 'surat_izin.user = u.id', 'left'); 
		$this->db->join('master_izin m', 'surat_izin.izin = m.id', 'left'); 
		return parent::count_all();

	}
	public function count_all_notif($bulan="",$tahun="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul,nama_izin');
		}
		if($tahun!=""){
			$this->db->where('izin',$izin);
		}
		 
		if($bulan!=""){
			$this->db->where('status_atasan',$status);
		}
		$this->db->where('status_open',"0");
		return parent::count_all();

	} 
	public function count_bystatusopen($statusopen="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		if($statusopen!=""){
			$this->db->where('status_open',$statusopen);
		}
		return parent::count_all();

	} 
	public function count_bystatusatasan()
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		 
		return parent::count_all();

	} 
	public function count_rekap($bulan="",$tahun="",$nip="",$nama="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.user,m.id as izin,nama_izin,u.nip,kode,count(izin) as jumlah');
		}
		if($bulan!=""){
			$this->db->where('tanggal like "%-'.$bulan.'-%"');
		} 
		if($tahun!=""){
			$this->db->where('tanggal like "%'.$tahun.'-%"');
		} 
		if($nip!=""){
			$this->db->where('surat_izin.nip',$nip);
		}
		if($nama!=""){
			$this->db->where('display_name like "%'.$nama.'%"');
		}
		 
		$this->db->where('status_atasan',1);
		 
		$this->db->join('users u', 'surat_izin.user = u.id', 'inner'); 
		$this->db->join('master_izin m', 'surat_izin.izin = m.id', 'inner'); 
		$this->db->group_by('izin');
		$this->db->group_by('user');
		return parent::find_all();

	} 
	public function sum_rekap($bulan="",$tahun="",$nip="",$nama="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.user,izin,sum(lama) as jumlah,u.display_name,m.id as izin,nama_izin,u.nip');
		}
		if($bulan!=""){
			$this->db->where('tanggal like "%-'.$bulan.'-%"');
		} 
		if($tahun!=""){
			$this->db->where('tanggal like "%'.$tahun.'-%"');
		} 
		if($nip!=""){
			$this->db->where('u.nip',$nip);
		}
		if($nama!=""){
			$this->db->where('display_name like "%'.$nama.'%"');
		}
		 
		$this->db->where('status_atasan',1);
		$this->db->join('users u', 'surat_izin.user = u.id', 'inner'); 
		$this->db->join('master_izin m', 'surat_izin.izin = m.id', 'inner'); 
		
		$this->db->group_by('surat_izin.user'); 
		$this->db->group_by('surat_izin.izin'); 
		return parent::find_all();

	} 
	public function getjmlizincuti($tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select('user,sum(lama) as jumlah');
		}
		if($tahun!=""){
			$this->db->where('tanggal like "%'.$tahun.'-%"');
		} 
		$this->db->where('(izin = 21 or izin = 13)');
		$this->db->where('status_atasan',1);
		$this->db->group_by('user');
		return parent::find_all();

	} 
}
