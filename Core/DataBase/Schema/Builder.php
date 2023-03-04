<?php

namespace OptimMVC\Core\DataBase\Schema;

use OptimMVC\Core\Config;
use OptimMVC\Core\Database\Connection;
use OptimMVC\Core\DataBase\DataBase;

class Builder
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new DataBase(Config::databaseConfig()['host'], Config::databaseConfig()['port'],  Config::databaseConfig()['database'], Config::databaseConfig()['username'], Config::databaseConfig()['password']);
    }

    public function createTable($table, $columns)
    {
        $query = "CREATE TABLE IF NOT EXISTS {$table} (";
        $columnDefinitions = array_map(function ($column) {
            return $column->getDefinition();
        }, $columns);
        $query .= implode(", ", $columnDefinitions);
        $query .= ")";
        $this->connection->query($query);
    }

    public function addColumn($table, $column)
    {
        $query = "ALTER TABLE {$table} ADD COLUMN {$column->getDefinition()}";
        $this->connection->query($query);
    }

    public function dropColumn($table, $column)
    {
        $query = "ALTER TABLE {$table} DROP COLUMN {$column}";
        $this->connection->query($query);
    }

    public function dropTable($table)
    {
        $sql = "DROP TABLE $table";
        $this->connection->query($sql);
    }
}