<?php

namespace FS\Common\Exception;

class PDOQueryException extends FSException
{
    public function __construct($message, $code = 1202, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
