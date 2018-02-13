<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_permintaan_model extends BF_Model {

	protected $table_name	= "log_permintaan";
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
			"field"		=> "log_permintaan_kode_permintaan",
			"label"		=> "Kode Permintaan",
			"rules"		=> "required|max_length[10]"
		),
		array(
			"field"		=> "log_permintaan_kode_detil_permintaan",
			"label"		=> "Kode Barang detil",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "log_permintaan_user_id",
			"label"		=> "User ID",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "log_permintaan_tanggal_jam",
			"label"		=> "Tanggal Jam",
			"rules"		=> "required"
		),
		array(
			"field"		=> "log_permintaan_aksi",
			"label"		=> "Aksi",
			"rules"		=> "max_length[100]"
		),
		array(
			"field"		=> "log_permintaan_keterangan",
			"label"		=> "Keterangan",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_all($id_permintaan ="",$id_detil = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nomor,nomor_detil,nama_barang,spek_barang');
		}
		 
		if($id_permintaan != ""){
			$this->db->where('kode_permintaan',$id_permintaan);
		} 
		if($id_detil != ""){
			$this->db->where('kode_detil_permintaan',$id_detil);
		} 
		$this->db->join('users', 'log_permintaan.user_id = users.id', 'left'); 
		$this->db->join('permintaan_barang_detil', 'permintaan_barang_detil.id = log_permintaan.kode_detil_permintaan', 'left'); 
		$this->db->join('permintaan_barang', 'permintaan_barang.id = permintaan_barang_detil.id_permintaan', 'left'); 
		$this->db->order_by("id","asc");
		return parent::find_all();

	}
}
