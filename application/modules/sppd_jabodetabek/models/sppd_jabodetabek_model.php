<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sppd_jabodetabek_model extends BF_Model {

	protected $table_name	= "sppd_jabodetabek";
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
			"field"		=> "sppd_jabodetabek_pejabat",
			"label"		=> "Pejabat Berwenang Memberi Perintah",
			"rules"		=> "required|max_length[10]"
		),
		array(
			"field"		=> "sppd_jabodetabek_pegawai",
			"label"		=> "Pegawai",
			"rules"		=> "required|max_length[20]"
		),
		array(
			"field"		=> "sppd_jabodetabek_maksud",
			"label"		=> "Maksud Perjalanan Dinas",
			"rules"		=> "max_length[255]"
		),
		array(
			"field"		=> "sppd_jabodetabek_anggaran",
			"label"		=> "Anggaran",
			"rules"		=> "max_length[20]"
		),
		array(
			"field"		=> "sppd_jabodetabek_no_keg",
			"label"		=> "No Kegiatan",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "sppd_jabodetabek_judul",
			"label"		=> "Judul Kegiatan",
			"rules"		=> "max_length[255]"
		),
		array(
			"field"		=> "sppd_jabodetabek_angkutan",
			"label"		=> "Alat Angkutan yang dipergunakan",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "sppd_jabodetabek_tempat_berangkat",
			"label"		=> "Tempat Berangkat",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "sppd_jabodetabek_instansi_tujuan",
			"label"		=> "Instansi Tujuan",
			"rules"		=> "max_length[255]"
		),
		array(
			"field"		=> "sppd_jabodetabek_tanggal_berangkat",
			"label"		=> "Tanggal Berangkat",
			"rules"		=> ""
		),
		array(
			"field"		=> "sppd_jabodetabek_hari",
			"label"		=> "Hari",
			"rules"		=> "max_length[15]"
		),
		array(
			"field"		=> "sppd_jabodetabek_jam_berangkat",
			"label"		=> "Jam Berangkat",
			"rules"		=> ""
		),
		array(
			"field"		=> "sppd_jabodetabek_pengemudi",
			"label"		=> "Nama Pengemudi Nomor Kendaraan",
			"rules"		=> "max_length[20]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	public function find_all($user="",$tanggal="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama as display_name,nama,kegiatan.judul as judul_kegiatan,
			GROUP_CONCAT(distinct(u.display_name) SEPARATOR "<br/>-") pengikut');
		}
		if($user!=""){
			$this->db->where('users.display_name like "%'.$user.'%"');
		}
		 
		if($tanggal!=""){
			$this->db->where('tanggal_berangkat',$tanggal);
		} 
		 
		 
		$this->db->join('pegawai', 'sppd_jabodetabek.pegawai = pegawai.nip', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd_jabodetabek.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		$this->db->join('kegiatan', 'sppd_jabodetabek.no_keg = kegiatan.kode', 'left'); 
		$this->db->join('sppd_pengikut', 'sppd_jabodetabek.id = sppd_pengikut.kode_sppd', 'left');
		$this->db->join('sppd_pengikut s', 'sppd_jabodetabek.id = s.kode_sppd', 'left');
		$this->db->join('users u', 's.id_user = u.id', 'left');
		$this->db->group_by('users.display_name,sppd_jabodetabek.id');
		$this->db->order_by('tanggal_berangkat',"Desc");
		return parent::find_all();

	}
	public function find_search($user="",$bulan = "",$tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,pegawai.nama as display_name,pejabat_pemberi_perintah.nama,kegiatan.judul as judul_kegiatan,
			GROUP_CONCAT(distinct(u.nama) SEPARATOR "<br/>-") pengikut');
		}
		if($user!=""){
			$this->db->where('(bf_pegawai.nama like "%'.$user.'%" or bf_pegawai.nama like "%'.$user.'%")');
		}
		 
		if($bulan!=""){
			$this->db->where('tanggal_berangkat like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		 
		 
		$this->db->join('pegawai', 'sppd_jabodetabek.pegawai = pegawai.nip', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd_jabodetabek.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		$this->db->join('kegiatan', 'sppd_jabodetabek.no_keg = kegiatan.kode', 'left'); 
		$this->db->join('sppd_pengikut', 'sppd_jabodetabek.id = sppd_pengikut.kode_sppd', 'left');
		$this->db->join('sppd_pengikut s', 'sppd_jabodetabek.id = s.kode_sppd', 'left');
		$this->db->join('pegawai u', 's.id_user = u.no_absen', 'left');
		$this->db->group_by('pegawai.nama,sppd_jabodetabek.id');
		$this->db->order_by('tanggal_berangkat',"Desc");
		return parent::find_all();

	}
	public function count_all($user="",$tanggal="")
	{
		 
		$this->select("count(distinct(bf_sppd_jabodetabek.id))");
		 
		if($user!=""){
			$this->db->where('users.display_name like "%'.$user.'%"');
		}
		 
		 
		if($tanggal!=""){
			$this->db->where('tanggal_berangkat',$tanggal);
		} 
		 
		$this->db->join('users', 'sppd_jabodetabek.pegawai = users.id', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd_jabodetabek.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		$this->db->join('kegiatan', 'sppd_jabodetabek.no_keg = kegiatan.kode', 'left'); 
		$this->db->join('sppd_pengikut', 'sppd_jabodetabek.id = sppd_pengikut.kode_sppd', 'left');
		$this->db->join('users u', 'sppd_pengikut.id_user = u.id', 'left');
		$this->db->group_by('sppd_jabodetabek.id');
		return parent::count_all();

	}
	public function find_detil($id)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,bf_pegawai.nama as display_name,pegawai.nip as nippegawai,pejabat_pemberi_perintah.nama,nama_pejabat,pejabat_pemberi_perintah.nip as nippejabat');
		}
		 
		$this->db->join('pegawai', 'sppd_jabodetabek.pegawai = pegawai.nip', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd_jabodetabek.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		return parent::find($id);

	}
	public function find_rekap($bulan="",$tahun="",$nip="",$nama="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,nama,tanggal_berangkat,nip');
		}
		 
		$this->db->where('tanggal_berangkat like "%-'.$bulan.'-%"');
	 
		$this->db->where('tanggal_berangkat like "%'.$tahun.'-%"');
		 
		if($nip!=""){
			$this->db->where('sppd_jabodetabek.pegawai',$nip);
		}
		if($nama!=""){
			$this->db->where('nama like "%'.$nama.'%"');
		}
		 
		$this->db->where('status_atasan',1);
		 
		$this->db->join('pegawai', 'sppd_jabodetabek.pegawai = pegawai.nip', 'left'); 
		
		return parent::find_all();

	} 
}
