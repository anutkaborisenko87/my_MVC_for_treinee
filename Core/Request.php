<?php

namespace OptimMVC\Core;

class Request {
    protected $method;
    protected $uri;
    protected $parameters;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->parameters = $_REQUEST;
    }

    /**
     * @return mixed
     */

    public function get_method() {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function get_uri()
    {
        return $this->uri;
    }

    /**
     * @param string $name
     * @return mixed|null
     */

    public function get_parameter(string $name)
    {
        return $this->parameters[$name] ?? null;
    }

    /**
     * @return array
     */

    public function get_parameters(): array
    {
        return $this->parameters;
    }
}
