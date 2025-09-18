<?php
return [
	//'paths' => ['api/*'],
	'paths' => ['api/*', 'sanctum/csrf-cookie'],
	'allowed_methods' => ['*'],
	'allowed_origins' => ['http://localhost:8000'],
	'allowed_headers' => ['*'],
];
