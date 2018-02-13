<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_induk_rekaman_model extends BF_Model {

	protected $table_name	= "daftar_induk_rekaman";
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
			"field"		=> "daftar_induk_rekaman_nama",
			"label"		=> "Nama",
			"rules"		=> "required|max_length[255]"
		),
		array(
			"field"		=> "daftar_induk_rekaman_nomor",
			"label"		=> "Nomor",
			"rules"		=> "required|unique[bf_daftar_induk_rekaman.nomor,bf_daftar_induk_rekaman.id]|max_length[100]"
		),
		array(
			"field"		=> "daftar_induk_rekaman_lama_simpan",
			"label"		=> "Lama Simpan",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "daftar_induk_rekaman_tempat_simpan",
			"label"		=> "Tempat Simpan",
			"rules"		=> "max_length[200]"
		),
		array(
			"field"		=> "daftar_induk_rekaman_penanggung_jawab",
			"label"		=> "Penanggung Jawab",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "daftar_induk_rekaman_created_by",
			"label"		=> "Created_by",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_induk_rekaman_created_date",
			"label"		=> "Created_date",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_induk_rekaman_updated_by",
			"label"		=> "Update By",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_induk_rekaman_updated_date",
			"label"		=> "Update Date",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= TRUE;

	//--------------------------------------------------------------------
	public function find_all($pj="",$key="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,b.bidang as pj');
		}
		if($pj!=""){
			$this->db->where('penanggung_jawab',$pj);
		}
		if($key!=""){
			$this->db->where('penanggung_jawab',$pj);
		}
		$this->db->join('bidang b', 'daftar_induk_rekaman.penanggung_jawab = b.id', 'left'); 
		 
		return parent::find_all();

	} 

}
