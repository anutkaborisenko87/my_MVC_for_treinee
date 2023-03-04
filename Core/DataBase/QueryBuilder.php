<?php

namespace OptimMVC\Core\DataBase;

use PDO;

class QueryBuilder extends DataBase
{
    protected $table;

    protected $select = '*';

    protected $where = [];
    protected $bindParams = [];

    protected $order = '';

    protected $limit = '';
    protected $primaryKey = 'id';

    public function select($columns = '*')
    {
        $this->select = $columns;

        return $this;
    }

    public function where($column, $operator, $value): QueryBuilder
    {
        $this->where[] = "$column $operator ?";
        $this->bindParams[] = $value;

        return $this;
    }

    public function orderBy($column, $direction = 'ASC'): QueryBuilder
    {
        $this->order = "ORDER BY $column $direction";

        return $this;
    }

    public function limit($offset, $count): QueryBuilder
    {
        $this->limit = "LIMIT $offset, $count";

        return $this;
    }

    public function get()
    {
        $query = "SELECT {$this->select} FROM {$this->table}";

        if (!empty($this->where)) {
            $query .= ' WHERE ' . implode(' AND ', $this->where);
        }

        if (!empty($this->order)) {
            $query .= ' ' . $this->order;
        }

        if (!empty($this->limit)) {
            $query .= ' ' . $this->limit;
        }

        $stmt = $this->getPdo()->prepare($query);
        $stmt->execute($this->bindParams);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function first()
    {
        $this->limit(1, 1);
        $this->orderBy($this->primaryKey, 'ASC');
        return $this->get()[0] ?? null;
    }

    public function last()
    {
        $this->limit(1, 1);
        $this->orderBy($this->primaryKey, 'DESC');
        return $this->get()[0] ?? null;
    }

    public function paginate($perPage = 10, $currentPage = 1): array
    {
        $totalRows = $this->count();
        $totalPages = ceil($totalRows / $perPage);
        $offset = ($currentPage - 1) * $perPage;

        $results = $this->limit($offset, $perPage)->get();

        return [
            'data' => $results,
            'total' => $totalRows,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'last_page' => $totalPages
        ];
    }
    public function count(): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table}";

        if (!empty($this->where)) {
            $query .= " WHERE " . implode(" AND ", $this->where);
        }
        $result = $this->query($query);
        $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
        return (int) $count;
    }

    public function table(string $table): QueryBuilder
    {
        $this->table = $table;
        return $this;
    }

    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $values = array_values($data);
        $this->query($query, $values);
        return $this->lastInsertId();
    }
    public function lastInsertId()
    {
        return $this->getPdo()->lastInsertId();
    }

    public function update($data): int
    {
        $query = "UPDATE {$this->table} SET ";
        $values = [];

        foreach ($data as $column => $value) {
            $query .= "{$column} = ?, ";
            $values[] = $value;
        }
        $query = rtrim($query, ', ');

        if (!empty($this->where)) {
            $query .= " WHERE ";
            foreach ($this->where as $i => $where) {
                $operator = $i == 0 ? "" : "AND";
                $query .= "{$operator} {$where['column']} {$where['operator']} ?";
                $values[] = $where['value'];
            }
        }
        return $this->query($query, $values)->rowCount();
    }

    public function delete(): int
    {
        $query = "DELETE FROM {$this->table}";
        if (!empty($this->wheres)) {
            $query .= " WHERE ";
            foreach ($this->wheres as $i => $where) {
                $operator = $i == 0 ? "" : "AND";
                $query .= "{$operator} {$where['column']} {$where['operator']} ?";
                $values[] = $where['value'];
            }
        }
        return $this->query($query, $values ?? [])->rowCount();
    }
}
