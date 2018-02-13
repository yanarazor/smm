<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_ptpp_model extends BF_Model {

	protected $table_name	= "daftar_ptpp";
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
			"field"		=> "daftar_ptpp_ditujukan_kepada",
			"label"		=> "Ditujukan Kepada",
			"rules"		=> "required|max_length[50]"
		),
		array(
			"field"		=> "daftar_ptpp_diajukan_oleh",
			"label"		=> "Diajukan Oleh",
			"rules"		=> "required|max_length[50]"
		),
		array(
			"field"		=> "daftar_ptpp_no_ptpp",
			"label"		=> "No PTPP",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "daftar_ptpp_tgl_ptpp",
			"label"		=> "Tanggal",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_referensi",
			"label"		=> "Referensi",
			"rules"		=> "max_length[100]"
		),
		array(
			"field"		=> "daftar_ptpp_kategori",
			"label"		=> "Kategori",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "daftar_ptpp_deskripsi_ketidaksesuaian",
			"label"		=> "Deskripsi Ketidaksesuaian",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_tanggal_pengusulan",
			"label"		=> "Tgl Pengusulan",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_tanggal_tandatangan_auditi",
			"label"		=> "Tanggal Tanda Tangan Auditi",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_hasil_investigasi",
			"label"		=> "Hasil Investigasi",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_tgl_tandatangan_hasil",
			"label"		=> "Tgl Tanda Tangan Hasil",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_tindakan_koreksi",
			"label"		=> "Tindakan Koreksi",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_tindakan_korektif",
			"label"		=> "Tindakan Korektif",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_tgl_penyelesaian",
			"label"		=> "Tgl Penyelesaian",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_disetujui_oleh",
			"label"		=> "Disetujui Oleh",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "daftar_ptpp_tanggal_disetujui",
			"label"		=> "Tgl Disetujui",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_tinjauan_tindakan_perbaikan",
			"label"		=> "Tinjauan Tindakan Perbaikan",
			"rules"		=> ""
		),
		array(
			"field"		=> "daftar_ptpp_kesimpulan",
			"label"		=> "Kesimpulan",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= TRUE;

	//--------------------------------------------------------------------
	public function find_all($status="",$checklist="",$bid="",$audit = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pembuat,us.display_name as user_tujuan,s.status as status_ptpp,bidang,kategori_ptpp.kategori as kat');
		}
		if($status!=""){
			$this->db->where('daftar_ptpp.status',$status);
		}
		if($checklist!=""){
			$this->db->where('daftar_ptpp.kode_audit',$checklist);
		}
		if($bid!=""){
			$this->db->where('daftar_ptpp.id_bidang',$bid);
		}
		if($audit!=""){
			$this->db->where('daftar_ptpp.kode_audit',$audit);
		}
		$this->db->join('users u', 'daftar_ptpp.diajukan_oleh = u.id', 'left'); 
		$this->db->join('status_ptpp s', 'daftar_ptpp.status = s.id', 'left');
		$this->db->join('bidang', 'daftar_ptpp.id_bidang = bidang.id', 'left');
		$this->db->join('users us', 'bidang.kabid = us.id', 'left'); 
		$this->db->join('kategori_ptpp', 'daftar_ptpp.kategori = kategori_ptpp.id', 'left'); 
		$this->db->order_by('no_ptpp', 'asc'); 
		return parent::find_all();

	} 
	public function find_all_audit($status="",$checklist="",$ai="",$bidang="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pembuat,us.display_name as user_tujuan,s.status as status_ptpp,bidang,kategori_ptpp.kategori as kat');
		}
		if($status!=""){
			$this->db->where('daftar_ptpp.status',$status);
		}
		if($checklist!=""){
			$this->db->where('daftar_ptpp.kode_audit',$checklist);
		}
		if($ai!=""){
			$this->db->where('daftar_ptpp.kode_audit',$ai);
		}
		if($bidang!=""){
			$this->db->where('bidang.id',$bidang);
		}
		//$this->db->where('kode_audit != ""');
		$this->db->join('users u', 'daftar_ptpp.diajukan_oleh = u.id', 'left'); 
		$this->db->join('status_ptpp s', 'daftar_ptpp.status = s.id', 'left');
		$this->db->join('bidang', 'daftar_ptpp.id_bidang = bidang.id', 'left');
		$this->db->join('users us', 'bidang.kabid = us.id', 'left'); 
		$this->db->join('daftar_periksa_audit', 'daftar_ptpp.kode_audit = daftar_periksa_audit.id', 'left'); 
		$this->db->join('audit_internal', 'audit_internal.id = daftar_periksa_audit.id_jadwal_audit', 'left'); 
		$this->db->join('kategori_ptpp', 'daftar_ptpp.kategori = kategori_ptpp.id', 'left'); 
		return parent::find_all();

	} 
	public function GetGroupByKategori($year="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,kategori_ptpp.kategori as kat,count(*) as jumlah');
		}
		$this->db->join('kategori_ptpp', 'daftar_ptpp.kategori = kategori_ptpp.id', 'left'); 
		$this->db->group_by('kategori'); 
		//$this->db->where('status_active',"1");
		return parent::find_all();

	}
	public function GetGroupByStatus($year="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,status_ptpp.status as stat,count(*) as jumlah');
		}
		$this->db->join('status_ptpp', 'daftar_ptpp.status = status_ptpp.id', 'left'); 
		$this->db->group_by('daftar_ptpp.status'); 
		//$this->db->where('status_active',"1");
		return parent::find_all();

	}
	public function GetGroupBybidangOpen($year="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,status_ptpp.status as stat,count(*) as jumlah,bidang');
		}
		$this->db->join('status_ptpp', 'daftar_ptpp.status = status_ptpp.id', 'left'); 
		$this->db->join('bidang', 'daftar_ptpp.id_bidang = bidang.id', 'left'); 
		$this->db->group_by('daftar_ptpp.id_bidang,daftar_ptpp.status'); 
		$this->db->order_by('bidang',"asc");
		return parent::find_all();

	}

}
