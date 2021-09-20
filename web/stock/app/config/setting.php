<?php
return array(
	'dbDSN' => array (
		'driver' => 'mysql',
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'root',
		'database' => 'dbomni'
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