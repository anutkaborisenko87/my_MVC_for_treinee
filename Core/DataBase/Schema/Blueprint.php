<?php

namespace OptimMVC\Core\DataBase\Schema;

class Blueprint
{
    protected $table;
    protected $columns = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function increments($column): Column
    {
        $column = new Column($column, 'INT', ['AUTO_INCREMENT' => true, 'PRIMARY KEY' => true]);
        $this->columns[] = $column;
        return $column;
    }
    public function integer($column): Column
    {
        $column = new Column($column, 'INT');
        $this->columns[] = $column;
        return $column;
    }

    public function string($column, $length = 191): Column
    {
        $column = new Column($column, "VARCHAR($length)");
        $this->columns[] = $column;
        return $column;
    }
    public function text($column): Column
    {
        $column = new Column($column, 'TEXT');
        $this->columns[] = $column;
        return $column;
    }

    public function datetime($column): Column
    {
        $column = new Column($column, 'DATETIME');
        $this->columns[] = $column;
        return $column;
    }

    public function boolean($column): Column
    {
        $column = new Column($column, 'TINYINT(1)');
        $this->columns[] = $column;
        return $column;
    }


    public function timestamp($column): Column
    {
        $column = new Column($column, 'TIMESTAMP');
        $this->columns[] = $column;
        return $column;
    }

    public function timestamps()
    {
        $this->timestamp('created_at');
        $this->timestamp('updated_at');
    }


    public function toSql(): string
    {
        $sql = "CREATE TABLE IF NOT EXISTS  {$this->table}(";
        $definitions = [];
        foreach ($this->columns as $column) {
            $definitions[] = $column->getDefinition();
        }
        $sql .= implode(',', $definitions);
        $sql .= ")";
        return $sql;
    }
}