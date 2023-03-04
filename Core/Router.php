<?php

namespace OptimMVC\Core;

class Router
{
    protected static $routes = [];

    public static function get($url, $callback)
    {
        self::$routes['GET'][$url] = $callback;
    }

    public static function post($url, $callback)
    {
        self::$routes['POST'][$url] = $callback;
    }

    public static function put($url, $callback)
    {
        self::$routes['PUT'][$url] = $callback;
    }

    public static function delete($url, $callback)
    {
        self::$routes['DELETE'][$url] = $callback;
    }

    public static function match($url, $method)
    {

        if (array_key_exists($method, self::$routes)) {
            foreach (self::$routes[$method] as $route => $callback) {
                if ($url === $route) {
                    if (!is_array($callback) && ! is_string($callback)) {
                        return $callback();
                    } else {
                        $params = (new Request())->get_parameters();
                        if (!is_array($callback)) {
                            $callback = explode('@', 'OptimMVC\app\controllers\\'.$callback);
                        }
                        $controller = $callback[0];
                        $action = $callback[1];
                        $controller_name = str_replace('OptimMVC\app\controllers\\', '', $controller);

                        if(class_exists($controller)) {
                            $controller = new $controller();
                            if (method_exists($controller, $action)) {
                                $controller->$action($params);
                            } else {
                                return response()->json(['error'=>'That method '.$action.' does not exists in the '.$controller_name.'.'], 404);
                            }
                        } else {
                            return response()->json(['data'=>'That "'.$controller_name.'" does not exists.'], 404);
                        }
                    }
                    exit();
                }
            }
        }
        return null;
    }
}
