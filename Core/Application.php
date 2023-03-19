<?php

namespace OptimMVC\Core;

class Application
{
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        Config::init();
        $this->request = $request;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        Router::match($this->request->get_uri(), $this->request->get_method());

    }
}
