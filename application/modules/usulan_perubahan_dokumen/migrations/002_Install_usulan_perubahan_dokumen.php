<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_usulan_perubahan_dokumen extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'usulan_perubahan_dokumen';

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
		'pengusul' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'tanggal_permintaan' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'kode_dokumen' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'judul' => array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			'null' => FALSE,
		),
		'nomor' => array(
			'type' => 'VARCHAR',
			'constraint' => 50,
			'null' => FALSE,
		),
		'revisi' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'bagian_diubah' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'manfaat_perubahan' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'catatan_pemeriksa' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'tanggal_diusulkan' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'pemeriksa' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'tanggal_diperiksa' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'penyetuju' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'tanggal_persetujuan' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'filename' => array(
			'type' => 'TEXT',
			'null' => FALSE,
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