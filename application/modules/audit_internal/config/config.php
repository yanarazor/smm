<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> 'Your module description',
	'name'		=> 'Audit Internal',
	'version'		=> '0.0.1',
	'author'		=> 'yanarazor',
	'menus'	=> array(
		'audit'	=> 'audit_internal/audit/menu'
	),
);