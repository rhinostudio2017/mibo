<?php

namespace FS\Common;

use FS\Common\Exception\FileNotReadableException;
use FS\Common\Exception\FileReadException;
use FS\Common\IO;

class Auth
{
    private $tokenCachePath;
    private $token;

    public function __construct()
    {
        $this->tokenCachePath = TOKEN_CACHED_FILE;

        // Initialise token
        $get  = IO::getQueryParameters();
        $post = IO::getPostParameters();

        $token = isset($get['token']) ? $get['token'] : '';

        if (empty($token) && isset($post['token']) && !empty($post['token'])) {
            $token = $post['token'];
        }

        $this->token = $token;
    }

    #region Methods
    public function hasPermission($secure) {

        if (!isset($this->token) || empty($this->token) || ($permissions = $this->authenticate()) === false) {
            http_response_code(401);
            exit();
        }

        foreach ($secure as $permission) {
            if ($permissions[$permission] != 1) {
                http_response_code(403);
                exit();
            }
        }

        return true;
    }

    private function authenticate()
    {
        $permissions = $this->getPermissions();

        if ($permissions === false) {
            return false;
        }

        $permission = ['read' => 0, 'write' => 0, 'expire' => 1];

        foreach ($permissions as $path => $item) {
            if (strpos($_SERVER['REQUEST_URI'], $path) !== false) {
                $permission['read'] |= $item['read'];
                $permission['write'] |= $item['write'];

                if (!empty($permission['expire'])) {
                    if (empty($item['expire']) || $permission['expire'] < $item['expire']) {
                        $permission['expire'] = $item['expire'];
                    }
                }
            }
        }

        if (!empty($permission['expire']) && $permission['expire'] <= date('Y-m-d H:i:s')) {
            $permission = false;
        }

        return $permission;
    }

    private function getPermissions()
    {
        $counter = 0;
        $limit   = 2;

        while (true) {
            if (!is_readable($this->tokenCachePath)) {
                if ($counter < $limit) {
                    $counter++;
                    sleep(1);
                    continue;
                } else {
                    throw new FileNotReadableException('Token cached file {' . $this->tokenCachePath . '} is not readable');
                }
            }

            break;
        }

        $permission = [];
        $tokenStr   = file_get_contents($this->tokenCachePath);

        if ($tokenStr === false) {
            throw new FileReadException('Retrieve cached tokens failed');
        }

        $tokenArr = explode(';', $tokenStr);

        foreach ($tokenArr as $token) {
            if (strpos($token, $this->token) !== false) {
                $itemArr = explode('|', $token);
                $paths   = explode(',', $itemArr[3]);

                foreach ($paths as $path) {
                    if (!isset($permission[$path])) {
                        $permission[$path] = ['read' => 0, 'write' => 0, 'expire' => 1];
                    }

                    $permission[$path]['read'] |= $itemArr[1];
                    $permission[$path]['write'] |= $itemArr[2];

                    if (!empty($permission[$path]['expire'])) {
                        if (empty($itemArr[4]) || $permission[$path]['expire'] < $itemArr[4]) {
                            $permission[$path]['expire'] = $itemArr[4];
                        }
                    }
                }
            }
        }

        return empty($permission) ? false : $permission;
    }
    #endregion
}
