<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_periksa_audit_model extends BF_Model {

	protected $table_name	= "daftar_periksa_audit";
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
			"field"		=> "daftar_periksa_audit_id_jadwal_audit",
			"label"		=> "Jadwal Audit",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_periksa_audit_deskripsi",
			"label"		=> "Deskripsi",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_periksa_audit_klausul_iso",
			"label"		=> "Klausul Iso",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_periksa_audit_bukti_obyektif",
			"label"		=> "Bukti Obyektif",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_periksa_audit_kesesuaian",
			"label"		=> "Kesesuaian",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_periksa_audit_id_bidang",
			"label"		=> "Bidang",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_periksa_audit_tanggal",
			"label"		=> "Tanggal",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_periksa_audit_auditor",
			"label"		=> "Auditor",
			"rules"		=> "max_length[10]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_all($audit_internal="",$bidang="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,bidang,judul,display_name as user_pembuat');
		}
		if($audit_internal!=""){
			$this->db->where('id_jadwal_audit',$audit_internal);
		}
		if($bidang!=""){
			$this->db->where('bidang.id',$bidang);
		}
		$this->db->order_by('id_bidang',"asc");
		$this->db->join('bidang', 'daftar_periksa_audit.id_bidang= bidang.id', 'left'); 
		$this->db->join('audit_internal', 'daftar_periksa_audit.id_jadwal_audit  = audit_internal.id', 'left'); 
		$this->db->join('users u', 'daftar_periksa_audit.auditor = u.id', 'left'); 
		return parent::find_all();

	} 
	public function count_all($audit_internal="",$bidang="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,bidang,judul,display_name as user_pembuat');
		}
		if($audit_internal!=""){
			$this->db->where('id_jadwal_audit',$audit_internal);
		}
		if($bidang!=""){
			$this->db->where('bidang.id',$bidang);
		}
		$this->db->order_by('bidang.id',"asc");
		$this->db->join('bidang', 'daftar_periksa_audit.id_bidang= bidang.id', 'left'); 
		$this->db->join('audit_internal', 'daftar_periksa_audit.id_jadwal_audit  = audit_internal.id', 'left'); 
		$this->db->join('users u', 'daftar_periksa_audit.auditor = u.id', 'left'); 
		return parent::count_all();

	} 

}
