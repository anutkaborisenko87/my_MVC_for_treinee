<?php

namespace OptimMVC\Core;

use Dotenv\Dotenv;
use PDO;

class Config
{
    private static $env;

    public static function init()
    {
        $dotenv = Dotenv::createImmutable(ROOT);
        $dotenv->load();
        self::$env = $_ENV;
    }

    public static function env(string $key, $default = null)
    {
        return self::$env[$key] ?? $default;
    }

    public static function databaseConfig(): array
    {
        return [
            'host' => self::env('DB_HOST', 'localhost'),
            'port' => self::env('DB_PORT', '3306'),
            'database' => self::env('DB_DATABASE', 'optimize_mvc'),
            'username' => self::env('DB_USERNAME', 'root'),
            'password' => self::env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        ];
    }

    public static function get(string $key, $default = null)
    {
        return self::env($key, $default);
    }

    public static function set(string $key, $value): void
    {
        self::$env[$key] = $value;
    }
}


