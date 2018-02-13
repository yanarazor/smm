<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usulan_dokumen_internal_model extends BF_Model {

	protected $table_name	= "usulan_dokumen_internal";
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
			"field"		=> "usulan_dokumen_internal_judul",
			"label"		=> "Judul",
			"rules"		=> "required|max_length[100]"
		),
		array(
			"field"		=> "usulan_dokumen_internal_nomor",
			"label"		=> "Nomor",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "usulan_dokumen_internal_pengusul",
			"label"		=> "Pengusul",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_dokumen_internal_pemeriksa",
			"label"		=> "Pemeriksa",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_dokumen_internal_status_periksa",
			"label"		=> "Status Periksa",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_dokumen_internal_catatan_periksa",
			"label"		=> "Catatan Periksa",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_dokumen_internal_pengesah",
			"label"		=> "Pengesah",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_dokumen_internal_catatan_pengesah",
			"label"		=> "Catatan Pengesah",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_dokumen_internal_status_sah",
			"label"		=> "Status",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_dokumen_internal_jenis_dokumen",
			"label"		=> "Jenis Dokumen",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_dokumen_internal_tanggal_pengusulan",
			"label"		=> "Tanggal Pengusulan",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_all($keyword="",$jenis="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pembuat,jenis');
		}
		if($keyword!=""){
			$this->db->where('usulan_dokumen_internal.judul like "%'.$keyword.'%"');
		}
		 
		if($jenis!=""){
			$this->db->where('jenis_dokumen',$jenis);
		}
		$this->db->join('users u', 'usulan_dokumen_internal.pengusul = u.id', 'left'); 
		
		$this->db->join('jenis_dokumen', 'usulan_dokumen_internal.jenis_dokumen = jenis_dokumen.id', 'left'); 
		return parent::find_all();

	}
	public function GetJumlahStatusPeriksa()
	{
		if (empty($this->selects))
		{
			$this->select('count(*) as jumlah');
		}
		$this->db->where('status_periksa',"");
		return parent::count_all();

	}
	public function GetJumlahStatusSah()
	{
		if (empty($this->selects))
		{
			$this->select('count(*) as jumlah');
		}
		$this->db->where('status_sah is null or status_sah =""');
		return parent::count_all();
	}
	public function GettotalUsulan()
	{
		if (empty($this->selects))
		{
			$this->select('count(*) as jumlah');
		}
		//$this->db->where('status_sah is null or status_sah =""');
		return parent::count_all();
	}

}
