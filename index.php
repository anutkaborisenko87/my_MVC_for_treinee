<?php

use OptimMVC\Core\Application;
use OptimMVC\Core\Request;

require_once 'vendor/autoload.php';
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
session_start();
$app = new Application(new Request());
$app->run();
