<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usulan_dokumen_eksternal_model extends BF_Model {

	protected $table_name	= "usulan_dokumen_eksternal";
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
			"field"		=> "usulan_dokumen_eksternal_judul",
			"label"		=> "Judul",
			"rules"		=> "required|max_length[255]"
		),
		array(
			"field"		=> "usulan_dokumen_eksternal_nomor",
			"label"		=> "Nomor",
			"rules"		=> "max_length[100]"
		),
		array(
			"field"		=> "usulan_dokumen_eksternal_pengusul",
			"label"		=> "Pengusul",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_dokumen_eksternal_pemeriksa",
			"label"		=> "Pemeriksa",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_dokumen_eksternal_catatan",
			"label"		=> "Catatan",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_dokumen_eksternal_status",
			"label"		=> "Status",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_dokumen_eksternal_tanggal_pengusulan",
			"label"		=> "Tanggal Pengusulan",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_dokumen_eksternal_tanggal_pengesahan",
			"label"		=> "Tanggal Pengesahan",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_dokumen_eksternal_filename",
			"label"		=> "File",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_all($keyword="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pengusul');
		}
		if($keyword!=""){
			$this->db->where('judul like "%'.$keyword.'%"');
		}
		$this->db->join('users u', 'usulan_dokumen_eksternal.pengusul = u.id', 'left'); 
		return parent::find_all();

	} 
	public function GetJumlahStatusSah()
	{
		if (empty($this->selects))
		{
			$this->select('count(*) as jumlah');
		}
		$this->db->where('status is null or status =""');
		return parent::count_all();
	}
	public function Count_all()
	{
		if (empty($this->selects))
		{
			$this->select('count(*) as jumlah');
		}
		//$this->db->where('status is null or status =""');
		return parent::count_all();
	}
	

}
