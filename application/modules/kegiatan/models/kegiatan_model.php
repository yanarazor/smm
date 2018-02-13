<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kegiatan_model extends BF_Model {

	protected $table_name	= "kegiatan";
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
			"field"		=> "kegiatan_tahun",
			"label"		=> "Tahun",
			"rules"		=> "required|max_length[4]"
		),
		array(
			"field"		=> "kegiatan_dipa",
			"label"		=> "Dipa",
			"rules"		=> "required|max_length[10]"
		),
		array(
			"field"		=> "kegiatan_kode",
			"label"		=> "Kode",
			"rules"		=> "max_length[100]"
		),
		array(
			"field"		=> "kegiatan_judul",
			"label"		=> "Judul",
			"rules"		=> "max_length[255]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_all($judul = "",$pj= "",$tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as penanggung_jawab');
		}
		 
		if($judul!=""){
			$this->db->where('((judul like "%'.$judul.'%"))');
			//$this->db->where('hari like "%'.$user.'%"');
		}
		 
		if($pj !=""){
			$this->db->where('pj',$pj);
		}
		if($tahun !=""){
			$this->db->where('tahun',$tahun);
		}
		$this->db->join('users u', 'kegiatan.pj = u.id', 'left'); 
		//$this->db->order_by("izin_keluar.id","DESC");
		return parent::find_all();

	} 
	public function find_bykode($kode = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		if($kode !=""){
			$this->db->where('kode',$kode);
		}
		$this->db->where('tahun',date("Y"));
		return parent::find_all();
	} 
	public function getbydipa($dipa = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		if($dipa !=""){
			$this->db->where('dipa',$dipa);
		}
		$this->db->where('tahun',date("Y"));
		return parent::find_all();
	} 
	 
}
