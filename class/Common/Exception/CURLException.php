<?php
namespace FS\Common\Exception;

class CURLException extends FSException
{
    public function __construct($message, $code = 1500, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
