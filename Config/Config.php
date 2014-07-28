<?php
return array(
	'defaultController' => 'index',
	'defaultAction' => 'index',
    'acl_enabled' => true, //the default is false
	'db' => array(
		'type' => 'pdo', //pdo or mysqli
		'host' => 'localhost',
		'user' => 'root',
		'password' => 'root',
		'port' => '',
		'charset' => '',
		'database' => 'framework-test',
	),
	'mail' => array(
		'to' => 'info@woutschoovaerts.be',
		'headers' => array(
				'mime' 			=> 'MIME-Version: 1.0',
				'content-type'  => 'Content-type: text/html; charset=iso-8859-1',
		)
		
	),
);