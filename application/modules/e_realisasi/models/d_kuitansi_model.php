<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class d_kuitansi_model extends BF_Model {

	protected $table_name	= "sasdd_kuitansi";
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
	public function find_all($kdkmpnen = "",$kdskmpnen="",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*');
		}
		if($kdkmpnen != ""){
			$this->db->where('kdkmpnen',$kdkmpnen);
		}
		//$this->db->join('users u', 'izin_keluar.usr_id = u.id', 'left'); 
		$this->db->order_by("tglkwt","desc");
		$this->db->order_by("nokwt","asc");
		return parent::find_all();

	} 
	public function find_allrakakl($nokwt = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "",$tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,r.kdakun as kdakunrkakl');
		}
		if($kdkmpnen != ""){
			$this->db->where('sasdd_kuitansi.kdkmpnen',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('sasdd_kuitansi.kdskmpnen',$kdskmpnen);
		}
		if($tahun != ""){
			$this->db->where('tglkwt like "'.$tahun.'-%"');
		}else{
			$this->db->where('tglkwt like "'.date("Y").'-%"');	
		}
		
		$this->db->join('saskuitansi_rkakl r', 'r.nokwt = sasdd_kuitansi.nokwt and r.kdoutput = bf_sasdd_kuitansi.kdoutput and r.kdsoutput = bf_sasdd_kuitansi.kdsoutput and r.kdkmpnen = bf_sasdd_kuitansi.kdkmpnen and trim(r.kdskmpnen) = trim(bf_sasdd_kuitansi.kdskmpnen)', 'left'); 
		
		$this->db->order_by("r.nokwt","asc");
		$this->db->order_by("tglkwt","desc");
		$this->db->order_by("kdakunrkakl","asc");
		$this->db->order_by("nokwt","desc");
		return parent::find_all();

	} 
	public function count_allrakakl($nokwt = "",$kdkmpnen = "",$kdskmpnen="",$kdsoutput = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,r.kdakun as kdakunrkakl');
		}
		if($kdkmpnen != ""){
			$this->db->where('sasdd_kuitansi.kdkmpnen',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('sasdd_kuitansi.kdskmpnen',$kdskmpnen);
		}
		 
		$this->db->join('saskuitansi_rkakl r', 'r.nokwt = sasdd_kuitansi.nokwt', 'left'); 
	 	$this->db->where('tglkwt like  "'.date("Y").'-%"');
		return parent::count_all();

	} 
	public function getrealisasi($tahun = "",$kdgiat = "",$kdoutput = "",$kdsoutput = "",$kdkmpnen = "",$kdskmpnen="")
	{
		if (empty($this->selects))
		{
			$this->select('kdgiat,kdoutput,kdsoutput,kdkmpnen,kdskmpnen,kdakun,sum(rupiah) as jumlah');
		}
		//if($tahun != ""){
			$this->db->where('thang',$tahun);
		//}
		//die($tahun);
		if($kdgiat != ""){
			$this->db->where('kdgiat',$kdgiat);
		}
		if($kdoutput != ""){
			$this->db->where('kdoutput',$kdoutput);
		}
		if($kdsoutput != ""){
			$this->db->where('kdsoutput',$kdsoutput);
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		
		
		//$this->db->join('sasd_item i', 'i.usr_id = u.id', 'left'); 
		$this->db->group_by("kdgiat");
		$this->db->group_by("kdoutput");
		$this->db->group_by("kdsoutput");
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		$this->db->group_by("kdakun");
		return parent::find_all();

	}
	public function getrealisasiperkegiatan($tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select('kdgiat,kdkmpnen,kdskmpnen,kdoutput,kdsoutput,sum(rupiah) as jumlah');
		}
		//if($tahun != ""){
			$this->db->where('thang',$tahun);
		//}
		//die($tahun);
		 
		
		//$this->db->join('sasd_item i', 'i.usr_id = u.id', 'left'); 
		$this->db->group_by("kdgiat");
		$this->db->group_by("kdoutput");
		$this->db->group_by("kdsoutput");
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		return parent::find_all();

	} 
	public function getrealisasiperkegiatanold($kdgiat = "",$kdoutput = "",$kdsoutput = "",$kdkmpnen = "",$kdskmpnen="")
	{
		if (empty($this->selects))
		{
			$this->select('kdkmpnen,kdskmpnen,sum(rupiah) as jumlah,kdgiat,kdoutput,kdsoutput');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		 
		//$this->db->join('sasd_item i', 'i.usr_id = u.id', 'left'); 
		$this->db->group_by("kdgiat"); 
		$this->db->group_by("kdoutput"); 
		$this->db->group_by("kdsoutput"); 
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		return parent::find_all();

	} 
	
	public function getrealisasiperbulan($kdkmpnen = "",$kdskmpnen="")
	{
		if (empty($this->selects))
		{
			$this->select('kdkmpnen,kdskmpnen,sum(rupiah) as jumlah');
		}
		if($kdkmpnen != ""){
			$this->db->where('trim(kdkmpnen)',$kdkmpnen);
		}
		if($kdskmpnen != ""){
			$this->db->where('trim(kdskmpnen)',$kdskmpnen);
		}
		 
		//$this->db->join('sasd_item i', 'i.usr_id = u.id', 'left'); 
		$this->db->group_by("kdkmpnen");
		$this->db->group_by("kdskmpnen");
		return parent::find_all();

	} 
	public function fidndetil($kolom = "",$kode="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,sasdd_tranbend.tgtran as tanggaltransaksi');
		}
		$this->db->join('sasdd_tranbend', 'sasdd_tranbend.notran = sasdd_kuitansi.notran and bf_sasdd_tranbend.thang = bf_sasdd_kuitansi.thang', 'left'); 
		return parent::find_by($kolom,$kode);

	} 
	
}
