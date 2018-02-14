<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sas_model extends BF_Model {

	protected $table_item			= "d_item";
	protected $table_d_output		= "d_output";
	protected $table_d_soutput		= "d_soutput";
	protected $table_d_komponen		= "d_kmpnen";
	protected $table_d_skomponen	= "d_skmpnen";
	protected $table_dd_kuitansi	= "dd_kuitansi";
	protected $table_dd_drpp_dt			= "dd_drpp_dt";
	protected $table_d_spm_mak			= "d_spmmak";
	protected $table_dd_spm_mak			= "dd_spmmak";
	protected $table_d_spmind			= "d_spmind";
	protected $table_t_tranbend			= "t_tranbend";
	
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;
	protected $db2 			= "";

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
	public $configsas;
	//--------------------------------------------------------------------
	function __construct()
    {
		
		$this->configsas = $db['sas_db'] = array(
		      'hostname' => $this->settings_lib->item('site.sashost'),
		      'username' => $this->settings_lib->item('site.sasusername'),
		      'password' => $this->settings_lib->item('site.saspassword'),
		      'database' => $this->settings_lib->item('site.sasdatabase'),
		      'port' 	=> $this->settings_lib->item('site.sasport'),
		      'dbdriver' => 'mysqli',
		      'dbprefix' => '',
		      'pconnect' => FALSE,
		      'db_debug' => (ENVIRONMENT !== 'production'),
		      'cache_on' => FALSE,
		      'cachedir' => '',
		      'char_set' => 'utf8',
		      'dbcollat' => 'utf8_general_ci',
		      'swap_pre' => '',
		      'encrypt' => FALSE,
		      'compress' => FALSE,
		      'stricton' => FALSE,
		      'failover' => array(),
		      'save_queries' => TRUE);

		$this->db2 = $this->load->database($this->configsas, TRUE);
		//$this->db2 = $this->load->database('sas_db', TRUE);

		 
    }//end __construct
	public function get_dataitem($akun = "",$tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_item.'		
		')->result();
		return $data;
	} 
	public function get_datad_output($akun = "",$tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_d_output.'		
		')->result();
		return $data;
	} 
	public function get_datad_soutput($akun = "",$tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_d_soutput.'		
		')->result();
		return $data;
	} 
	public function get_data_komponen($akun = "",$tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_d_komponen.'		
		')->result();
		return $data;
	} 
	public function get_data_skomponen($akun = "",$tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_d_skomponen.'		
		')->result();
		return $data;
	} 
	public function get_kuitansi($akun = "",$tahun = "")
	{
		$data = $this->db2->query('
			select code_id,kdsatker,kdbpp,nokwt,tglkwt,thang,kdjendok,
	kddept,kdunit,kddekon,nokarwas,kdkppn,kdlokasi,kdkabkota,kdjnsban,
	kdbeban,kdctarik,kdsdana,thbeban,kdkelbay,kdpinjam,noregis,
	kdprogram,kdgiat,kdoutput,kdsoutput,kdkmpnen,kdskmpnen,kdbkpk,
	kdakun,rupiah,
	uraian,
	nipppk,nmppk,jabtrim,nmtrim,niptgjwb,nmtgjwb,kota,notran,tgltran,nopjk,
	nosp2d,nokwt2,npwp,nodrpp,tgcreate,usernip,register
			from
			'.$this->table_dd_kuitansi.'		
		')->result();
		return $data;
	} 
	public function get_dd_drpp_dt($tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_dd_drpp_dt.'		
		')->result();
		return $data;
	} 
	public function get_d_spm_mak($tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_d_spm_mak.'		
		')->result();
		return $data;
	} 
	public function get_dd_spm_mak($tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_dd_spm_mak.'		
		')->result();
		return $data;
	} 
	public function get_d_spm_id($tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_d_spmind.'		
		')->result();
		return $data;
	}
	public function get_t_tranbend($tahun = "")
	{
		$data = $this->db2->query('
			select *
			from
			'.$this->table_t_tranbend.'		
		')->result();
		return $data;
	}

}
