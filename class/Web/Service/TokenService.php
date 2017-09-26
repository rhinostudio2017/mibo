<?php

namespace FS\Web\Service;

class TokenService
{
    private static $tokenCachePath = __DIR__ . '/../../../config/token_cached.txt';

    public static function fetchToken($name = 'web')
    {
        $fetchedToken    = null;
        $tokenStr = file_get_contents(self::$tokenCachePath);
        $tokens   = explode(';', $tokenStr);
        foreach ($tokens as $token) {
            $tokenParts = explode('|', $token);
            if ($tokenParts[0] == $name) {
                $fetchedToken = $tokenParts[1];
                break;
            }
        }

        return $fetchedToken;
    }
}