<?php

namespace OptimMVC\Core;

class Hash
{
    /**
     * @param $password
     * @return false|string|null
     */
    public static function make($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function verify($password, $hash): bool
    {
        return password_verify($password, $hash);
    }

}