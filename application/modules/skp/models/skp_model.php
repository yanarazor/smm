<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skp_model extends BF_Model {

	protected $table_name	= "skp";
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
			"field"		=> "skp_tahun",
			"label"		=> "Tahun",
			"rules"		=> "max_length[4]"
		),
		array(
			"field"		=> "skp_nip",
			"label"		=> "Pegawai",
			"rules"		=> "max_length[30]"
		),
		array(
			"field"		=> "skp_kegiatan",
			"label"		=> "Kegiatan",
			"rules"		=> ""
		),
		array(
			"field"		=> "skp_target",
			"label"		=> "Target",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "skp_waktu",
			"label"		=> "Waktu",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "skp_capaian",
			"label"		=> "Capaian",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "skp_pemantauan",
			"label"		=> "Pemantauan",
			"rules"		=> "max_length[100]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_all($nip="",$tahun="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		if($nip!=""){
			$this->db->where('nip',$nip);
		}
		 
		if($tahun!=""){
			$this->db->where('tahun',$tahun);
		} 
		return parent::find_all();

	}
	public function find_distinct($nip = "",$tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.nip,tahun,nama');
		}
		if($nip != ""){
			$this->db->where('skp.nip',$nip);
		}
		if($tahun!=""){
			$this->db->where('tahun',$tahun);
		} 
		$this->db->group_by("tahun");
		$this->db->group_by("nip");
		$this->db->join('pegawai', 'skp.nip = pegawai.nip', 'left'); 
		$this->db->join('users u', 'pegawai.nip = u.nip', 'left'); 
		return parent::find_all();
	}
	public function find_withskp($nip="",$tahun="")
	{
		//$this->db->from('pegawai');
		$this->db->select($this->table_name .'.*,(sum(hour(TIMEDIFF(bf_bukusaku.jam,bf_bukusaku.sampai_jam)))) as jumlah_jam',false);
		 
		if($nip!=""){
			$this->db->where('bf_pegawai.nip',$nip);
		}
		 
		if($tahun!=""){
			$this->db->where('tahun',$tahun);
		} 
		
		$this->db->join('pegawai', 'skp.nip = pegawai.nip', 'left'); 
		$this->db->join('bukusaku', 'bukusaku.pk = skp.id', 'left'); 
		$this->db->group_by("skp.id");
		return parent::find_all();

	}
}
