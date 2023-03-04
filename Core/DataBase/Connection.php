<?php

namespace OptimMVC\Core\DataBase;

use PDO;

class Connection
{
    protected $pdo;

    public function __construct($host, $port, $database, $username, $password)
    {
        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->pdo = new PDO($dsn, $username, $password, $options);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function close()
    {
        $this->pdo = null;
    }
}
