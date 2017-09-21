<?php
namespace FS\Common\Exception;

class FileNotReadableException extends FSException
{
    public function __construct($message, $code = 1300, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
