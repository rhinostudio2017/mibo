<?php

// Check server api
if (php_sapi_name() != 'cli') {
    die('Must be run via cli');
}

require __DIR__ . '/../config/common.php';
require __DIR__ . '/../class/Common/autoload.php';

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
            `name` VARCHAR(64) NOT NULL DEFAULT '',
            `description` VARCHAR(256) NULL DEFAULT NULL,
            `poster_link` VARCHAR(64) NOT NULL DEFAULT '',
            `video_link` VARCHAR(64) NOT NULL DEFAULT '',
            `author` VARCHAR(32) NOT NULL DEFAULT '',
            `produce_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `venue` VARCHAR(64) NOT NULL DEFAULT '',
            `views` INT(11) NULL DEFAULT '0',
            `note` VARCHAR(128) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`),
            INDEX `idx_time` (`produce_time`),
            INDEX `idx_views` (`views`),
            FULLTEXT INDEX `ft_description` (`description`),
            FULLTEXT INDEX `ft_venue` (`venue`)
        ) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4";

if ($pdo->exec($sql) === false) {
    die('Error: SQL statement error. Check your sql statement {' . $sql . '}');
}
#endregion
