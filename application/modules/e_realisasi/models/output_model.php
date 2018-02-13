<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Output_model extends BF_Model {

	protected $table_name	= "sasd_output";
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
	//$tahun,$kdoutput,$kdsoutput,$key,$kdgiat
	public function tayangkegiatan($tahun = "",$kdoutput= "",$kdsoutput = "",$key = "",$kdgiat= "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(o.thang) as thang,TRIM(o.kdgiat) as kdgiat,TRIM(o.kdoutput) as kdoutput,TRIM(o.kdsoutput) as kdsoutput,TRIM(o.ursoutput) as ursoutput,TRIM(nmoutput) as nmoutput');
		}
		if($kdsoutput != ""){
			$this->db->where('trim(o.kdsoutput)',$kdsoutput);
		}
		if($kdoutput != ""){
			$this->db->where('trim(o.kdoutput)',$kdoutput);
		}
		if($kdgiat != ""){
			$this->db->where('trim(o.kdgiat)',$kdgiat);
		}
		if($key != ""){
			$this->db->where('ursoutput like "%'.$key.'%"');
		}
		if($tahun != ""){
			$this->db->where("trim(o.thang) like '".$tahun."'");
		}
		$this->db->join('sasd_soutput o', 'o.kdgiat = sasd_output.kdgiat and o.kdoutput = trim(bf_sasd_output.kdoutput)', 'left'); 
		$this->db->join('sast_output t', 't.kdgiat = o.kdgiat and t.kdoutput = o.kdoutput ', 'left'); 
		$this->db->order_by("o.kdoutput","asc");
		$this->db->order_by("o.kdsoutput","asc");
		$this->db->distinct();
		return parent::find_all();

	}
	 
}
