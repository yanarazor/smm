<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skmpnen_model extends BF_Model {

	protected $table_name	= "sasd_skmpnen";
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
			"field"		=> "izin_keluar_tanggal",
			"label"		=> "Tanggal",
			"rules"		=> "required"
		),
		array(
			"field"		=> "izin_keluar_dari_jam",
			"label"		=> "Dari Jam",
			"rules"		=> "required"
		),
		array(
			"field"		=> "izin_keluar_sampai_jam",
			"label"		=> "Sampai Jam",
			"rules"		=> "required"
		),
		array(
			"field"		=> "izin_keluar_keterangan",
			"label"		=> "Keterangan",
			"rules"		=> ""
		),
		array(
			"field"		=> "izin_keluar_usr_id",
			"label"		=> "User",
			"rules"		=> "max_length[20]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	
	public function find_all()
	{
		if (empty($this->selects))
		{
			$this->select('kdgiat,kdoutput');
		}
		$this->db->where('kdgiat != "" and kdoutput != ""');
		$this->db->distinct();
		return parent::find_all();

	} 
	public function getkomponen($tahun = "",$kdgiat= "",$kdoutput= "",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(kdgiat) as kdgiat,TRIM(kdoutput) as kdoutput,TRIM(kdsoutput) as kdsoutput,TRIM(kdkmpnen) as kdkmpnen,urkmpnen');
		}
		if($kdgiat != ""){
			$this->db->where('trim(kdgiat)',$kdgiat);
		}
		if($kdoutput != ""){
			$this->db->where('trim(kdoutput)',$kdoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(kdsoutput)',$kdsoutput);
		}
		if($tahun != ""){
			$this->db->where('trim(thang)',$tahun);
		}
		//$this->db->order_by("kdoutput","asc");
		//$this->db->order_by("kdsoutput","asc");
		$this->db->order_by("kdkmpnen","asc");
		
		return parent::find_all();

	}
	 
}
