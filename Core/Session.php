<?php

namespace OptimMVC\Core;

class Session
{
    /**
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key
     */
    public static function remove(string $key)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    public static function destroy()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        session_destroy();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);

    }
}
