<?php

namespace OptimMVC\Core;

class Collection
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function all()
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function contains($value): bool
    {
        return in_array($value, $this->items);
    }

    public function first()
    {
        return reset($this->items);
    }

    public function last()
    {
        return end($this->items);
    }

    public function pluck($key): Collection
    {
        return new static(array_map(function($item) use ($key) {
            return $item[$key];
        }, $this->items));
    }

    public function filter(callable $callback): Collection
    {
        return new static(array_filter($this->items, $callback));
    }

    public function map(callable $callback): Collection
    {
        return new static(array_map($callback, $this->items));
    }

    public function sortBy($key): Collection
    {
        $sorted = $this->items;
        usort($sorted, function($a, $b) use ($key) {
            return $a[$key] <=> $b[$key];
        });
        return new static($sorted);
    }

    public function toJson()
    {
        return json_encode($this->items);
    }
}
