<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lupa_timer_model extends BF_Model {

	protected $table_name	= "lupa_timer";
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
			"field"		=> "lupa_timer_user",
			"label"		=> "User",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "lupa_timer_tanggal_absen",
			"label"		=> "Tanggal Absen",
			"rules"		=> "required"
		),
		array(
			"field"		=> "lupa_timer_absen",
			"label"		=> "Absen",
			"rules"		=> "required|max_length[10]"
		),
		array(
			"field"		=> "lupa_timer_jam_sebenarnya",
			"label"		=> "Jam Sebernarnya",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "lupa_timer_atasan",
			"label"		=> "Atasan",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "lupa_timer_status_atasan",
			"label"		=> "Status Atasan",
			"rules"		=> "max_length[1]"
		),
		array(
			"field"		=> "lupa_timer_status_open",
			"label"		=> "Status Open",
			"rules"		=> "max_length[1]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_all($user="",$status="",$bulan = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul');
		}
		 
		if($user!=""){
			$this->db->where('((display_name like "%'.$user.'%"))');
			//$this->db->where('hari like "%'.$user.'%"');
		}
		if($bulan!=""){
			$this->db->where('tanggal_absen like "%-'.$bulan.'-%"');
		}
		if($status!=""){
			$this->db->where('status_atasan',$status);
		}
		$this->db->join('users u', 'lupa_timer.user = u.id', 'left'); 
		$this->db->order_by("status_atasan","asc");
		$this->db->order_by("id","DESC");
		return parent::find_all();

	} 
	public function find_detil($kode)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul,u.nip');
		}
		$this->db->join('users u', 'lupa_timer.user = u.id', 'left'); 
		return parent::find($kode);

	} 
	public function count_all($user="",$status="",$bulan = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul');
		}
		if($user!=""){
			$this->db->where('((display_name like "%'.$user.'%"))');
			//$this->db->where('hari like "%'.$user.'%"');
		}
		if($bulan!=""){
			$this->db->where('tanggal_absen like "%-'.$bulan.'-%"');
		}
		if($status!=""){
			$this->db->where('status_atasan',$status);
		}
		$this->db->join('users u', 'lupa_timer.user = u.id', 'left');  
		 
		return parent::count_all();

	} 
	public function find_rekap($bulan="",$tahun="",$nip="",$nama="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul,u.nip');
		}
		if($bulan!=""){
			$this->db->where('tanggal_absen like "%-'.$bulan.'-%"');
		} 
		if($tahun!=""){
			$this->db->where('tanggal_absen like "%'.$tahun.'-%"');
		} 
		if($nip!=""){
			$this->db->where('lupa_timer.user',$nip);
		}
		if($nama!=""){
			$this->db->where('display_name like "%'.$nama.'%"');
		}
		 
		$this->db->where('status_atasan',1);
		$this->db->join('users u', 'lupa_timer.user = u.id', 'left'); 
		 
		return parent::find_all();

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
			$this->select($this->table_name .'.user,u.nip,count(user) as jumlah');
		}
		if($bulan!=""){
			$this->db->where('tanggal_absen like "%-'.$bulan.'-%"');
		} 
		if($tahun!=""){
			$this->db->where('tanggal_absen like "%'.$tahun.'-%"');
		} 
		if($nip!=""){
			$this->db->where('user.nip',$nip);
		}
		if($nama!=""){
			$this->db->where('display_name like "%'.$nama.'%"');
		}
		 
		$this->db->where('status_atasan',1);
		 
		$this->db->join('users u', 'lupa_timer.user = u.id', 'inner'); 
		$this->db->group_by('user');
		return parent::find_all();

	} 
}
