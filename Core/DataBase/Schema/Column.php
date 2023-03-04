<?php

namespace OptimMVC\Core\DataBase\Schema;

class Column
{
    protected $name;
    protected $type;
    protected $attributes = [];

    public function __construct($name, $type, $attributes = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->attributes = $attributes;
    }

    public function nullable(): Column
    {
        $this->attributes['NULL'] = true;
        return $this;
    }

    public function unique()
    {
        $this->attributes['UNIQUE'] = true;
    }

    public function default($value): Column
    {
        $this->attributes['DEFAULT'] = $value;
        return $this;
    }

    public function getDefinition(): string
    {
        $definition = "{$this->name} {$this->type}";
        foreach ($this->attributes as $attribute => $value) {
            $definition .= " {$attribute}";
            if ($value !== true) {
                $definition .= " {$value}";
            }
        }
        return $definition;
    }
}
