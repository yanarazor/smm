<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usulan_perubahan_dokumen_model extends BF_Model {

	protected $table_name	= "usulan_perubahan_dokumen";
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
			"field"		=> "usulan_perubahan_dokumen_pengusul",
			"label"		=> "Pengusul",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_tanggal_permintaan",
			"label"		=> "Tanggal Permintaan",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_kode_dokumen",
			"label"		=> "Dokumen",
			"rules"		=> "required|max_length[10]"
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_judul",
			"label"		=> "Judul Dokumen",
			"rules"		=> "max_length[255]"
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_nomor",
			"label"		=> "Nomor",
			"rules"		=> "max_length[50]"
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_revisi",
			"label"		=> "Revisi",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_bagian_diubah",
			"label"		=> "Bagian Yang Diubah",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_manfaat_perubahan",
			"label"		=> "Manfaat Perubahan",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_catatan_pemeriksa",
			"label"		=> "Catatan Pemeriksa",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_tanggal_diusulkan",
			"label"		=> "Tanggal Diusulkan",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_pemeriksa",
			"label"		=> "Pemeriksa",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_tanggal_diperiksa",
			"label"		=> "Tanggal Diperiksa",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_penyetuju",
			"label"		=> "Penyetuju",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_tanggal_persetujuan",
			"label"		=> "Tanggal Persetujuan",
			"rules"		=> ""
		),
		array(
			"field"		=> "usulan_perubahan_dokumen_filename",
			"label"		=> "File",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= TRUE;

	//--------------------------------------------------------------------
	public function find_all($keyword="",$bidang="",$jenis="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as nama_pengusul,us.display_name as user_pemeriksa,jenis,bidang.bidang as namabidang');
		}
		if($keyword!=""){
			$this->db->where('usulan_perubahan_dokumen.judul like "%'.$keyword.'%"');
		}
		if($bidang!=""){
			$this->db->where('daftar_induk_dokumen.bidang',$bidang);
		}
		if($jenis!=""){
			$this->db->where('jenis_dokumen',$jenis);
		}
		$this->db->join('daftar_induk_dokumen', 'daftar_induk_dokumen.id = usulan_perubahan_dokumen.kode_dokumen', 'left'); 
		$this->db->join('users u', 'usulan_perubahan_dokumen.pengusul = u.id', 'left'); 
		$this->db->join('users us', 'usulan_perubahan_dokumen.pemeriksa = us.id', 'left'); 
		//$this->db->join('users usr', 'daftar_induk_dokumen.pengesah = usr.id', 'left'); 
		$this->db->join('jenis_dokumen', 'daftar_induk_dokumen.jenis_dokumen = jenis_dokumen.id', 'left'); 
		$this->db->join('bidang', 'daftar_induk_dokumen.bidang = bidang.id', 'left'); 
		return parent::find_all();

	}

}
