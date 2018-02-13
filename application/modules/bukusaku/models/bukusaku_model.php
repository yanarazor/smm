<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bukusaku_model extends BF_Model {

	protected $table_name	= "bukusaku";
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
			"field"		=> "bukusaku_nip_pegawai",
			"label"		=> "Pegawai",
			"rules"		=> "max_length[30]"
		),
		array(
			"field"		=> "bukusaku_tanggal",
			"label"		=> "Tanggal",
			"rules"		=> "required"
		),
		array(
			"field"		=> "bukusaku_jam",
			"label"		=> "Dari Jam",
			"rules"		=> "required"
		),
		array(
			"field"		=> "sampai_jam",
			"label"		=> "Sampai Jam",
			"rules"		=> "required"
		),
		array(
			"field"		=> "bukusaku_pk",
			"label"		=> "Pk",
			"rules"		=> "max_length[50]"
		),
		
		array(
			"field"		=> "bukusaku_kegiatan",
			"label"		=> "Kegiatan",
			"rules"		=> "required"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_event($nip="",$tahun="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.id,tanggal as start,kegiatan as title');
		}
		if($nip!=""){
			$this->db->where('nip_pegawai',$nip);
		}
		 
		if($tahun!=""){
			$this->db->where('tanggal like "%'.$tahun.'-%"');
		} 
		$this->db->order_by("tanggal","DESC");
		return parent::find_all();

	}
	public function find_detil($id="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,skp.kegiatan as kegiatan_skp');
		}
		$this->db->join('skp', 'skp.id = bukusaku.pk', 'left'); 
		return parent::find($id);

	}
}
