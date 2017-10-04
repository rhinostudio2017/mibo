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

#region Table structure initialization
// Create table 'resource' if not exists
$sql = "CREATE TABLE IF NOT EXISTS `resource` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(128) NOT NULL DEFAULT '',
            `description` VARCHAR(256) NOT NULL DEFAULT '',
            `poster_link` VARCHAR(64) NOT NULL DEFAULT '',
            `video_link` VARCHAR(128) NOT NULL DEFAULT '',
            `author` VARCHAR(32) NOT NULL DEFAULT '',
            `produce_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `venue` VARCHAR(64) NOT NULL DEFAULT '',
            `views` INT(11) NULL DEFAULT '0',
            `note` VARCHAR(128) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`),
            INDEX `idx_time` (`produce_time`),
            INDEX `idx_views` (`views`),
            UNIQUE INDEX `unique_video_link` (`video_link`),
            FULLTEXT INDEX `ft_name_author_description_venue` (`name`, `author`, `description`, `venue`)
        ) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4";

if ($pdo->exec($sql) === false) {
    die('Error: SQL statement error. Check your sql statement {' . $sql . '}');
}

// Create table 'token' if not exists
$sql = "CREATE TABLE IF NOT EXISTS `token` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL DEFAULT '',
            `key` VARCHAR(36) NOT NULL DEFAULT '',
            `read` TINYINT(1) NOT NULL DEFAULT '0',
            `write` TINYINT(1) NOT NULL DEFAULT '0',
            `allow` VARCHAR(255) NOT NULL DEFAULT '',
            `expire` DATETIME NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `name` (`name`),
            UNIQUE INDEX `key` (`key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4";

if ($pdo->exec($sql) === false) {
    die('Error: SQL statement error. Check your sql statement {' . $sql . '}');
}

// Create table 'user' if not exists
$sql = "CREATE TABLE IF NOT EXISTS `user`(
            `id` INT NOT NULL AUTO_INCREMENT, 
            `username` VARCHAR(64) DEFAULT NULL,
            `password` VARCHAR(64) DEFAULT NULL,
            `email` VARCHAR(64) DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `unique_username` (`username`),
            UNIQUE INDEX `unique_email` (`email`)
        )ENGINE=InnoDB DEFAULT CHARSET 'UTF8MB4'";

if ($pdo->exec($sql) === false) {
    die('Error: SQL statement error. Check your sql statement {' . $sql . '}');
}
#endregion

#region Remove unique index `name` and `key` for defining multiple tokens by same name & key to control multiple permissions
// Drop unique index `name`
$sqlKeyExist = "SELECT COUNT(*)
                FROM information_schema.KEY_COLUMN_USAGE kc
                WHERE kc.TABLE_SCHEMA = DATABASE() AND kc.TABLE_NAME = 'token' AND kc.COLUMN_NAME = 'name'";
$result      = $pdo->query($sqlKeyExist)->fetchColumn();
if ($result) {
    if (false === $pdo->exec("ALTER TABLE `token` DROP INDEX `name`")) {
        die('Error: SQL statement error. Check your sql statement {' . $sql . '}');
    }
}

// Drop unique index `key`
$sqlKeyExist = "SELECT COUNT(*)
                FROM information_schema.KEY_COLUMN_USAGE kc
                WHERE kc.TABLE_SCHEMA = DATABASE() AND kc.TABLE_NAME = 'token' AND kc.COLUMN_NAME = 'key'";
$result      = $pdo->query($sqlKeyExist)->fetchColumn();
if ($result) {
    if (false === $pdo->exec("ALTER TABLE `token` DROP INDEX `key`")) {
        die('Error: SQL statement error. Check your sql statement {' . $sql . '}');
    }
}
#endregion

#region Add column `run_time`
$sqlKeyExist = "SELECT COUNT(*)
                FROM information_schema.COLUMNS c
                WHERE c.TABLE_SCHEMA = DATABASE() AND c.TABLE_NAME = 'resource' AND c.COLUMN_NAME = 'run_time'";
$result      = $pdo->query($sqlKeyExist)->fetchColumn();
if (!$result) {
    if (false === $pdo->exec("ALTER TABLE `resource` ADD COLUMN `run_time` VARCHAR(8) DEFAULT '00:00' AFTER `produce_time`")) {
        die('Error: SQL statement error. Check your sql statement {' . $sql . '}');
    }
}
#endregion