<?php
return [ 
	'controllers' => [ 
		'value' => [ 
			'defaultNamespace' => '\Itachsoft\Notifications',
			'namespaces' => [
				'\Itachsoft\Notifications' => 'rest'
			],
			'restIntegration' => [ 
				'enabled' => true 
			] 
		], 
		'readonly' => true,
	],
];