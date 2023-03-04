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

    public function run()
    {
        Router::match($this->request->get_uri(), $this->request->get_method());

        // Вызов метода контроллера, соответствующего маршруту
//        $controller = new $route['controller']($this->request);
//        $responseContent = call_user_func_array([$controller, $route['action']], $route['params']);

        /*// Отправка ответа клиенту
        $this->response->set_content($responseContent);
        $this->response->send();*/


    }
}
