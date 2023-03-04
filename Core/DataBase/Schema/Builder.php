<?php

namespace OptimMVC\Core\DataBase\Schema;

use OptimMVC\Core\DataBase\DataBase;

class Builder
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new DataBase();
    }

    public function create($table, $callback): Blueprint
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        $sql = $blueprint->toSql();
        $this->connection->query($sql);
        return $blueprint;
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

    public function drop($table)
    {
        $sql = "DROP TABLE IF EXISTS $table";
        $this->connection->query($sql);
    }
}