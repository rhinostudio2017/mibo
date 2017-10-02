<?php

ini_set('max_execution_time', 180);

require __DIR__ . '/../class/Common/autoload.php';
require __DIR__ . '/../config/api.conf.php';

use FS\Common\Router;

$router = new Router();

// resource
$router->group('/resource/', function () {
    $this->post('add', function () {
        return (new \FS\API\Controller\ResourceController())->create();
    });
    $this->post('edit', function () {
        return (new \FS\API\Controller\ResourceController())->update();
    });
    $this->post('remove', function () {
        return (new \FS\API\Controller\ResourceController())->delete();
    });
    $this->post('exist', function () {
        return (new \FS\API\Controller\ResourceController())->checkExist();
    });
    $this->post('fetch-by-id', function () {
        return (new \FS\API\Controller\ResourceController())->getById();
    });
    $this->post('fetch', function () {
        return (new \FS\API\Controller\ResourceController())->search();
    });
    $this->post('increase-views', function () {
        return (new \FS\API\Controller\ResourceController())->increaseViews();
    });
});

// user
$router->group('/user/', function () {
    $this->post('login', function () {
        return (new \FS\API\Controller\UserController())->login();
    });
    $this->post('logout', function () {
        return (new \FS\API\Controller\UserController())->logout();
    });
    $this->post('add', function () {
        return (new \FS\API\Controller\UserController())->create();
    });
    $this->post('edit', function () {
        return (new \FS\API\Controller\UserController())->update();
    });
    $this->post('remove', function () {
        return (new \FS\API\Controller\UserController())->delete();
    });
    $this->post('fetch-by-id', function () {
        return (new \FS\API\Controller\UserController())->getById();
    });
    $this->post('list', function () {
        return (new \FS\API\Controller\UserController())->listAll();
    });
});

$router->execute();
