<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_ketidaksesuaian_model extends BF_Model {

	protected $table_name	= "laporan_ketidaksesuaian";
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
			"field"		=> "laporan_ketidaksesuaian_nomor",
			"label"		=> "Nomor",
			"rules"		=> "required|unique[bf_laporan_ketidaksesuaian.nomor,bf_laporan_ketidaksesuaian.id]|max_length[30]"
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_kegiatan",
			"label"		=> "Kegiatan",
			"rules"		=> "required|max_length[50]"
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_penanggung_jawab",
			"label"		=> "Penanggung Jawab",
			"rules"		=> "max_length[10]"
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_tanggal_penemuan",
			"label"		=> "Tanggal Penemuan",
			"rules"		=> ""
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_bidang_bagian",
			"label"		=> "Bidang",
			"rules"		=> "max_length[20]"
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_ketidaksesuaian",
			"label"		=> "Ketidaksesuaian",
			"rules"		=> ""
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_seharusnya",
			"label"		=> "Seharusnya",
			"rules"		=> ""
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_status_evaluasi_swm",
			"label"		=> "Status SWM",
			"rules"		=> ""
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_tgl_persetujuan_swm",
			"label"		=> "Tgl Persetujuan SWM",
			"rules"		=> ""
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_tgl_persetujuan_kabid",
			"label"		=> "Tgl Persetujuan Kabid",
			"rules"		=> ""
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_keterangan",
			"label"		=> "Keterangan",
			"rules"		=> ""
		),
		array(
			"field"		=> "laporan_ketidaksesuaian_tgl_close",
			"label"		=> "Tgl Close",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= TRUE;

	//--------------------------------------------------------------------
	public function find_all($penanggung_jawab="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,u.display_name as user_pembuat,us.display_name as user_penanggung_jawab,tindakan,bidang');
		}
		if($penanggung_jawab!=""){
			$this->db->where('penanggung_jawab',$penanggung_jawab);
		}
		$this->db->join('users u', 'laporan_ketidaksesuaian.pengaju = u.id', 'left'); 
		$this->db->join('users us', 'laporan_ketidaksesuaian.penanggung_jawab = us.id', 'left'); 
		$this->db->join('tindakan', 'laporan_ketidaksesuaian.keputusan = tindakan.id', 'left'); 
		$this->db->join('bidang', 'laporan_ketidaksesuaian.bidang_bagian = bidang.id', 'left'); 
		  
		return parent::find_all();

	} 
	public function GetGroupByTindakan($year="")
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name .'.*,tindakan,count(*) as jumlah');
		}
		$this->db->join('tindakan', 'laporan_ketidaksesuaian.keputusan = tindakan.id', 'left'); 
		$this->db->group_by('keputusan'); 
		//$this->db->where('status_active',"1");
		return parent::find_all();

	}

}
