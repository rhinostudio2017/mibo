<?php
namespace FS\Common\Exception;

class InvalidOperationException extends FSException
{
    public function __construct($message, $code = 1700, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
