<?php

namespace FS\Common\Exception;

class PDOResultEmptyException extends FSException
{
    public function __construct($message, $code = 1203, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
