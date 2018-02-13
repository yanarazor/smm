<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_surat_izin extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'surat_izin';

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
		'user' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
			'null' => FALSE,
		),
		'nip' => array(
			'type' => 'VARCHAR',
			'constraint' => 20,
			'null' => FALSE,
		),
		'izin' => array(
			'type' => 'VARCHAR',
			'constraint' => 2,
			'null' => FALSE,
		),
		'lama' => array(
			'type' => 'VARCHAR',
			'constraint' => 20,
			'null' => FALSE,
		),
		'satuan' => array(
			'type' => 'VARCHAR',
			'constraint' => 50,
			'null' => FALSE,
		),
		'hari' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'tanggal' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'alasan' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'status_atasan' => array(
			'type' => 'BOOL',
			'null' => FALSE,
		),
		'tanggal_dibuat' => array(
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