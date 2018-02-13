<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_laporan_ketidaksesuaian extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'laporan_ketidaksesuaian';

	/**
	 * The table's fields
	 *
	 * @var Array
	 */
	private $fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'auto_increment' => TRUE,
		),
		'nomor' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'kegiatan' => array(
			'type' => 'VARCHAR',
			'constraint' => 50,
			'null' => FALSE,
		),
		'penanggung_jawab' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'tanggal_penemuan' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'bidang_bagian' => array(
			'type' => 'VARCHAR',
			'constraint' => 20,
			'null' => FALSE,
		),
		'ketidaksesuaian' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'seharusnya' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'status_evaluasi_swm' => array(
			'type' => 'BOOL',
			'null' => FALSE,
		),
		'tgl_persetujuan_swm' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'tgl_persetujuan_kabid' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'keterangan' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'tgl_close' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
	);

	/**
	 * Install this migration
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	//--------------------------------------------------------------------

	/**
	 * Uninstall this migration
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}

	//--------------------------------------------------------------------

}