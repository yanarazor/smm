<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sasd_item_model extends BF_Model {

	protected $table_name	= "sasd_item";
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
			"field"		=> "izin_keluar_tanggal",
			"label"		=> "Tanggal",
			"rules"		=> "required"
		),
		array(
			"field"		=> "izin_keluar_dari_jam",
			"label"		=> "Dari Jam",
			"rules"		=> "required"
		),
		array(
			"field"		=> "izin_keluar_sampai_jam",
			"label"		=> "Sampai Jam",
			"rules"		=> "required"
		),
		array(
			"field"		=> "izin_keluar_keterangan",
			"label"		=> "Keterangan",
			"rules"		=> ""
		),
		array(
			"field"		=> "izin_keluar_usr_id",
			"label"		=> "User",
			"rules"		=> "max_length[20]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function sum_akun($akun = "",$tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select('sum(jumlah) as jumlah_pagu');
		}
		if($akun != ""){
			$this->db->where('kdakun',$akun);
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		//$this->db->join('users u', 'izin_keluar.usr_id = u.id', 'left'); 
		return parent::find_all();
	} 
	public function getpaguakun($kdgiat = "",$kdoutput = "",$kdsoutput = "",$kdkmpnen = "",$kdskmpnen = "", $akun = "",$tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select('sum(jumlah) as jumlah_pagu');
		}
		if($kdgiat != ""){
			$this->db->where('kdgiat',$kdgiat);
		}
		if($kdoutput != ""){
			$this->db->where('kdoutput',$kdoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('kdsoutput',$kdsoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('kdsoutput',$kdsoutput);
		}
		if($kdkmpnen != ""){
			$this->db->where('kdkmpnen',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($akun != ""){
			$this->db->where('kdakun',$akun);
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		return parent::find_all();
	} 
	public function sum_akunanggaran($akun = "",$tahun = "",$anggaran = "")
	{
		if (empty($this->selects))
		{
			$this->select('sum(jumlah) as jumlah_pagu');
		}
		if($akun != ""){
			$this->db->where('kdakun',$akun);
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		if($anggaran != ""){
			$this->db->where('dipa',$anggaran);
		}
		$this->db->join('kegiatan k',"k.tahun = bf_sasd_item.thang 
				and k.kode = bf_sasd_item.kdgiat 
				and k.kdoutput = bf_sasd_item.kdoutput 
				and k.kdsoutput = bf_sasd_item.kdsoutput 
				and k.kdkmpnen = bf_sasd_item.kdkmpnen 
				and k.kdskmpnen = trim(bf_sasd_item.kdskmpnen)", 'inner'); 
		return parent::find_all();
	} 
}
