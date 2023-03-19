<?php

namespace OptimMVC\app\models;

use OptimMVC\Core\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function __construct()
    {
        parent::__construct();
    }


}