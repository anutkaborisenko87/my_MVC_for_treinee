<?php

namespace OptimMVC\Core\DataBase\Schema;

class Index
{
    protected $name;
    protected $columns = [];

    public function __construct($name, $columns)
    {
        $this->name = $name;
        $this->columns = $columns;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'columns' => $this->columns
        ];
    }
}
