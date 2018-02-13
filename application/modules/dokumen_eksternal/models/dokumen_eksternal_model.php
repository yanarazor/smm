<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dokumen_eksternal_model extends BF_Model {

	protected $table_name	= "dokumen_eksternal";
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
			"field"		=> "dokumen_eksternal_judul",
			"label"		=> "Judul",
			"rules"		=> "required|max_length[255]"
		),
		array(
			"field"		=> "dokumen_eksternal_nomor",
			"label"		=> "Nomor",
			"rules"		=> "required|max_length[255]"
		),
		array(
			"field"		=> "dokumen_eksternal_tanggal_berlaku",
			"label"		=> "Tanggal Berlaku",
			"rules"		=> ""
		),
		array(
			"field"		=> "dokumen_eksternal_distribusi",
			"label"		=> "Distribusi",
			"rules"		=> ""
		),
		array(
			"field"		=> "dokumen_eksternal_pengusul",
			"label"		=> "Pengusul",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "dokumen_eksternal_pemeriksa",
			"label"		=> "Pemeriksa",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "dokumen_eksternal_pengesah",
			"label"		=> "Pengesah",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "dokumen_eksternal_created_by",
			"label"		=> "Created By",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "dokumen_eksternal_created_date",
			"label"		=> "Created Date",
			"rules"		=> ""
		),
		array(
			"field"		=> "dokumen_eksternal_updated_by",
			"label"		=> "Update By",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "dokumen_eksternal_updated_date",
			"label"		=> "Update Date",
			"rules"		=> ""
		),
		array(
			"field"		=> "dokumen_eksternal_filename",
			"label"		=> "File",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function find_all($keyword="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as nama_pengusul,us.display_name as user_pemeriksa,usr.display_name as user_pengesah');
		}
		if($keyword!=""){
			$this->db->where('judul like "%'.$keyword.'%" or nomor like "%'.$keyword.'%"');
		}
		$this->db->join('users u', 'dokumen_eksternal.pengusul = u.id', 'left'); 
		$this->db->join('users us', 'dokumen_eksternal.pemeriksa = us.id', 'left'); 
		$this->db->join('users usr', 'dokumen_eksternal.pengesah = usr.id', 'left'); 
		$this->db->order_by("judul","ASC");
		return parent::find_all();

	} 
	public function count_all()
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		 
		return parent::count_all();

	} 
	public function cekexist($judul="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		 
		if($judul!=""){
			$this->db->where('judul',$judul);
		} 
		return parent::count_all();

	} 

}
