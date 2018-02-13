<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_rencana_tahunan extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'rencana_tahunan';

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
		'tahun' => array(
			'type' => 'VARCHAR',
			'constraint' => 4,
			'null' => FALSE,
		),
		'dari_tanggal' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'sampai_tanggal' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'id_bidang' => array(
			'type' => 'VARCHAR',
			'constraint' => 4,
			'null' => FALSE,
		),
		'status_wm' => array(
			'type' => 'BOOL',
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