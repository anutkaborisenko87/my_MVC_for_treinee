<?php

namespace OptimMVC\Core;

class Cookie
{
    public static function set($name, $value, $expiration = null, $path = '/', $domain = null, $secure = false, $httpOnly = true)
    {
        if ($expiration !== null) {
            $expiration = time() + $expiration;
        }

        setcookie($name, $value, $expiration, $path, $domain, $secure, $httpOnly);
    }

    public static function get($name)
    {
        return $_COOKIE[$name] ?? null;
    }

    public static function delete($name, $path = '/', $domain = null, $secure = false, $httpOnly = true)
    {
        self::set($name, '', -3600, $path, $domain, $secure, $httpOnly);
        unset($_COOKIE[$name]);
    }
}