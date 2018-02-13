<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_absen extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'absen';

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
		'nik' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'nama' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'null' => FALSE,
		),
		'tanggal' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'jam' => array(
			'type' => 'TIME',
			'null' => FALSE,
		),
		'sn_mesin' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'verifikasi' => array(
			'type' => 'VARCHAR',
			'constraint' => 20,
			'null' => FALSE,
		),
		'model' => array(
			'type' => 'VARCHAR',
			'constraint' => 20,
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