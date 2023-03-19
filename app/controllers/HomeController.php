<?php

namespace OptimMVC\app\controllers;

use OptimMVC\app\models\User;
use OptimMVC\Core\Controller;
use OptimMVC\Core\Hash;

class HomeController extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Home Page',
            'site_name' => 'My Website',
            'contentdata' => ''
        ];

       return $this->view->render('home', $data);
    }

}