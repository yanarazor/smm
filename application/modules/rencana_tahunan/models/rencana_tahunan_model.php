<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rencana_tahunan_model extends BF_Model {

	protected $table_name	= "rencana_tahunan";
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
			"field"		=> "rencana_tahunan_tahun",
			"label"		=> "Tahun",
			"rules"		=> "required|max_length[4]"
		),
		array(
			"field"		=> "rencana_tahunan_dari_tanggal",
			"label"		=> "Dari Tanggal",
			"rules"		=> "required"
		),
		array(
			"field"		=> "rencana_tahunan_sampai_tanggal",
			"label"		=> "Sampai Tanggal",
			"rules"		=> "required"
		),
		array(
			"field"		=> "rencana_tahunan_id_bidang",
			"label"		=> "Bidang",
			"rules"		=> "required|max_length[4]"
		),
		array(
			"field"		=> "rencana_tahunan_status_wm",
			"label"		=> "Status WM",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function GetbyYear($year="")
	{
		if(empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		 
		if($year!=""){
			$this->db->where('tahun',$year);
		}
		  
		return parent::find_all();
	}
}
