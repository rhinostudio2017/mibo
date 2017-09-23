<?php

// Define dynamic token
$token = file_get_contents(__DIR__  . '/token_cached.txt');
define('TOKEN', explode('|', $token)[0]);

// Define environment constants
define('ENV', 'test');

// Constants for API
define('MIBO_CONNECTION', [
    'dns'       => 'mysql:host=localhost;dbname=mibo',
    'username'  => 'admin',
    'password'  => 'admin'
]);

define('TOKEN_CACHED_FILE', __DIR__ . '/token_cached.txt');
