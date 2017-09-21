<?php
namespace FS\Common\Exception;

class DirCreateException extends FSException
{
    public function __construct($message, $code = 1303, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
