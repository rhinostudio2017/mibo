<?php
namespace FS\Common\Exception;

class FileReadException extends FSException
{
    public function __construct($message, $code = 1301, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
