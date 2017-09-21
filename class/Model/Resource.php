<?php

namespace FS\Model;

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
    private $venue       = '';
    private $views       = 0;
    private $note        = '';
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
        if (strlen($name) > 64) {
            throw new InvalidParameterException('Parameter {name} must less or equal 64 chars');
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
            throw new InvalidParameterException('Parameter {description} must less or equal 256 chars');
        }

        $this->description = $description;
    }

    public function getPosterLink()
    {
        return $this->posterLink;
    }

    public function setPosterLink($posterLink)
    {
        if (strlen($posterLink) > 64) {
            throw new InvalidParameterException('Parameter {posterLink} must less or equal 64 chars');
        }

        $this->posterLink = $posterLink;
    }

    public function getVideoLink()
    {
        return $this->videoLink;
    }

    public function setVideoLink($videoLink)
    {

        if (strlen($videoLink) > 64) {
            throw new InvalidParameterException('Parameter {videoLink} must less or equal 64 chars');
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
    private function validateDateTime($datetime)
    {
        // Datetime validation, e.g. 2017-03-27 12:23:00
        $preg = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';

        return preg_match($preg, $datetime) === 1;
    }
    #endregion
}
