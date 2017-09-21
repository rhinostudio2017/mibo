<?php

namespace FS\Common\Exception;

class PDOExecutionException extends FSException
{
    public function __construct($message, $code = 1201, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
