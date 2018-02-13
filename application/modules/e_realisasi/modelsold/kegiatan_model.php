<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kegiatan_model extends BF_Model {

	protected $table_name	= "sasd_skmpnen";
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
	
	public function tayangkegiatan($tahun = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "",$key = "",$kdoutput= "",$kdgiat= "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(bf_sasd_skmpnen.kdkmpnen) as kdkmpnen,TRIM(bf_sasd_skmpnen.kdskmpnen) as kdskmpnen,TRIM(bf_sasd_skmpnen.urskmpnen) as urskmpnen,trim(bf_sasd_skmpnen.kdoutput) as kdoutput,trim(bf_sasd_skmpnen.kdsoutput) as kdsoutput,urkmpnen,ursoutput,nmoutput,t.kdgiat,t.kdoutput');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(o.kdsoutput)',$kdsoutput);
		}
		if($kdoutput != ""){
			$this->db->where('trim(o.kdoutput)',$kdoutput);
		}
		if($kdgiat != ""){
			$this->db->where('trim(o.kdgiat)',$kdgiat);
		}
		if($key != ""){
			$this->db->where('ursoutput like "%'.$key.'%"');
		}
		if($tahun != ""){
			$this->db->where('trim(s.thang)',$tahun);
		}
		$this->db->join('sast_output t', 'bf_sasd_skmpnen.kdgiat = t.kdgiat and bf_sasd_skmpnen.kdoutput = t.kdoutput', 'left'); 
		$this->db->join('sasd_soutput o', 'o.kdgiat = sasd_skmpnen.kdgiat and o.kdoutput = bf_sasd_skmpnen.kdoutput and o.kdsoutput = bf_sasd_skmpnen.kdsoutput', 'left'); 
		$this->db->join('sasd_kmpnen s', 's.kdgiat = bf_sasd_skmpnen.kdgiat and s.kdoutput = bf_sasd_skmpnen.kdoutput and o.kdsoutput = bf_sasd_skmpnen.kdsoutput and s.kdkmpnen = bf_sasd_skmpnen.kdkmpnen', 'inner'); 
		
		
		
		//$this->db->where('o.kdsoutput = s.kdsoutput');
		$this->db->group_by("kdgiat");
		$this->db->group_by("kdoutput");
		$this->db->group_by("kdsoutput");
		$this->db->group_by("s.kdkmpnen");
		$this->db->group_by("kdskmpnen");
		
		
		
		$this->db->order_by("kdoutput","asc");
		$this->db->order_by("kdsoutput","asc");
		$this->db->order_by("kdkmpnen","asc");
		$this->db->order_by("kdskmpnen","asc");
		
		$this->db->distinct();
		return parent::find_all();

	} 
	public function tayangkegiatanrkakl($tahun = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "",$key = "",$kdoutput= "",$kdgiat= "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(bf_sasd_skmpnen.kdgiat) as kdgiat,TRIM(bf_sasd_skmpnen.kdkmpnen) as kdkmpnen,TRIM(bf_sasd_skmpnen.kdskmpnen) as kdskmpnen,TRIM(bf_sasd_skmpnen.urskmpnen) as urskmpnen,trim(bf_sasd_skmpnen.kdoutput) as kdoutput,trim(bf_sasd_skmpnen.kdsoutput) as kdsoutput,urkmpnen,nmoutput,ursoutput');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(o.kdsoutput)',$kdsoutput);
		}
		if($kdoutput != ""){
			$this->db->where('trim(o.kdoutput)',$kdoutput);
		}
		if($kdgiat != ""){
			$this->db->where('trim(o.kdgiat)',$kdgiat);
		}
		if($key != ""){
			$this->db->where('ursoutput like "%'.$key.'%"');
		}
		if($tahun != ""){
			$this->db->where('trim(s.thang)',$tahun);
		}
		
		$this->db->join('sast_output t', 'bf_sasd_skmpnen.kdgiat = t.kdgiat and bf_sasd_skmpnen.kdoutput = t.kdoutput', 'left'); 
		$this->db->join('sasd_soutput o', 'o.kdgiat = sasd_skmpnen.kdgiat and o.kdoutput = bf_sasd_skmpnen.kdoutput and o.kdsoutput = bf_sasd_skmpnen.kdsoutput', 'left'); 
		$this->db->join('sasd_kmpnen s', 's.kdgiat = bf_sasd_skmpnen.kdgiat and s.kdoutput = bf_sasd_skmpnen.kdoutput and o.kdsoutput = bf_sasd_skmpnen.kdsoutput and s.kdkmpnen = bf_sasd_skmpnen.kdkmpnen', 'inner'); 
		
		
		//$this->db->where('o.kdsoutput = s.kdsoutput');
		$this->db->group_by("kdgiat");
		$this->db->group_by("kdoutput");
		$this->db->group_by("kdsoutput");
		$this->db->group_by("s.kdkmpnen");
		$this->db->group_by("kdskmpnen");
		
		
		
		$this->db->order_by("kdoutput","asc");
		$this->db->order_by("kdsoutput","asc");
		$this->db->order_by("kdkmpnen","asc");
		$this->db->order_by("kdskmpnen","asc");
		
		$this->db->distinct();
		return parent::find_all();

	} 
	public function kegiatans($kdgiat = "",$kdoutput = "",$kdsoutput = "",$kdkmpnen = "",$kdskmpnen="")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(s.kdkmpnen) as kdkmpnen,TRIM(kdskmpnen) as kdskmpnen,TRIM(urskmpnen) as urskmpnen,s.urkmpnen,o.ursoutput,o.kdoutput,o.kdsoutput');
		}
		
		if($kdgiat != ""){
			$this->db->where('trim(s.kdgiat)',$kdgiat);
		}
		if($kdoutput != ""){
			//die($kdoutput);
			$this->db->where('sasd_skmpnen.kdoutput',$kdoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(s.kdsoutput)',$kdsoutput);
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(s.kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		 
		//$this->db->where('TRIM(urskmpnen) != "tanpa sub komponen"');
		
		$this->db->join('sasd_kmpnen s', 's.kdkmpnen = sasd_skmpnen.kdkmpnen', 'inner'); 
		$this->db->join('sasd_soutput o', 'o.kdoutput = sasd_skmpnen.kdoutput', 'left'); 
		
		$this->db->where('o.kdsoutput = s.kdsoutput');
		
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		$this->db->group_by("sasd_skmpnen.kdoutput");
		//$this->db->group_by("s.kdsoutput");
		
		$this->db->order_by("s.kdoutput","asc");
		$this->db->order_by("kdkmpnen","asc");
		$this->db->order_by("kdskmpnen","asc");
		
		//$this->db->distinct();
		return parent::find_all();

	} 
	public function getdistinct($kdkmpnen = "",$kdskmpnen="",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(bf_sasd_skmpnen.kdkmpnen) as kdkmpnen,TRIM(bf_sasd_skmpnen.kdskmpnen) as kdskmpnen,TRIM(bf_sasd_skmpnen.urskmpnen) as urskmpnen,trim(bf_sasd_skmpnen.kdoutput) as kdoutput,s.urkmpnen');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdsoutput)',$kdsoutput);
		}
		//$this->db->where('TRIM(urskmpnen) != "tanpa sub komponen"');
		$this->db->order_by("sasd_skmpnen.kdkmpnen","asc");
		$this->db->order_by("sasd_skmpnen.kdskmpnen","asc");
		$this->db->group_by("sasd_skmpnen.kdkmpnen");
		$this->db->group_by("sasd_skmpnen.kdskmpnen");
		$this->db->group_by("sasd_skmpnen.kdoutput");
		$this->db->join('sasd_kmpnen s', 's.kdkmpnen = sasd_skmpnen.kdkmpnen', 'inner'); 
		//$this->db->distinct();
		return parent::find_all();

	} 
	public function getdistinctkegiatan($kdkmpnen = "",$kdskmpnen="",$kdsoutput = "",$tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(bf_sasd_skmpnen.kdkmpnen) as kdkmpnen,nmoutput,TRIM(bf_sasd_skmpnen.kdskmpnen) as kdskmpnen,TRIM(bf_sasd_skmpnen.urskmpnen) as urskmpnen,trim(bf_sasd_soutput.kdoutput) as kdoutput,sasd_soutput.kdsoutput,s.urkmpnen,ursoutput,sasd_soutput.kdgiat');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdsoutput)',$kdsoutput);
		}
		$this->db->where('sasd_skmpnen.thang',$tahun);
		
		$this->db->group_by("sasd_soutput.kdgiat");
		$this->db->group_by("sasd_soutput.kdoutput");
		$this->db->group_by("sasd_soutput.kdsoutput");
		$this->db->group_by("sasd_skmpnen.thang");
		//$this->db->group_by("ursoutput");
		
		//$this->db->order_by("sasd_skmpnen.kdsoutput","asc");
		//$this->db->order_by("sasd_skmpnen.kdoutput","asc");
		$this->db->join('sast_output t', 'bf_sasd_skmpnen.kdgiat = t.kdgiat and bf_sasd_skmpnen.kdoutput = t.kdoutput', 'left'); 
		$this->db->join('sasd_kmpnen s', 's.kdkmpnen = sasd_skmpnen.kdkmpnen', 'inner'); 
		$this->db->join('sasd_soutput', 'sasd_soutput.thang = s.thang and bf_sasd_soutput.kdgiat = s.kdgiat and bf_sasd_soutput.kdoutput = s.kdoutput and bf_sasd_soutput.kdsoutput = s.kdsoutput', 'inner'); 
		//$this->db->distinct();
		return parent::find_all();

	} 
	public function getdistinctkomponen($kdkmpnen = "",$kdskmpnen="",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(bf_sasd_skmpnen.kdkmpnen) as kdkmpnen,TRIM(bf_sasd_skmpnen.kdskmpnen) as kdskmpnen,TRIM(bf_sasd_skmpnen.urskmpnen) as urskmpnen,trim(bf_sasd_skmpnen.kdoutput) as kdoutput,s.urkmpnen');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdsoutput)',$kdsoutput);
		}
		//$this->db->where('TRIM(urskmpnen) != "tanpa sub komponen"');
		$this->db->order_by("sasd_skmpnen.kdkmpnen","asc");
		$this->db->order_by("sasd_skmpnen.kdskmpnen","asc");
		$this->db->group_by("sasd_skmpnen.kdkmpnen");
		$this->db->group_by("sasd_skmpnen.kdskmpnen");
		//$this->db->group_by("sasd_skmpnen.kdoutput");
		$this->db->join('sasd_kmpnen s', 's.kdkmpnen = sasd_skmpnen.kdkmpnen', 'inner'); 
		//$this->db->distinct();
		return parent::find_all();

	} 
	public function getkegiatanandpagu($kdkmpnen = "",$kdskmpnen="",$kdsoutput = "",$kdputput = "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(bf_sasd_skmpnen.kdkmpnen) as kdkmpnen,TRIM(bf_sasd_skmpnen.kdskmpnen) as kdskmpnen,TRIM(bf_sasd_skmpnen.urskmpnen) as urskmpnen,trim(bf_sasd_skmpnen.kdoutput) as kdoutput,s.urkmpnen');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(bf_sasd_skmpnen.kdsoutput)',$kdsoutput);
		}
		//$this->db->where('TRIM(urskmpnen) != "tanpa sub komponen"');
		$this->db->order_by("sasd_skmpnen.kdkmpnen","asc");
		$this->db->order_by("sasd_skmpnen.kdskmpnen","asc");
		$this->db->group_by("sasd_skmpnen.kdkmpnen");
		$this->db->group_by("sasd_skmpnen.kdskmpnen");
		$this->db->group_by("sasd_skmpnen.kdoutput");
		$this->db->join('sasd_kmpnen s', 's.kdkmpnen = sasd_skmpnen.kdkmpnen', 'inner'); 
		//$this->db->distinct();
		return parent::find_all();

	} 
	public function list_fields()
	{
		$this->selects = "";
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(kdsoutput)',$kdsoutput);
		}
		//$this->db->where('TRIM(urskmpnen) != "tanpa sub komponen"');
		$this->db->order_by("kdkmpnen","asc");
		$this->db->order_by("kdskmpnen","asc");
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		//$this->db->group_by("kdoutput");
		//$this->db->order_by("kdoutput","asc");
		$this->db->distinct();
		return parent::find_all();

	} 
	public function tayangperkwitansi($kdkmpnen = "",$kdskmpnen = "" ,$output = "",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(kdkmpnen) as kdkmpnen,TRIM(kdskmpnen) as kdskmpnen,TRIM(urskmpnen) as urskmpnen,trim(kdoutput) as kdoutput');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($output != ""){
			$this->db->where('trim(kdoutput)',$output);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(kdsoutput)',$kdsoutput);
		}
		 
		$this->db->where('thang',date("Y"));
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		$this->db->group_by("kdoutput");
		$this->db->order_by("kdoutput","asc");
		$this->db->order_by("kdkmpnen","asc");
		$this->db->order_by("kdskmpnen","asc");
		
		$this->db->distinct();
		return parent::find_all();

	} 
	public function getkegiatans($kdkmpnen = "",$kdskmpnen="",$kdsoutput = "",$key = "",$kdoutput= "",$kdgiat= "")
	{
		if (empty($this->selects))
		{
			$this->select('TRIM(bf_sasd_skmpnen.kdkmpnen) as kdkmpnen,TRIM(bf_sasd_skmpnen.kdskmpnen) as kdskmpnen,TRIM(bf_sasd_skmpnen.urskmpnen) as urskmpnen,trim(bf_sasd_skmpnen.kdoutput) as kdoutput,trim(bf_sasd_skmpnen.kdsoutput) as kdsoutput,urkmpnen');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('trim(o.kdsoutput)',$kdsoutput);
		}
		if($kdoutput != ""){
			$this->db->where('trim(o.kdoutput)',$kdoutput);
		}
		if($kdgiat != ""){
			$this->db->where('trim(o.kdgiat)',$kdgiat);
		}
		if($key != ""){
			$this->db->where('ursoutput like "%'.$key.'%"');
		}
		
		$this->db->join('sasd_kmpnen s', 's.kdkmpnen = sasd_skmpnen.kdkmpnen', 'inner'); 
		$this->db->join('sasd_soutput o', 'o.kdoutput = sasd_skmpnen.kdoutput', 'left'); 
		
		$this->db->where('o.kdsoutput = s.kdsoutput');
		
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		 
		$this->db->order_by("kdoutput","asc");
		$this->db->order_by("kdkmpnen","asc");
		$this->db->order_by("kdskmpnen","asc");
		
		$this->db->distinct();
		return parent::find_all();

	} 
}
