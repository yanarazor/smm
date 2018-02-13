<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rkakl_model extends BF_Model {

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
	
	public function getrekappermak($tahun = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "",$mak = "",$kdsuboutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('trim(a.kdakun) as kdakun,trim(nmakun) as nmakun,sum(jumlah) as pagu,trim(kdskmpnen) as kdskmpnen,trim(kdkmpnen) as kdkmpnen,trim(kdoutput) as kdoutput,trim(kdsoutput) as kdsoutput');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(kdoutput)',$kdsoutput);
		}
		if($kdsuboutput != ""){
			$this->db->where('trim(kdsoutput)',$kdsuboutput);
		}
		if($mak != ""){
			$this->db->where('sasd_item.kdakun like "'.$mak.'%"');
			//$this->db->where('kdakun like "'.$mak.'%"');
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		//$this->db->where('trim(kdoutput)',"001");
		$this->db->join('sast_akun a', 'sasd_item.kdakun = a.kdakun', 'left'); 
		$this->db->order_by("kdakun","asc");
		$this->db->group_by("kdakun");
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		$this->db->group_by("kdoutput");
		$this->db->group_by("kdsoutput");
		//$this->db->order_by("kdoutput","asc");
		
		//$this->db->order_by("kdsoutput","asc");
		//$this->db->order_by("kdsoutput","asc");
		$this->db->order_by("kdkmpnen","asc");
		$this->db->order_by("kdskmpnen","asc");
		//$this->db->order_by("kdakun","asc");
		return parent::find_all();

	} 
	public function rekappermak($tahun = "",$kdgiat = "",$kdoutput = "",$kdsoutput = "",$kdkmpnen = "",$kdskmpnen = "",$mak = "")
	{
		if (empty($this->selects))
		{
			$this->select('trim(a.kdakun) as kdakun,trim(nmakun) as nmakun,sum(jumlah) as pagu,trim(kdskmpnen) as kdskmpnen,trim(kdkmpnen) as kdkmpnen,trim(kdoutput) as kdoutput,trim(kdsoutput) as kdsoutput');
		}
		if($kdgiat != ""){
			$this->db->where('trim(kdgiat)',$kdgiat);
		}
		if($kdoutput != ""){
			$this->db->where('trim(kdoutput)',$kdoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(kdsoutput)',$kdsoutput);
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			//$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($mak != ""){
			$this->db->where('sasd_item.kdakun like "'.$mak.'%"');
			//$this->db->where('kdakun like "'.$mak.'%"');
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		//$this->db->where('trim(kdoutput)',"001");
		$this->db->join('sast_akun a', 'sasd_item.kdakun = a.kdakun', 'left'); 
		$this->db->group_by("kdakun");
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		$this->db->group_by("kdoutput");
		$this->db->group_by("kdsoutput");
		//$this->db->order_by("kdoutput","asc");
		//$this->db->order_by("kdsoutput","asc");
		
		$this->db->order_by("kdskmpnen","asc");
		$this->db->order_by("kdakun","asc");
		//$this->db->order_by("kdkmpnen","asc");
		//$this->db->order_by("kdakun","asc");
		return parent::find_all();

	} 
	public function rekappermakkegiatan($tahun = "",$kdgiat = "",$kdoutput = "",$kdsoutput = "",$kdkmpnen = "",$kdskmpnen = "",$mak = "")
	{
		if (empty($this->selects))
		{
			$this->select('sasd_item.kdgiat,sasd_item.kdoutput,sasd_item.kdsoutput,sum(jumlah) as pagu,trim(kdskmpnen) as kdskmpnen,trim(kdkmpnen) as kdkmpnen,trim(kdoutput) as kdoutput,trim(kdsoutput) as kdsoutput');
		}
		if($kdgiat != ""){
			$this->db->where('trim(kdgiat)',$kdgiat);
		}
		if($kdoutput != ""){
			$this->db->where('trim(kdoutput)',$kdoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(kdsoutput)',$kdsoutput);
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			//$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($mak != ""){
			$this->db->where('sasd_item.kdakun like "'.$mak.'%"');
			//$this->db->where('kdakun like "'.$mak.'%"');
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		$this->db->group_by("sasd_item.kdgiat");
		$this->db->group_by("sasd_item.kdoutput");
		$this->db->group_by("sasd_item.kdsoutput");
		$this->db->group_by("sasd_item.kdkmpnen");
		$this->db->group_by("sasd_item.kdskmpnen");
		$this->db->group_by("sasd_item.thang");
		
		return parent::find_all();

	} 
	public function getrekappermakperprogram($tahun = "",$kdkmpnen = "",$kdskmpnen="")
	{
		if (empty($this->selects))
		{
			$this->select('sum(jumlah) as pagu,trim(kdskmpnen) as kdskmpnen,trim(kdkmpnen) as kdkmpnen,kdoutput');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		//$this->db->where('trim(kdoutput)',"001");
		//$this->db->join('sast_akun a', 'sasd_item.kdakun = a.kdakun', 'left'); 
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		$this->db->group_by("kdoutput");
		return parent::find_all();

	} 
	public function showrkakl($tahun = "",$kdoutput = "",$kdsoutput = "",$kdkmpnen = "",$kdskmpnen="",$kdakun = "")
	{
		if (empty($this->selects))
		{
			$this->select('noitem,volkeg,hargasat,header1,header2,kdheader,a.kdakun,nmakun,bf_sasd_item.kdkmpnen,kdskmpnen,nmitem,jumlah,
			(select sum(rupiah) from bf_sasdd_kuitansi k inner join bf_saskuitansi_rkakl rk on(k.nokwt = rk.nokwt) where 
			bf_sasd_item.kdkmpnen = rk.kdkmpnen
			and bf_sasd_item.kdskmpnen = rk.kdskmpnen
			and bf_sasd_item.kdoutput = rk.kdoutput
			and bf_sasd_item.kdsoutput = rk.kdsoutput
			and bf_sasd_item.kdakun = rk.kdakun
			and bf_sasd_item.noitem = rk.noitem
			and k.thang = '.$tahun.'
			) as realisasipagu');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(bf_sasd_item.kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdoutput != ""){
			$this->db->where('trim(kdoutput)',$kdoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(kdsoutput)',$kdsoutput);
		}
		if($kdakun != ""){
			$this->db->where('trim(a.kdakun)',$kdakun);
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		$this->db->join('sast_akun a', 'sasd_item.kdakun = a.kdakun', 'left'); 
		
		$this->db->order_by("kdakun","asc");
		$this->db->order_by("noitem","asc");
		
		$this->db->order_by("header1","asc");
		$this->db->order_by("kdheader","desc");
		$this->db->distinct();
		return parent::find_all();

	} 
	public function viewrkakl($kdkmpnen = "",$kdskmpnen="",$kdoutput = "",$kdsoutput = "",$kdakun = "")
	{
		if (empty($this->selects))
		{
			$this->select('noitem,volkeg,hargasat,header1,header2,kdheader,a.kdakun,nmakun,kdkmpnen,kdskmpnen,nmitem,jumlah,a.kdakun,kdoutput,kdsoutput');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdoutput != ""){
			$this->db->where('trim(kdoutput)',$kdoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(kdsoutput)',$kdsoutput);
		}
		if($kdakun != ""){
			$this->db->where('trim(a.kdakun)',$kdakun);
		}
		$this->db->join('sast_akun a', 'sasd_item.kdakun = a.kdakun', 'left'); 
		
		$this->db->order_by("kdakun","asc");
		$this->db->order_by("noitem","asc");
		
		$this->db->order_by("header1","asc");
		$this->db->order_by("kdheader","desc");
		$this->db->where('thang',date("Y"));
		return parent::find_all();

	} 
	public function rekapperkdakun($tahun = "",$kdakun = "")
	{
		if (empty($this->selects))
		{
			$this->select('sum(jumlah) as pagu');
		}
		
		if($kdakun != ""){
			$this->db->where('bf_sasd_item.kdakun like "'.$kdakun.'%"');
		}
		if($tahun != ""){
			$this->db->where('thang',$tahun);
		}
		$this->db->group_by("sasd_item.thang");
		return parent::find_all();

	} 
}
