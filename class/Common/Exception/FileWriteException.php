<?php
namespace FS\Common\Exception;

class FileWriteException extends FSException
{
    public function __construct($message, $code = 1302, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
