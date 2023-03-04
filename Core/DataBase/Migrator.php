<?php

namespace OptimMVC\Core\DataBase;

use OptimMVC\Core\Migration;

class Migrator extends DataBase
{

    protected $migrations = [];


    public function addMigration(Migration $migration)
    {
        $this->migrations[] = $migration;
    }

    public function migrate()
    {
        foreach ($this->migrations as $migration) {
            $migration->up();
        }
    }

    public function rollback()
    {
        foreach (array_reverse($this->migrations) as $migration) {
            $migration->down();
        }
    }
}
