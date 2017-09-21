<?php

// Check server api
if (php_sapi_name() != 'cli') {
    die('Must be run via cli');
}

// Check whether $argv is registered
if ((int)ini_get('register_argc_argv') != 1) {
    die('Error: register_argc_argv is not enabled, please check configuration in php.ini');
}

require __DIR__ . '/../class/Common/autoload.php';
require __DIR__ . '/../config/common.php';

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
    $items   = [];
    $message = 'Key(s) has been generated successfully';

    if (count($argv) != 2) {
        die('Error: command format is incorrect. e.g. php path/to/scripts/token_generate.php item-name. '
            . 'If item name is all/All, all the items token strings will be regenerated, otherwise only the token for the specific item name will be regenerated.');
    }

    if (strtolower($argv[1]) == 'all') {
        $sql = 'SELECT `id` FROM `token`';

        if (($stmt = $pdo->query($sql)) === false) {
            throw new \FS\Common\Exception\PDOQueryException('PDO query failed');
        }

        while ($row = $stmt->fetch()) {
            $items[] = $row['id'];
        }
    } else {
        $message .= ' for item {' . $argv[1] . '}';

        $sql    = 'SELECT `id` FROM `token` WHERE `name` = :name';
        $values = ['name' => $argv[1]];

        if (($stmt = $pdo->prepare($sql)) === false) {
            throw new \FS\Common\Exception\PDOCreationException('PDOStatement prepare failed');
        }

        if ($stmt->execute($values) === false) {
            throw new \FS\Common\Exception\PDOExecutionException('PDOStatement execution failed');
        }

        while ($row = $stmt->fetch()) {
            $items[] = $row['id'];
        }

        if (count($items) < 1) {
            throw new \FS\Common\Exception\PDOResultEmptyException('Item with given name {' . $argv[1] . '} does not exist');
        }
    }

    // generate key for items
    $sql = 'UPDATE `token` SET `key` = :key WHERE `id` = :id';

    if (($stmt = $pdo->prepare($sql)) === false) {
        throw new \FS\Common\Exception\PDOCreationException('PDOStatement prepare failed');
    }

    foreach ($items as $item) {
        if ($stmt->execute(['key' => \FS\Common\IO::guid(), 'id' => $item]) === false) {
            throw new \FS\Common\Exception\PDOExecutionException('PDOStatement execution failed when generaing key for item {' . $item . '}');
        }
    }
} catch (\Exception $e) {
    die($e->getMessage());
}

exit($message . '.');
