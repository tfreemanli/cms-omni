<?php
return array(
	'dbDSN' => array (
		'driver' => 'mysql',
		'host' => 'localhost',
		'login' => 'omnitech',
		'password' => 'kingkong04121976',
		'database' => 'omnitech_co_nz_-_dbomni'
	),
	
	'responseCharset' => 'utf-8',
	'databaseCharset' => 'utf8',
	
	'controllerAccessor' => 'option',
	'defaultController' => 'index',
	'actionAccessor' => 'task',
	'defaultAction' => 'index',
	'urlLowerChar' => true,
	
	//'urlMode' => URL_PATHINFO,	
	'defaultTimezone' => 'Pacific/Auckland',
);
?>