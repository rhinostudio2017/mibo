<?php

namespace FS\API\Model;


use FS\Common\Exception\InvalidParameterException;

class User
{
    private $id = 0;
    private $username;
    private $password;
    private $email;

    #region Constructor
    public function __construct($data)
    {
        if (!is_array($data)) {
            throw new InvalidParameterException('Passed in parameters must be array format');
        }

        if (isset($data['id'])) {
            $this->setId($data['id']);
        }

        if (isset($data['username'])) {
            $this->setUsername($data['username']);
        }

        if (isset($data['password'])) {
            $this->setPassword($data['password']);
        }

        if (isset($data['email'])) {
            $this->setEmail($data['email']);
        }
    }
    #endregion

    #region Getters & Setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidParameterException('Passed in parameter {id} must be integer');
        }

        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        if (empty($username)) {
            throw new InvalidParameterException('Parameter {username} must not be empty');
        }

        if (strlen($username) > 64) {
            throw new InvalidParameterException('Parameter {username} must less or equal 64 chars');
        }

        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if (empty($password)) {
            throw new InvalidParameterException('Parameter {password} must not be empty');
        }

        if (strlen($password) > 64) {
            throw new InvalidParameterException('Parameter {password} must less or equal 64 chars');
        }

        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (empty($email)) {
            throw new InvalidParameterException('Parameter {email} must not be empty');
        }

        if (!$this->validateEmail($email)) {
            throw new InvalidParameterException('Parameter {email} is not in correct format');
        }

        $this->email = $email;
    }
    #endregion

    #region Utils
    private function validateEmail($email)
    {
        $regexp = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
        return preg_match($regexp, $email) === 1;
    }
    #endregion
}
