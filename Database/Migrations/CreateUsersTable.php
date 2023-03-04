<?php

namespace OptimMVC\Database\Migrations;

use OptimMVC\Core\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->schema->create('users', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('auth_token')->nullable();
            $table->datetime('token_active');
            $table->boolean('user_blocked')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}