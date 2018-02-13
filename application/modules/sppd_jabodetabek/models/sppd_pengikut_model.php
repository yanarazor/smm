<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sppd_pengikut_model extends BF_Model {

	protected $table_name	= "sppd_pengikut";
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
			"field"		=> "data_pengujian_order_id",
			"label"		=> "Order ID",
			"rules"		=> "unique[sm_data_pengujian.order_id,sm_data_pengujian.id]|max_length[20]"
		),
		array(
			"field"		=> "data_pengujian_tahun",
			"label"		=> "Tahun",
			"rules"		=> "required|max_length[4]"
		),
		array(
			"field"		=> "data_pengujian_customer_id",
			"label"		=> "Customer",
			"rules"		=> "max_length[3]"
		),
		 
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= TRUE;
	
	public function find_byidsppd($idsppd)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,display_name');
		}
		$this->db->where('kode_sppd',$idsppd);
		$this->db->join('users', 'sppd_pengikut.id_user = users.id', 'left'); 
		return parent::find_all();

	} 
	 public function find_rekap($bulan="",$tahun="",$nip="",$nama="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name,u.nip,tanggal_berangkat,sampai_tanggal');
		}
		 
			 
		if($nip!=""){
			$this->db->where('sppd_pengikut.id_user',$nip);
		}
		if($nama!=""){
			$this->db->where('display_name like "%'.$nama.'%"');
		} 
		$this->db->where('status_atasan',1);
		$this->db->join('users u', 'sppd_pengikut.id_user = u.id', 'inner'); 
		$this->db->join('sppd_jabodetabek', 'sppd_jabodetabek.id = sppd_pengikut.kode_sppd', 'inner'); 
		return parent::find_all();

	} 
	 
	
}
