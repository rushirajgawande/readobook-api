<?php
defined('BASEPATH') OR exit('No direct script access allowed');

switch (ENVIRONMENT) {
	case 'production':
			$active_group = 'production';
		break;
	case 'testing':
			$active_group = 'testing';
		break;
	default:
			$active_group = 'development';
		break;
}
$query_builder = TRUE;

$db['development'] = array(
	'dsn'	=> '',
	'hostname' => '103.120.179.40',
	'username' => 'readobook_dev_user',
	'password' => '$s6AZfalR',
	'database' => 'readobook_dev_db',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'port' => '3306',
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['testing'] = array(
	'dsn'	=> '',
	'hostname' => '103.120.179.40',
	'username' => 'readobook_dev_user',
	'password' => '$s6AZfalR',
	'database' => 'readobook_dev_db',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'port' => '3306',
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['production'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'readobook_prod_user',
	'password' => '&4aJkZcIE',
	'database' => 'readobook_prod_db',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'port' => '3306',
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
