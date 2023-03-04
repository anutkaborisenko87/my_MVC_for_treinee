<?php

namespace OptimMVC\Core;


use OptimMVC\Core\Database\Connection;
use OptimMVC\Core\Database\Schema\Builder;

abstract class Migration
{
    protected $connection;
    protected $schema;

    public function __construct()
    {
        $this->connection = new Connection(Config::databaseConfig()['host'], Config::databaseConfig()['port'],  Config::databaseConfig()['database'], Config::databaseConfig()['username'], Config::databaseConfig()['password']);
        $this->schema = new Builder();
    }

    public abstract function up();

    public abstract function down();
}