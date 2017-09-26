<?php

// Define API endpoints
define('API', 'http://localhost/api/');

// Define dynamic token
$token = \FS\Web\Service\TokenService::fetchToken('web');
define('TOKEN', $token);

// Define environment constants
define('ENV', 'test');

// Constants for API
define('MIBO_CONNECTION', [
    'dns'      => 'mysql:host=localhost;dbname=mibo',
    'username' => 'admin',
    'password' => 'admin'
]);

define('TOKEN_CACHED_FILE', __DIR__ . '/token_cached.txt');
