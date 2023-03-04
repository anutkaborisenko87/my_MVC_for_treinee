<?php

use OptimMVC\Core\DataBase;
use OptimMVC\Core\DataBase\Migrator;
use OptimMVC\Core\DataBase\QueryBuilder;
use OptimMVC\Core\DataBase\Schema\Builder;


require_once __DIR__ . '/vendor/autoload.php';

(new Builder())->create('migrations', function ($table) {
    $table->increments('id');
    $table->string('name');
});

$migrations = scandir(__DIR__ . '/database/migrations');

$migrator = new Migrator();
foreach ($migrations as $migration) {
    if ($migration === '.' || $migration === '..') {
        continue;
    }
    $migrationName = pathinfo($migration, PATHINFO_FILENAME);
    $migrationClass = "OptimMVC\\Database\\Migrations\\$migrationName";
    $query = (new QueryBuilder())->table('migrations')->where('name', 'LIKE', $migrationName)->get();
    if (empty($query)) {
        $migrator->addMigration(new $migrationClass());
        $migrator->migrate();
        (new QueryBuilder())->table('migrations')->insert(['name' => $migrationName]);
    }
}

echo "All migrations have been executed successfully!";

