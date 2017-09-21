<?php

namespace FS\Common;

class Parser
{
    public static function parsePath($path)
    {
        $result = preg_replace('/[^a-zA-Z0-9-_.]/', '', $path);

        if ($path != $result) {
            throw new \Exception('Path must only contain characters a-z, A-Z, 0-9, period, underscore and hyphen');
        }

        $result = trim($path, '/') . '/';

        return $result;
    }

    public static function parseURL($url)
    {
        // Generic validation
        $result = filter_var($url, FILTER_SANITIZE_URL);

        if ($url != $result) {
            throw new \Exception('URL must not contain any illegal URL characters');
        }

        // Hash and brackets (For VirtualHost output)
        $result = preg_replace('/[#<>]/', '', $result);

        if ($url != $result) {
            throw new \Exception('URL must not contain hash or bracket characters');
        }

        $result = trim($url, '/') . '/';

        return $result;
    }

    public static function parseComment($comment, $strict = true)
    {
        // General & Special new line characters
        $result = str_replace(['\n', '\r'], '. ', preg_replace('~\R~u', '', $comment));

        if ($strict && $comment != $result) {
            throw new \Exception('Comment must not contain linefeed characters');
        }

        // Hash and brackets
        $result = preg_replace('/[#<>]/', '', $result);

        if ($strict && $comment != $result) {
            throw new \Exception('Comment must not contain hash or bracket characters');
        }

        return $result;
    }
}
