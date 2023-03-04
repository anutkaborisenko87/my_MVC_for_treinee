<?php

use OptimMVC\app\controllers\HomeController;
use OptimMVC\Core\Router;

Router::get('/', [HomeController::class, 'index']);
Router::get('/', 'HomeController@index');
//Router::get('/', function () {
//    return 'here';
//});