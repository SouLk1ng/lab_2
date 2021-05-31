<?php
$methods = [
	'submitAmbassador' => [
		'params' => [
			[
				'name' => 'firstname',
				'source' => 'p',
				'required' => true,
				'default' => ''
				
			],
			[
				'name' => 'secondname',
				'source' => 'p',
				'required' => true,
				'default' => ''
			],
			[
				'name' => 'position',
				'source' => 'p',
				'required' => false,
				'default' => ''
			],
			[
				'name' => 'phone',
				'source' => 'p',
				'required' => true,
				'default' => ''
			],
			[
				'name' => 'email',
				'source' => 'p',
				'required' => true,
				'default' => ''
			],
			[
				'name' => 'IBAN',
				'source' => 'p',
				'required' => false,
				'default' => ''
			]

		]
	]
];