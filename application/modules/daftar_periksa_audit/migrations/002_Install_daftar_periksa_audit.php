<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_daftar_periksa_audit extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'daftar_periksa_audit';

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
		'id_jadwal_audit' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'deskripsi' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'klausul_iso' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'bukti_obyektif' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'kesesuaian' => array(
			'type' => 'BOOL',
			'null' => FALSE,
		),
		'id_bidang' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'tanggal' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'auditor' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
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