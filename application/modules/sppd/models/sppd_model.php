<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sppd_model extends BF_Model {

	protected $table_name	= "sppd";
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
			"field"		=> "sppd_pejabat",
			"label"		=> "Pejabat Berwenang Memberi Perintah",
			"rules"		=> "required|max_length[10]"
		),
		array(
			"field"		=> "sppd_pegawai",
			"label"		=> "Pegawai",
			"rules"		=> "required|max_length[20]"
		),
		array(
			"field"		=> "sppd_maksud",
			"label"		=> "Maksud Perjalanan Dinas",
			"rules"		=> "max_length[255]"
		),
		array(
			"field"		=> "sppd_anggaran",
			"label"		=> "Anggaran",
			"rules"		=> "max_length[20]"
		),
		array(
			"field"		=> "sppd_no_keg",
			"label"		=> "No Kegiatan",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "sppd_judul",
			"label"		=> "Judul Kegiatan",
			"rules"		=> "max_length[255]"
		),
		array(
			"field"		=> "sppd_angkutan",
			"label"		=> "Alat Angkutan yang dipergunakan",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "sppd_tempat_berangkat",
			"label"		=> "Tempat Berangkat",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "sppd_instansi_tujuan",
			"label"		=> "Instansi Tujuan",
			"rules"		=> "max_length[255]"
		),
		array(
			"field"		=> "sppd_tanggal_berangkat",
			"label"		=> "Tanggal Berangkat",
			"rules"		=> ""
		),
		array(
			"field"		=> "sppd_hari",
			"label"		=> "Hari",
			"rules"		=> "max_length[15]"
		),
		array(
			"field"		=> "sppd_jam_berangkat",
			"label"		=> "Jam Berangkat",
			"rules"		=> ""
		),
		array(
			"field"		=> "sppd_pengemudi",
			"label"		=> "Nama Pengemudi Nomor Kendaraan",
			"rules"		=> "max_length[20]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= true;

	//--------------------------------------------------------------------
	public function find_all($user="",$tanggal="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama,kegiatan.judul as judul_kegiatan');
		}
		if($user!=""){
			$this->db->where('users.display_name like "%'.$user.'%"');
		}
		 
		if($tanggal!=""){
			$this->db->where('tanggal_berangkat',$tanggal);
		} 
		 
		 
		$this->db->join('users', 'sppd.pegawai = users.id', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		$this->db->join('kegiatan', 'sppd.no_keg = kegiatan.kode', 'left'); 
		$this->db->group_by('users.display_name,sppd.id');
		$this->db->order_by('tanggal_berangkat',"Desc");
		return parent::find_all();

	}
	public function find_search($user="",$bulan = "",$tahun = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama,kegiatan.judul as judul_kegiatan,prov');
		}
		if($user!=""){
			$this->db->where('(bf_users.display_name like "%'.$user.'%" or bf_users.display_name like "%'.$user.'%")');
		}
		 
		if($bulan!=""){
			$this->db->where('tanggal_berangkat like "%-'.$bulan.'-%"');
		} 
		if($tahun != ""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		 
		 
		$this->db->join('users', 'sppd.pegawai = users.id', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		$this->db->join('kegiatan', 'sppd.no_keg = kegiatan.kode', 'left'); 
		$this->db->join('propinsi', 'propinsi.id = sppd.provinsi', 'left'); 
		$this->db->group_by('users.display_name,sppd.id');
		$this->db->order_by('tanggal_berangkat',"Desc");
		return parent::find_all();

	}
	public function count_all($user="",$tanggal="")
	{
		 
		$this->select("count(distinct(bf_sppd.id))");
		 
		if($user!=""){
			$this->db->where('users.display_name like "%'.$user.'%"');
		}
		 
		 
		if($tanggal!=""){
			$this->db->where('tanggal_berangkat',$tanggal);
		} 
		 
		$this->db->join('users', 'sppd.pegawai = users.id', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		$this->db->join('kegiatan', 'sppd.no_keg = kegiatan.kode', 'left'); 
		$this->db->group_by('sppd.id');
		return parent::count_all();

	}
	public function find_detil($id)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.display_name,nama,nama_pejabat,pejabat_pemberi_perintah.nip as nippejabat,prov,atasan as pj');
		}
		 
		$this->db->join('users', 'sppd.pegawai = users.id', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		$this->db->join('propinsi', 'propinsi.id = sppd.provinsi', 'left'); 
		return parent::find($id);

	}
	public function find_detilspd($id)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,users.id_bidang as bidang,pejabat_pemberi_perintah.nama as namapemberi,prov,
			kegiatan.judul as judul_kegiatan,kegiatan.pj as pj,
			pejabat_pemberi_perintah.nip as ppk,users.email as emailuser,
			nama_pejabat,pejabat_pemberi_perintah.nip as nippejabat,pegawai.nama as namapegawai,pegawai.nip as nippegawai,
			pangkat.golongan as gol,pangkat.pangkat as pangkat,jabatan_fu,jabatan_ft,pegawai.jabatan as jabatan,nama_jabatan,
			jabatan_ft,bidang.bidang as nama_bidang,pejabat_pemberi_perintah.nama as namajabatan,pj');
		}
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->join('users', 'pegawai.no_absen = users.nip', 'left'); 
		$this->db->join('pejabat_pemberi_perintah', 'sppd.pejabat = pejabat_pemberi_perintah.id', 'left'); 
		$this->db->join('pangkat', 'pangkat.kode_pangkat = pegawai.golongan', 'left'); 
		$this->db->join('jabatan', 'jabatan.id = pegawai.jabatan', 'left'); 
		$this->db->join('bidang', 'bidang.id = users.id_bidang', 'left'); 
		$this->db->join('kegiatan', 'kegiatan.kode = sppd.no_keg', 'left'); 
		$this->db->join('propinsi', 'propinsi.id = sppd.provinsi', 'left'); 
		$this->db->order_by("kegiatan.id","desc");
		return parent::find($id);

	}
	public function find_rekap($bulan="",$tahun="",$nip="",$nama="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name,tanggal_berangkat,u.nip');
		}
		 
			$this->db->where('tanggal_berangkat like "%-'.$bulan.'-%"');
		 
			$this->db->where('tanggal_berangkat like "%'.$tahun.'-%"');
		 
		if($nip!=""){
			$this->db->where('sppd.nip',$nip);
		}
		if($nama!=""){
			$this->db->where('display_name like "%'.$nama.'%"');
		}
		 
		$this->db->where('status_atasan',1);
		 
		$this->db->join('users u', 'sppd.pegawai = u.id', 'left'); 
		
		return parent::find_all();

	} 
	public function rekap_provinsi($tahun="",$anggaran = "")
	{
		if (empty($this->selects))
		{
			$this->select('prov,provinsi,propinsi.id,keterangan,count(*) as jumlah');
		}
		if($tahun!=""){
		//$this->db->where('tanggal_berangkat like "%-'.$bulan.'-%"');
		$this->db->where('tanggal_berangkat like "%'.$tahun.'-%"');
		}
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		
		$this->db->where('status_atasan',1);
		$this->db->join('propinsi', 'propinsi.id = sppd.provinsi', 'left'); 
		$this->db->group_by('provinsi');
		$this->db->where('status_atasan',1);
		return parent::find_all();

	} 
	public function rekap_laporan($tahun="",$anggaran = "")
	{
		if (empty($this->selects))
		{
			$this->select('pegawai,count(*) as jumlah');
		}
		if($tahun!=""){
			//$this->db->where('tanggal_berangkat like "%-'.$bulan.'-%"');
			$this->db->where('tanggal_berangkat like "%'.$tahun.'-%"');
		}
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		$this->db->where('status_atasan',1);
		$this->db->where('nomor != ""');
		$this->db->where('laporan_perjalanan_text is null');
		$this->db->group_by('pegawai');
		return parent::find_all();

	} 
	public function count_tahun($tahun = "",$anggaran = "")
	{ 
		$this->select("count(distinct(bf_sppd.id))");	 
		if($tahun!=""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->where('status_atasan',1);
		return parent::count_all();
	}
	public function count_tahun_pegawai($tahun = "",$pegawai = "")
	{ 
		$this->select("count(distinct(bf_sppd.id))");	 
		if($tahun!=""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->where('status_atasan',1);
		$this->db->where('pegawai.no_absen',$pegawai);
		return parent::count_all();
	}
	public function count_blmspj($tahun = "",$anggaran = "")
	{ 
		$this->select("count(distinct(bf_sppd.id))");	 
		if($tahun!=""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		$this->db->where('(status_spj = 0 or status_spj is null)');
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->where('status_atasan',1);
		return parent::count_all();
	}
	public function count_blmspj_pegawai($tahun = "",$pegawai = "")
	{ 
		$this->select("count(distinct(bf_sppd.id))");	 
		if($tahun!=""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		$this->db->where('(status_spj = 0 or status_spj is null)');
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->where('status_atasan',1);
		$this->db->where('pegawai.no_absen',$pegawai);
		return parent::count_all();
	}
	public function count_blmlaporan($tahun = "",$anggaran = "")
	{ 
		$this->select("count(distinct(bf_sppd.id))");	 
		if($tahun!=""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		$this->db->where('(laporan_perjalanan_text = "" or laporan_perjalanan_text is null)');
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->where('status_atasan',1);
		
		return parent::count_all();
	}
	public function count_blmlaporan_pegawai($tahun = "",$pegawai = "")
	{ 
		$this->select("count(distinct(bf_sppd.id))");	 
		if($tahun!=""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		$this->db->where('(laporan_perjalanan_text = "" or laporan_perjalanan_text is null)');
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->where('status_atasan',1);
		$this->db->where('pegawai.no_absen',$pegawai);
		return parent::count_all();
	}
	public function rekap_tahun($tahun="",$anggaran = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.pegawai,provinsi,nama,count(*) as jumlah,sum(transport) as jml_transport');
		}
		if($tahun!=""){
		//$this->db->where('tanggal_berangkat like "%-'.$bulan.'-%"');
		$this->db->where('tanggal_berangkat like "%'.$tahun.'-%"');
		}
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		$this->db->where('status_atasan',1);
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->group_by('pegawai,provinsi');
		
		return parent::find_all();

	} 
	public function dispegawai($tahun="",$anggaran = "")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.pegawai,nama');
		}
		if($tahun!=""){
		//$this->db->where('tanggal_berangkat like "%-'.$bulan.'-%"');
		$this->db->where('tanggal_berangkat like "%'.$tahun.'-%"');
		}
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		$this->db->where('status_atasan',1);
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		$this->db->group_by('pegawai');
		
		return parent::find_all();

	} 
	public function sumrealisasi_tahun($tahun = "",$anggaran = "")
	{ 
		$this->select("(sum(transport) + sum(uang_harian) + sum(biaya_penginapan) + sum(representasi) + sum(lain_lain) + sum(real_transport) + sum(real_penginapan)) as jmlrealisasi");	 
		if($tahun!=""){
			$this->db->where('tanggal_berangkat like "'.$tahun.'-%"');
		} 
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		$this->db->where('status_atasan',1);
		$this->db->join('pegawai', 'pegawai.no_absen = sppd.pegawai', 'left'); 
		return parent::find_all();
	}
	public function perjalananperbulan($tahun = "",$anggaran = "")
	{
		if (empty($this->selects))
		{
			$this->select('YEAR(tanggal_berangkat) as year,MONTH(tanggal_berangkat) as month,count(*) as jumlah');
		}
		
		if($tahun != ""){
			$this->db->where('YEAR(tanggal_berangkat)',$tahun);
		}
		if($anggaran != ""){
			$this->db->where('anggaran',$anggaran);
		} 
		$this->db->where('status_atasan',1);
		$this->db->group_by("YEAR(tanggal_berangkat)");
		$this->db->group_by("MONTH(tanggal_berangkat)");
		return parent::find_all();
	} 
	public function perjalananperbulan_pegawai($tahun = "",$pegawai = "")
	{
		if (empty($this->selects))
		{
			$this->select('YEAR(tanggal_berangkat) as year,MONTH(tanggal_berangkat) as month,count(*) as jumlah');
		}
		
		if($tahun != ""){
			$this->db->where('YEAR(tanggal_berangkat)',$tahun);
		}
		$this->db->where('status_atasan',1);
		$this->db->group_by("YEAR(tanggal_berangkat)");
		$this->db->group_by("MONTH(tanggal_berangkat)");
		$this->db->join('pegawai', 'pegawai.nip = sppd_jabodetabek.pegawai', 'left'); 
		$this->db->where('pegawai.no_absen',$pegawai);
		return parent::find_all();
	} 
	public function find_paguterpakai($kode)
	{
		if (empty($this->selects))
		{
			$this->select('(sum(transport) + sum(uang_harian) + sum(biaya_penginapan) + sum(lain_lain) + sum(real_transport) + sum(real_penginapan)) as jumlahterpakai');
		}
		if($kode != ""){
			$this->db->where('no_keg',$kode);
		}
		$this->db->where('status_atasan',1);
		$this->db->group_by("no_keg");
		return parent::find_all();
	}
}
