<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sasmm_spmmak_model extends BF_Model {

	protected $table_name	= "sasmm_spmmak";
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
	
	public function getrealisasi($tahun = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('kdgiat,kdoutput,kdkmpnen,sasmm_spmmak.kdskmpnen,sasmm_spmmak.kdakun,sum(nilmak) as jumlah,kdsoutput,trim(kdjenspm) as kdjenspm');
		}
		$this->db->where('sasmm_spmmak.thang',$tahun);
		if($kdkmpnen != ""){
			$this->db->where('kdkmpnen',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('kdsoutput',$kdsoutput);
		}
		if($tahun != ""){
			$this->db->where('sasmm_spmmak.thang',$tahun);
		}
		//$this->db->where('kdakun != "532111"');
		//$this->db->where('kdkmpnen != "011"');
		//$this->db->join('sasd_spmind', 'sasmm_spmmak.code_id = sasd_spmind.code_id', 'left'); 
		//$this->db->join('sasd_skmpnen', 'sasd_skmpnen.kdskmpnen = sasmm_spmmak.kdskmpnen', 'left'); 
		//$this->db->or_where('sasdd_tranbend.notran not in (select notran from bf_sasdd_drpp_dt)');
		//$this->db->join('sasdd_tranbend', 'sasdd_tranbend.nospm = sasmm_spmmak.nospm', 'left'); 
		//$this->db->where('(bf_sasmm_spmmak.kdkmpnen = trim(bf_sasd_skmpnen.kdkmpnen)) and (trim(bf_sasd_skmpnen.kdsoutput) = bf_sasmm_spmmak.kdsoutput)');
		//$this->db->or_where('sasdd_tranbend.notran not in (select notran from bf_sasdd_drpp_dt)');
		$this->db->group_by("kdgiat");
		$this->db->group_by("kdoutput");
		$this->db->group_by("kdsoutput");
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		$this->db->group_by("kdakun");
		return parent::find_all();

	} 
	public function getrealisasiperbulan($tahun = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('YEAR(bf_sasmm_spmmak.tgspm) as year,MONTH(bf_sasmm_spmmak.tgspm) as month,sum(nilmak) as jumlah,kdgiat,kdoutput,sasmm_spmmak.kdkmpnen,sasmm_spmmak.kdskmpnen,sasmm_spmmak.kdakun,sum(nilmak) as jumlah,kdsoutput,trim(kdjenspm) as kdjenspm');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('kdsoutput',$kdsoutput);
		}
		if($tahun != ""){
			$this->db->where('sasmm_spmmak.thang',$tahun);
		}
		$this->db->join('sasd_spmind', 'sasmm_spmmak.code_id = sasd_spmind.code_id', 'left'); 
		$this->db->group_by("kdgiat");
		$this->db->group_by("kdoutput");
		$this->db->group_by("kdsoutput");
		//$this->db->group_by("kdkmpnen");
		//$this->db->group_by("kdskmpnen");
		$this->db->group_by("YEAR(bf_sasmm_spmmak.tgspm)");
		$this->db->group_by("MONTH(bf_sasmm_spmmak.tgspm)");
		
		return parent::find_all();

	} 
	public function getrealisasiperbulanall($tahun = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('YEAR(bf_sasmm_spmmak.tgspm) as year,MONTH(bf_sasmm_spmmak.tgspm) as month,sum(nilmak) as jumlah');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			$this->db->where('kdsoutput',$kdsoutput);
		}
		if($tahun != ""){
			$this->db->where('sasmm_spmmak.thang',$tahun);
		}
		$this->db->join('sasd_spmind', 'sasmm_spmmak.code_id = sasd_spmind.code_id', 'left'); 
		//$this->db->group_by("kdgiat");
		//$this->db->group_by("kdoutput");
		//$this->db->group_by("kdsoutput");
		//$this->db->group_by("kdkmpnen");
		//$this->db->group_by("kdskmpnen");
		$this->db->group_by("YEAR(bf_sasmm_spmmak.tgspm)");
		$this->db->group_by("MONTH(bf_sasmm_spmmak.tgspm)");
		
		return parent::find_all();

	} 
	
	public function getrealisasils($tahun = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select('kdgiat,kdoutput,kdsoutput,sasmm_spmmak.kdkmpnen,sasmm_spmmak.kdskmpnen,sasmm_spmmak.kdakun,sum(nilmak) as jumlah,trim(kdjenspm) as kdjenspm');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		if($kdsoutput != ""){
			//$this->db->where('kdsoutput',$kdsoutput);
		}
		if($tahun != ""){
			$this->db->where('sasmm_spmmak.thang',$tahun);
		}
		//$this->db->where('(kdjenspm = "01" or kdjenspm = "02" or kdjenspm = "03" or kdjenspm = "07" or kdjenspm = "04")');
		//$this->db->where('kdkmpnen != "011"');
		$this->db->join('sasd_spmind', 'sasmm_spmmak.code_id = sasd_spmind.code_id', 'left'); 
		//$this->db->or_where('sasdd_tranbend.notran not in (select notran from bf_sasdd_drpp_dt)');
		//$this->db->join('sasdd_tranbend', 'sasdd_tranbend.nospm = sasmm_spmmak.nospm', 'left'); 
		//$this->db->where('sasmm_spmmak.nospm not in (select nospm from bf_sasdd_tranbend)');
		//$this->db->or_where('sasdd_tranbend.notran not in (select notran from bf_sasdd_drpp_dt)');
		
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdakun");
		$this->db->group_by("kdskmpnen");
		$this->db->group_by("kdsoutput");
		return parent::find_all();

	} 
	 
}
