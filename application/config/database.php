<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = '';
$db['default']['database'] = 'semar';
$db['default']['port']     = '3306';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = 'bf_';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = TRUE;

$db['sas_db']['hostname'] = '192.168.61.26';
$db['sas_db']['username'] = 'root';
$db['sas_db']['password'] = '';
$db['sas_db']['database'] = 'sqldb18';
$db['sas_db']['port']     = '3339';

$db['sas_db']['dbdriver'] = 'mysqli';
$db['sas_db']['dbprefix'] = '';
$db['sas_db']['pconnect'] = TRUE;
$db['sas_db']['db_debug'] = TRUE;
$db['sas_db']['cache_on'] = FALSE;
$db['sas_db']['cachedir'] = '';
$db['sas_db']['char_set'] = 'utf8';
$db['sas_db']['dbcollat'] = 'utf8_general_ci';
$db['sas_db']['swap_pre'] = '';
$db['sas_db']['autoinit'] = TRUE;
$db['sas_db']['stricton'] = TRUE;

/* End of file database.php */
/* Location: ./application/config/database.php */