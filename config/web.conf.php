<?php

// Define API endpoints
define('API', 'http://localhost/api/');

// Define dynamic token
$tokenStr = file_get_contents(__DIR__ . '/token_cached.txt');
$tokens   = explode(';', $tokenStr);
foreach ($tokens as $token) {
    $tokenParts = explode('|', $token);
    if ($tokenParts[0] == 'web') {
        define('TOKEN', $tokenParts[1]);
        break;
    }
}

// Define environment constants
define('ENV', 'test');

// Constants for API
define('MIBO_CONNECTION', [
    'dns'      => 'mysql:host=localhost;dbname=mibo',
    'username' => 'admin',
    'password' => 'admin'
]);

define('TOKEN_CACHED_FILE', __DIR__ . '/token_cached.txt');
