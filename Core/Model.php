<?php

namespace OptimMVC\Core;

use OptimMVC\Core\DataBase\QueryBuilder;
class Model
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @var array
     */
    public $data = [];
    protected $columns = [];

    public function __construct()
    {
        $this->columns = $this->queryBuilder()->getColumns();

        foreach ($this->columns as $column) {
            $this->$column = null;
        }

    }

    /**
     * @return QueryBuilder
     */
    protected function queryBuilder(): QueryBuilder
    {
        return (new QueryBuilder())->table($this->table);
    }

    /**
     * @param $property
     * @return void
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        if (in_array($property, $this->columns)) {
            return $this->data[$property];
        }
    }

    /**
     * @param $property
     * @param $value
     * @return $this
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }

        if (in_array($property, $this->columns)) {
            $this->data[$property] = $value;
        }

        return $this;
    }

    /**
     * @param $data
     * @return false|string
     */
    public function create($data)
    {
        $columns = array_intersect_key($data, array_flip($this->fillable));
        if ($this->timestamps) {
            $columns['created_at'] = date('Y-m-d H:i:s');
            $columns['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->data = $columns;
        $lastId = $this->queryBuilder()->insert($columns);
        return $this->find($lastId);
    }

    /**
     * @param $data
     * @return
     */
    public function update($data)
    {
        $id = $data[$this->primaryKey];
        $columns = array_intersect_key($data, array_flip($this->fillable));

        unset($columns[$this->primaryKey]);
        if ($this->timestamps) {
            $columns['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->data = $columns;
        $updatedRow = $this->queryBuilder()->where($this->primaryKey, '=', $id)->update($columns);
        if (!$updatedRow) {
            return false;
        }
        return $this->find($id);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return $this->queryBuilder()->where($this->primaryKey, '=', $id)->delete();
    }

    /**
     * @param int $id
     * @return mixed|null
     */

    public function find(int $id)
    {
        $result = $this->queryBuilder()->where($this->primaryKey, '=', $id)->get()[0];
        $model = null;
        if (!empty($result)) {
            $model = new static();
            $model->data = (array) $result;
        }
        return $model;
    }

    /**
     * @return array
     */
    public function all(): ?array
    {
        $results = $this->queryBuilder()->get();
        $models = [];
        if (!empty($results)) {
            foreach ($results as $result) {
                $model = new static();
                $model->data = (array) $result;
                $models[] = $model;
            }
        }
        return !empty($models) ? $models : null;
    }

}
