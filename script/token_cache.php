<?php

// Check server api
if (php_sapi_name() != 'cli') {
    die('Must be run via cli');
}

require __DIR__ . '/../class/Common/autoload.php';
require __DIR__ . '/../config/api.conf.php';

// Check connection is working before proceeding (DNS might not be fully working on @reboot)
if (!($validation = \FS\Common\IO::required('MIBO_CONNECTION', ['dns', 'username', 'password'], true))['valid']) {
    die('Connection information for {MIBO_CONNECTION} is not setup correctly' . PHP_EOL . $validation['message']);
}

$pdo     = null;
$counter = 0;

while ($counter < 10) {
    try {
        $pdo = \FS\Common\IO::getPDOConnection(MIBO_CONNECTION);

        $counter = 10;
    } catch (Exception $e) {
        $pdo = null;
        sleep(30);
        $counter++;
    }
}

if ($pdo === null) {
    die('Error: Cannot connect to database');
}

try {
    $cachedTokens = '';

    $sql = 'SELECT `name`, `key`, `read`, `write`, `allow`, `expire` FROM `token`';

    if (($stmt = $pdo->query($sql)) === false) {
        throw new \FS\Common\Exception\PDOQueryException('PDO query failed');
    }

    while ($row = $stmt->fetch()) {
        $cachedTokens .= $row['name'] . '|' . $row['key'] . '|' . $row['read'] . '|' . $row['write'] . '|' . $row['allow'] . '|' . (isset($row['expire']) ? $row['expire'] : '') . ';';
    }

    $cachedTokens = substr($cachedTokens, 0, -1);

    $wroteChars = file_put_contents(TOKEN_CACHED_FILE, $cachedTokens, LOCK_EX);

    if ($wroteChars != strlen($cachedTokens)) {
        throw new \FS\Common\Exception\FileWriteException('Failed to cache tokens');
    }
} catch (\Exception $e) {
    die($e->getMessage());
}

exit('Tokens have been cached successfully.');
