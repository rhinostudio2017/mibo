<?php

require __DIR__ . '/../class/Common/autoload.php';
require __DIR__ . '/../config/web.conf.php';

$router = new \FS\Common\Router();

// Path to page mapping
$router->get('/', function () {
    return (new \FS\Web\Controller\PageController())->render();
});
$router->get('/admin', function () {
    return (new \FS\Web\Controller\PageController())->render('admin');
});

#region Api endpoints
// resource
$router->group('/api/resource/', function () {
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
});

// user
$router->group('/api/user/', function () {
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
#endregion

$router->execute();
