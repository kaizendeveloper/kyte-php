<?php

$APIKey = [
	'name' => 'APIKey',
	'struct' => [
		'identifier'		=> [
			'type'		=> 's',
			'required'	=> true,
			'size'		=> 255,
			'date'		=> false,
		],

		'public_key'	=> [
			'type'		=> 's',
			'required'	=> true,
			'size'		=> 255,
			'date'		=> false,
		],

		'secret_key'	=> [
			'type'		=> 's',
			'required'	=> true,
			'size'		=> 255,
			'date'		=> false,
			'protected'	=> true,
		],

		'epoch'		=> [
			'type'		=> 'i',
			'required'	=> true,
			'date'		=> true,
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

		'created_by'		=> [
			'type'		=> 'i',
			'required'	=> false,
			'date'		=> false,
		],

		'date_created'		=> [
			'type'		=> 'i',
			'required'	=> false,
			'date'		=> true,
		],

		'modified_by'		=> [
			'type'		=> 'i',
			'required'	=> false,
			'date'		=> false,
		],

		'date_modified'		=> [
			'type'		=> 'i',
			'required'	=> false,
			'date'		=> true,
		],

		'deleted_by'		=> [
			'type'		=> 'i',
			'required'	=> false,
			'date'		=> false,
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
