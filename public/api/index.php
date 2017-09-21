<?php

ini_set('max_execution_time', 180);

require __DIR__ . '/../../config/common.php';
require __DIR__ . '/../../class/Common/autoload.php';

use FS\Common\Router;

$router = new Router();

// API - Holiday
$router->group('/resource/', function () {
    $this->post('add', function () {
        return (new \FS\Controller\ResourceController())->create();
    });
    $this->post('edit', function () {
        return (new \FS\Controller\ResourceController())->update();
    });
    $this->post('remove', function () {
        return (new \FS\Controller\ResourceController())->delete();
    });
    $this->post('fetch-by-id', function () {
        return (new \FS\Controller\ResourceController())->getById();
    });
    $this->post('fetch', function () {
        return (new \FS\Controller\ResourceController())->search();
    });
});

$router->execute();
