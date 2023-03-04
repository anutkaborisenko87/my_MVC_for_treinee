<?php

namespace OptimMVC\Core\DataBase\Schema;

class Table
{
    private $name;
    private $columns = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function increments($name): Column
    {
        return $this->addColumn($name, 'int', ['primary_key' => true, 'auto_increment' => true]);
    }

    public function string($name, $length = 255): Column
    {
        return $this->addColumn($name, 'varchar', ['length' => $length]);
    }

    public function integer($name): Column
    {
        return $this->addColumn($name, 'int');
    }

    public function text($name): Column
    {
        return $this->addColumn($name, 'text');
    }

    public function timestamp($name): Column
    {
        return $this->addColumn($name, 'timestamp');
    }

    public function dateTime($name): Column
    {
        return $this->addColumn($name, 'datetime');
    }

    public function float($name): Column
    {
        return $this->addColumn($name, 'float');
    }

    public function double($name): Column
    {
        return $this->addColumn($name, 'double');
    }

    public function decimal($name, $precision = 8, $scale = 2): Column
    {
        return $this->addColumn($name, 'decimal', ['precision' => $precision, 'scale' => $scale]);
    }

    public function boolean($name): Column
    {
        return $this->addColumn($name, 'tinyint', ['length' => 1]);
    }

    public function addColumn($name, $type, $options = []): Column
    {
        $column = new Column($name, $type, $options);
        $this->columns[] = $column;
        return $column;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getName()
    {
        return $this->name;
    }

    public function primary($columns): Table
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        foreach ($this->columns as $column) {
            if (in_array($column->getName(), $columns)) {
                $column->setPrimaryKey(true);
            }
        }
        return $this;
    }

    public function unique($columns): Table
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        foreach ($this->columns as $column) {
            if (in_array($column->getName(), $columns)) {
                $column->setUnique(true);
            }
        }
        return $this;
    }

    public function index($columns, $name = null): Index
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $index = new Index($name, $columns);
        $this->columns[] = $index;
        return $index;
    }
}
