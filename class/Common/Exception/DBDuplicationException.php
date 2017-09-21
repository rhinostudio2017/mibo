<?php

namespace FS\Common\Exception;

class DBDuplicationException extends FSException
{
    public function __construct($message, $code = 1400, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
