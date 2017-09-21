<?php

namespace FS\Controller;

use FS\Common\Auth;
use FS\Common\Exception\InvalidParameterException;
use FS\Common\IO;

abstract class Controller
{
    protected $responseArr;
    protected $timezone;
    protected $auth;
    protected $pdo;
    protected $data;

    public function __construct($connection = null, $secure = null)
    {
        $this->responseArr = IO::initResponseArray();
        $this->auth        = new Auth();
        $this->timezone    = date_default_timezone_get();

        // VALIDATION
        if (empty($this->timezone)) {
            $this->timezone = 'UK';
        }

        // Used only if an entire handler has the same permissions, otherwise it's done within the handler
        if (!is_null($secure)) {
            if (!is_array($secure)) {
                throw new InvalidParameterException('Error: Securable should be array');
            }

            $this->auth->hasPermission($secure);
        }

        // Used only if an entire handler uses the same connection, otherwise it's done within the handler
        if (!is_null($connection)) {
            if (!isset($connection) || !is_array($connection)) {
                throw new InvalidParameterException('Error: PDO connection is not configured properly');
            }

            $this->pdo = IO::getPDOConnection($connection);
        }

        // Take POST as the default request method, can be overridden in specified method
        $this->data = IO::getPostParameters();
    }

    #region Methods
    protected function appendSearch($searchString, $query)
    {
        return $searchString . (strpos($searchString, 'WHERE') === false ? ' WHERE ' : ' AND ') . $query;
    }

    protected function bindParams(\PDOStatement $stmt, $parameters)
    {
        foreach ($parameters as $parameter => $value) {
            $stmt->bindValue($parameter, $value);
        }

        return $stmt;
    }

    protected function getDateTime($date, $time, $defaultTime)
    {
        return empty($time) ? $date . ' ' . $defaultTime : $date . ' ' . $time;
    }
    #endregion
}