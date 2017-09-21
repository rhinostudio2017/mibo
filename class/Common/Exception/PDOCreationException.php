<?php

namespace FS\Common\Exception;

class PDOCreationException extends FSException
{
    public function __construct($message, $code = 1200, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
