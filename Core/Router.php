<?php

namespace OptimMVC\Core;

class Router
{
    protected static $routes = [];

    protected static $prefix;

    protected static $middleware = [];

    public static function prefix($prefix)
    {
        self::$prefix = $prefix;
    }

    public static function middleware($middleware)
    {
        self::$middleware = $middleware;
    }

    public static function group($callback)
    {
        call_user_func($callback);
        self::$prefix = null;
        self::$middleware = [];
    }

    public static function get($url, $callback)
    {
        self::addRoute('GET', $url, $callback);
    }

    public static function post($url, $callback)
    {
        self::addRoute('POST', $url, $callback);
    }

    public static function put($url, $callback)
    {
        self::addRoute('PUT', $url, $callback);
    }

    public static function delete($url, $callback)
    {
        self::addRoute('DELETE', $url, $callback);
    }

    protected static function addRoute($method, $url, $callback)
    {
        if (self::$prefix) {
            $url = '/' . trim(self::$prefix, '/') . '/' . trim($url, '/');
        }

        self::$routes[$method][$url] = [
            'callback' => $callback,
            'middleware' => self::$middleware
        ];
    }

    public static function match($url, $method)
    {

        if (array_key_exists($method, self::$routes)) {
            foreach (self::$routes[$method] as $route => $routeData) {
                if ($url === $route) {
                    $callback = $routeData['callback'];
                    $middleware = $routeData['middleware'];

                    if (!is_array($callback) && !is_string($callback)) {
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

                            foreach ($middleware as $m) {
                                $middlewareClass = 'OptimMVC\\app\\middlewares\\' . $m;
                                if (class_exists($middlewareClass)) {
                                    $middlewareObj = new $middlewareClass();
                                    $middlewareObj->handle(new Request(), $controller, $action);
                                } else {
                                    throw new \Exception("Middleware {$m} not found");
                                }
                            }

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
