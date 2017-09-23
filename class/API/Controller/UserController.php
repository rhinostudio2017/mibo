<?php

namespace FS\API\Controller;

use FS\API\Model\User;
use FS\Common\Exception\InvalidParameterException;
use FS\Common\IO;
use FS\API\Model\Resource;

class UserController extends Controller
{
    #region Actions
    public function create()
    {
        $this->auth->hasPermission(['write']);

        if (!($validation = IO::required($this->data, ['username', 'password', 'email']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $user = new User($this->data);

        // Check duplication
        if (!($validation = $this->_checkExist())['valid']) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['message'] = implode(' ', $validation['message']);
            return $this->responseArr;
        }

        // Insert user item
        $sql = "INSERT INTO `user`(`username`, `password`, `email`) 
                VALUES(:username, :password, :email)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'email'    => $user->getEmail()
        ]);

        $this->responseArr['data'] = [
            'id' => $this->pdo->lastInsertId()
        ];

        return $this->responseArr;
    }

    public function update()
    {
        $this->auth->hasPermission(['write']);

        if (!($validation = IO::required($this->data, ['id']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $user = new User($this->data);

        $sql = "UPDATE `user` 
                SET `username` = :username, `password` = :password, `email` = :email
                WHERE `id` = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id'       => $user->getId(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'email'    => $user->getEmail()
        ]);

        return $this->responseArr;
    }

    public function delete()
    {
        $this->auth->hasPermission(['write']);

        if (!($validation = IO::required($this->data, ['id']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $user = new User($this->data);

        $sql = "DELETE FROM `user` WHERE `id` = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $user->getId()]);

        return $this->responseArr;
    }

    public function getById()
    {
        $this->auth->hasPermission(['read']);

        if (!($validation = IO::required($this->data, ['id']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $user = new User($this->data);

        $sql = "SELECT * FROM `user` WHERE `id` = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $user->getId()]);

        if (!($row = $stmt->fetch())) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['message'] = 'User with id {' . $user->getId() . '} can NOT be found';
            return $this->responseArr;
        }

        $this->responseArr['data'] = [
            'id'       => $row->getId(),
            'username' => $row->getUsername(),
            'password' => $row->getPassword(),
            'email'    => $row->getEmail()
        ];

        return $this->responseArr;
    }

    public function listAll()
    {
        $this->auth->hasPermission(['read']);

        $total = $this->pdo->query("SELECT COUNT(*) FROM `user`")->fetchColumn();

        $sql = "SELECT * FROM `user` ORDER BY `username`";

        $result = $this->pdo->query($sql);

        $this->responseArr['data'] = [
            'total' => $total,
            'users' => $result->fetchAll()
        ];

        return $this->responseArr;
    }

    public function login()
    {
        $this->auth->hasPermission(['read']);

        if (!($validation = IO::required($this->data, ['username', 'password']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $user = new User($this->data);

        // Check user in db
        $sql = "SELECT COUNT(*) FROM `user` WHERE `username` = :username AND `password` = :password";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['username' => $user->getUsername(), 'password' => $user->getPassword()]);

        if ($stmt->fetchColumn() === 0) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['message'] = 'Failed to login. Either username or password is not correct.';
        }

        return $this->responseArr;
    }
    #endregion

    #region Utils
    // Check resource duplication based on video_link
    private function _checkExist()
    {
        $ret = ['valid' => true, 'message' => []];

        if (!($validation = IO::required($this->data, ['videoLink']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $eitherOptions = ['username', 'email'];

        $choseOptions = array_intersect($eitherOptions, array_keys($this->data));

        foreach ($choseOptions as $option) {
            if ($option == 'username') {
                $sql = "SELECT COUNT(*) FROM `user` WHERE `username` = :username";
            } elseif ($option == 'email') {
                $sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";
            }

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([$option => $this->data[$option]]);

            if ($stmt->fetchColumn() != 0) {
                $ret['valid']     = false;
                $ret['message'][] = $option . '{' . $this->data[$option] . '} has been occupied, please try again.';
            }
        }


        return $ret;
    }
    #endregion
}
