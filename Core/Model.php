<?php

namespace OptimMVC\Core;

use OptimMVC\Core\DataBase\QueryBuilder;
class Model
{
    protected $table;
    protected $fillable = [];
    protected $primaryKey = 'id';
    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
        $this->queryBuilder->table($this->table);
    }

    public function create($data)
    {
        $columns = array_intersect_key($data, array_flip($this->fillable));
        $this->queryBuilder->insert($columns);
        return $this->queryBuilder->lastInsertId();
    }

    public function update($data): int
    {
        $id = $data[$this->primaryKey];
        $columns = array_intersect_key($data, array_flip($this->fillable));
        unset($columns[$this->primaryKey]);
        $this->queryBuilder->where($this->primaryKey, '=', $id);
        return $this->queryBuilder->update($columns);
    }

    public function delete($id): int
    {
        $this->queryBuilder->where($this->primaryKey, '=', $id);
        return $this->queryBuilder->delete();
    }

    public function find($id)
    {
        $this->queryBuilder->where($this->primaryKey, '=', $id);
        return $this->queryBuilder->get()[0];
    }

    public function all()
    {
        return $this->queryBuilder->get();
    }
}
