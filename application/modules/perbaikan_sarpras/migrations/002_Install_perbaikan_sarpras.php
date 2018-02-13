<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_perbaikan_sarpras extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'perbaikan_sarpras';

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
			'constraint' => 10,
			'null' => FALSE,
		),
		'jenis' => array(
			'type' => 'VARCHAR',
			'constraint' => 1,
			'null' => FALSE,
		),
		'nama_sarpras' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'null' => FALSE,
		),
		'nomor_inventaris' => array(
			'type' => 'VARCHAR',
			'constraint' => 20,
			'null' => FALSE,
		),
		'keluhan' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'user' => array(
			'type' => 'VARCHAR',
			'constraint' => 3,
			'null' => FALSE,
		),
		'tanggal_kirim' => array(
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