<?php

namespace FS\Common\Exception;

class MailException extends FSException
{
    public function __construct($message, $code = 1600, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
