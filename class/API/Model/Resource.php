<?php

namespace FS\API\Model;

use FS\Common\Exception\InvalidParameterException;

class Resource
{
    #region Properties
    private $id          = 0;
    private $name        = '';
    private $description = '';
    private $posterLink  = '';
    private $videoLink   = '';
    private $author      = '';
    private $produceTime = '0000-00-00 00:00:00';
    private $runTime     = '';
    private $views       = 0;
    private $venue       = '';
    private $note        = '';
    #endregion

    #region Construct
    public function __construct($data)
    {
        if (!is_array($data)) {
            throw new InvalidParameterException('Passed in parameters must be array format');
        }

        if (isset($data['id'])) {
            $this->setId($data['id']);
        }

        if (isset($data['name'])) {
            $this->setName($data['name']);
        }

        if (isset($data['description'])) {
            $this->setDescription($data['description']);
        }

        if (isset($data['posterLink'])) {
            $this->setPosterLink($data['posterLink']);
        }

        if (isset($data['videoLink'])) {
            $this->setVideoLink($data['videoLink']);
        }

        if (isset($data['author'])) {
            $this->setAuthor($data['author']);
        }

        if (!empty($data['produceTime'])) {
            $this->setProduceTime($data['produceTime']);
        } else {
            $this->setProduceTime((new \DateTime())->format('Y-m-d H:i:s'));
        }

        if (!empty($data['runTime'])) {
            $this->setRunTime($data['runTime']);
        }

        if (isset($data['venue'])) {
            $this->setVenue($data['venue']);
        }

        if (!empty($data['views'])) {
            $this->setViews($data['views']);
        }

        if (isset($data['note'])) {
            $this->setNote($data['note']);
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
            throw new InvalidParameterException('Parameter {id} must be numeric');
        }

        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (strlen($name) > 128) {
            //throw new InvalidParameterException('Parameter {name} must less or equal 128 chars');
            $name = substr($name, 0, 128);
        }

        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        if (strlen($description) > 256) {
            //throw new InvalidParameterException('Parameter {description} must less or equal 256 chars');
            $description = substr($description, 0, 256);
        }

        $this->description = $description;
    }

    public function getPosterLink()
    {
        return $this->posterLink;
    }

    public function setPosterLink($posterLink)
    {
        if (strlen($posterLink) > 128) {
            throw new InvalidParameterException('Parameter {posterLink} must less or equal 128 chars');
        }

        $this->posterLink = $posterLink;
    }

    public function getVideoLink()
    {
        return $this->videoLink;
    }

    public function setVideoLink($videoLink)
    {

        if (strlen($videoLink) > 128) {
            throw new InvalidParameterException('Parameter {videoLink} must less or equal 128 chars');
        }

        $this->videoLink = $videoLink;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        if (strlen($author) > 32) {
            throw new InvalidParameterException('Parameter {author} must less or equal 32 chars');
        }

        $this->author = $author;
    }

    public function getProduceTime()
    {
        return $this->produceTime;
    }

    public function setProduceTime($produceTime)
    {
        if (!$this->validateDateTime($produceTime)) {
            throw new InvalidParameterException('Parameter {produceTime} is not in correct datetime format');
        }

        $this->produceTime = $produceTime;
    }

    public function getRunTime()
    {
        return $this->runTime;
    }

    public function setRunTime($runTime)
    {
        if (!$this->validateRunTime($runTime)) {
            throw new InvalidParameterException('Parameter {runTime} is not in correct datetime format');
        }

        $this->runTime = $runTime;
    }

    public function getVenue()
    {
        return $this->venue;
    }

    public function setVenue($venue)
    {
        if (strlen($venue) > 64) {
            throw new InvalidParameterException('Parameter {venue} must less or equal 64 chars');
        }

        $this->venue = $venue;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views)
    {
        if (!is_numeric($views)) {
            throw new InvalidParameterException('Parameter {views} must be numeric');
        }

        $this->views = $views;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        if (strlen($note) > 128) {
            throw new InvalidParameterException('Parameter {note} must less or equal 128 chars');
        }

        $this->note = $note;
    }
    #endregion

    #region Utils
    private function validateDateTime(&$datetime)
    {
        // Replace mis-spelling (`;`, `-` etc) to `:`
        $datetime = str_replace(';', ':', $datetime);
        // Datetime validation, e.g. 2017-03-27 12:23:00
        $preg = '/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})?$/';

        return preg_match($preg, $datetime) === 1;
    }

    private function validateRunTime($runTime)
    {
        // runTime validation, e.g. 01:23:20 or 11:09
        $preg = '/^(\d{2}:)?\d{2}:\d{2}$/';

        return preg_match($preg, $runTime) === 1;
    }
    #endregion
}
