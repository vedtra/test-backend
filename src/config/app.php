<?php

return [


	'name' => env('APP_NAME', 'Lumen_App'),

	'env' => env('APP_ENV', 'production'),

	'debug' => (bool) env('APP_DEBUG', false),

	'url' => env('APP_URL', 'http://localhost'),

	'timezone' => 'UTC',

	'locale' => env('APP_LOCALE', 'id'),

	'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

	'key' => env('APP_KEY'),

	'cipher' => 'AES-256-CBC',

	'firebase'	=> [
		'database'	=> 'lumen_app'
	]

];
