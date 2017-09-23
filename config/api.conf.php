<?php

// Database configuration
define('MIBO_CONNECTION', [
    'dns'       => 'mysql:host=localhost;dbname=mibo',
    'username'  => 'admin',
    'password'  => 'admin'
]);

define('TOKEN_CACHED_FILE', __DIR__ . '/token_cached.txt');
