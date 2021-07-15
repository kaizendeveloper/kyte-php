<?php

$Application = [
	'name' => 'Application',
	'struct' => [
		'name'		=> [
			'type'		=> 's',
			'required'	=> true,
			'size'		=> 255,
			'date'		=> false,
		],

		'category'		=> [
			'type'		=> 's',
			'required'	=> true,
			'size'		=> 255,
			'date'		=> false,
		],

		'domain'		=> [
			'type'		=> 's',
			'required'	=> true,
			'size'		=> 255,
			'date'		=> false,
		],

		'active'	=> [
			'type'		=> 'i',
			'required'	=> false,
			'size'		=> 1,
			'unsigned'	=> true,
			'default'	=> 0,
			'date'		=> false,
		],

		'verified'	=> [
			'type'		=> 'i',
			'required'	=> false,
			'size'		=> 1,
			'unsigned'	=> true,
			'default'	=> 0,
			'date'		=> false,
		],

		// database field

		'db_name'		=> [
			'type'		=> 's',
			'required'	=> true,
			'size'		=> 255,
			'date'		=> false,
		],

		'db_encoding'	=> [
			'type'		=> 's',
			'required'	=> true,
			'size'		=> 255,
			'date'		=> false,
		],

		'db_host'	=> [
			'type'		=> 's',
			'required'	=> false,
			'size'		=> 255,
			'date'		=> false,
			'protected'	=> true,
		],

		'db_username'	=> [
			'type'		=> 's',
			'required'	=> false,
			'size'		=> 255,
			'date'		=> false,
			'protected'	=> true,
		],

		'db_password'	=> [
			'type'		=> 's',
			'required'	=> false,
			'size'		=> 255,
			'date'		=> false,
			'protected'	=> true,
		],

		// framework attributes

		'kyte_account'	=> [
			'type'		=> 'i',
			'required'	=> true,
			'size'		=> 11,
			'unsigned'	=> true,
			'date'		=> false,
		],

		// audit attributes

		'date_created'		=> [
			'type'		=> 'i',
			'required'	=> false,
			'date'		=> true,
		],

		'date_modified'		=> [
			'type'		=> 'i',
			'required'	=> false,
			'date'		=> true,
		],

		'date_deleted'		=> [
			'type'		=> 'i',
			'required'	=> false,
			'date'		=> true,
		],

		'deleted'	=> [
			'type'		=> 'i',
			'required'	=> false,
			'size'		=> 1,
			'unsigned'	=> true,
			'default'	=> 0,
			'date'		=> false,
		],
	],
];

?>