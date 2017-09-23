<?php

// Define dynamic token
$token = file_get_contents(__DIR__  . '/token_cached.txt');
define('token', 'example');

// Define environment constants
define('ENVIRONMENT', 'example');
define('ENVIRONMENT_COLOUR', 'example');
