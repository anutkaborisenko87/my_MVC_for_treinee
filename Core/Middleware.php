<?php

namespace OptimMVC\Core;

abstract class Middleware
{

    protected $next;

    /**
     * @param Middleware $next
     * @return void
     */
    public function setNext(Middleware $next)
    {
        $this->next = $next;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function handle(Request $request, Response $response)
    {
        if ($this->next !== null) {
            $this->next->handle($request, $response);
        }
    }
}
