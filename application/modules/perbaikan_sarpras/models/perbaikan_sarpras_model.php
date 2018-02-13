<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Perbaikan_sarpras_model extends BF_Model {

	protected $table_name	= "perbaikan_sarpras";
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
			"field"		=> "perbaikan_sarpras_nomor",
			"label"		=> "Nomor",
			"rules"		=> "required|unique[bf_perbaikan_sarpras.nomor,bf_perbaikan_sarpras.id]|max_length[10]"
		),
		array(
			"field"		=> "perbaikan_sarpras_jenis",
			"label"		=> "Jenis Pemeliharaan",
			"rules"		=> "required|max_length[1]"
		),
		array(
			"field"		=> "perbaikan_sarpras_nama_sarpras",
			"label"		=> "Nama Sarpras",
			"rules"		=> "max_length[100]"
		),
		array(
			"field"		=> "perbaikan_sarpras_nomor_inventaris",
			"label"		=> "Nomor Inventaris",
			"rules"		=> "max_length[20]"
		),
		array(
			"field"		=> "perbaikan_sarpras_keluhan",
			"label"		=> "Keluhan",
			"rules"		=> ""
		),
		array(
			"field"		=> "perbaikan_sarpras_user",
			"label"		=> "User",
			"rules"		=> "max_length[3]"
		),
		array(
			"field"		=> "perbaikan_sarpras_tanggal_kirim",
			"label"		=> "Tanggal Kirim",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	protected $CI;
	protected $role_id="";
	//--------------------------------------------------------------------
	function __construct()
    {
		$this->CI = &get_instance();
		 
    }//end __construct
	public function find_all($key = "",$status = "",$user = "",$jenis = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,jenis_pemeliharaan.jenis as jenis_perbaikan,status_perbaikan');
		}
		 
		if($jenis != ""){
			$this->db->where('jenis',$jenis);
		} 
		if($user != ""){
			$this->db->where('user',$user);
		} 
		if($status != ""){
			$this->db->where('status',$status);
		} 
		if($key != ""){
			$this->db->where('nomor',$key);
		} 
		$this->db->join('users', 'perbaikan_sarpras.user = users.id', 'left'); 
		$this->db->join('jenis_pemeliharaan', 'jenis_pemeliharaan.id = perbaikan_sarpras.jenis', 'left'); 
		$this->db->join('status_pemeliharaan', 'status_pemeliharaan.id = perbaikan_sarpras.status', 'left'); 
		$this->db->order_by('nomor',"Desc");
		$this->db->order_by('tanggal_kirim',"Desc");
		return parent::find_all();

	}
	public function find_detil($id = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,jenis_pemeliharaan.jenis as jenis_perbaikan,status_perbaikan');
		}
		 
		 
		$this->db->join('users', 'perbaikan_sarpras.user = users.id', 'left'); 
		$this->db->join('jenis_pemeliharaan', 'jenis_pemeliharaan.id = perbaikan_sarpras.jenis', 'left'); 
		$this->db->join('status_pemeliharaan', 'status_pemeliharaan.id = perbaikan_sarpras.status', 'left'); 
		$this->db->order_by('nomor',"Desc");
		$this->db->order_by('tanggal_kirim',"Desc");
		return parent::find($id);

	}
	public function count_all($key = "",$status = "",$user = "",$jenis = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,jenis_pemeliharaan.jenis as jenis_perbaikan');
		}
		 
		if($jenis != ""){
			$this->db->where('jenis',$jenis);
		} 
		if($user != ""){
			$this->db->where('user',$user);
		} 
		if($status != ""){
			$this->db->where('status',$status);
		} 
		if($key != ""){
			$this->db->where('nomor',$key);
		} 
		$this->db->join('users', 'perbaikan_sarpras.user = users.id', 'left'); 
		$this->db->join('jenis_pemeliharaan', 'jenis_pemeliharaan.id = perbaikan_sarpras.jenis', 'left'); 
		$this->db->order_by('nomor',"Desc");
		$this->db->order_by('tanggal_kirim',"Desc");
		return parent::count_all();

	}
	public function find_allppk($key = "",$status = "",$user = "",$jenis = "")
	{	 
		
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,jenis_pemeliharaan.jenis as jenis_perbaikan,status_perbaikan');
		}
		 
		if($jenis != ""){
			$this->db->where('jenis',$jenis);
		} 
		if($user != ""){
			$this->db->where('user',$user);
		} 
		if($status != ""){
			$this->db->where('status',$status);
		} 
		if($key != ""){
			$this->db->where('nomor',$key);
		} 
		if($this->CI->auth->role_id() != "1" and $this->CI->auth->role_id() != "16"){
			$this->db->where('verifikasi2',$this->CI->auth->user_id());
		}
		$this->db->where('status_kpu','1');
		$this->db->join('users', 'perbaikan_sarpras.user = users.id', 'left'); 
		$this->db->join('jenis_pemeliharaan', 'jenis_pemeliharaan.id = perbaikan_sarpras.jenis', 'left'); 
		$this->db->join('status_pemeliharaan', 'status_pemeliharaan.id = perbaikan_sarpras.status', 'left'); 
		$this->db->order_by('nomor',"Desc");
		$this->db->order_by('tanggal_kirim',"Desc");
		return parent::find_all();

	}
	public function count_allppk($key = "",$status = "",$user = "",$jenis = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,jenis_pemeliharaan.jenis as jenis_perbaikan,status_perbaikan');
		}
		 
		if($jenis != ""){
			$this->db->where('jenis',$jenis);
		} 
		if($user != ""){
			$this->db->where('user',$user);
		} 
		if($status != ""){
			$this->db->where('status',$status);
		} 
		if($key != ""){
			$this->db->where('nomor',$key);
		} 
		if($this->CI->auth->role_id() != "1" and $this->CI->auth->role_id() != "16"){
			$this->db->where('verifikasi2',$this->CI->auth->user_id());
		}
		$this->db->where('status_kpu','1');
		$this->db->join('users', 'perbaikan_sarpras.user = users.id', 'left'); 
		$this->db->join('jenis_pemeliharaan', 'jenis_pemeliharaan.id = perbaikan_sarpras.jenis', 'left'); 
		$this->db->join('status_pemeliharaan', 'status_pemeliharaan.id = perbaikan_sarpras.status', 'left'); 
		$this->db->order_by('nomor',"Desc");
		$this->db->order_by('tanggal_kirim',"Desc");
		return parent::count_all();

	}
}
