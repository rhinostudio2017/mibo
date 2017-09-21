<?php

namespace FS\Common\Exception;

class InvalidParameterException extends FSException
{
    public function __construct($message, $code = 1100, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
