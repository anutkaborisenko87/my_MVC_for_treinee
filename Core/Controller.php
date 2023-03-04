<?php

namespace OptimMVC\Core;

use OptimMVC\Core\View;
class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }
}