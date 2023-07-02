<?php

namespace App\Classes;

use Exception;

class Router
{
    private $routes = [];

    function __construct()
    {
        $this->routes['GET'] = [];
        $this->routes['POST'] = [];
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function init()
    {
        try {
            $uri = parse_url($_SERVER['REQUEST_URI'])["path"];
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            $routes = $this->getRoutes();

            if (!isset($routes[$requestMethod])) {
                throw new Exception("A rota não existe");
            }

            if (!array_key_exists($uri, $routes[$requestMethod])) {
                throw new Exception("A rota não existe teste");
            }

            $controller = $routes[$requestMethod][$uri];
            $controller();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function newRouter($method, $uri, $controller, $action, $middleware = '')
    {
        $this->routes[$method][$uri] = fn () => $this->loadRouter($controller, $action, $middleware);
    }

    public function loadRouter($controller, $action, $middleware)
    {
        if ($middleware !== '' && $middleware !== null) {
            $this->checkIfMiddlewareExists($middleware);
            $middlewareInstance = $this->newMiddlewareInstance($middleware);
            new $middlewareInstance();
        }
        $this->checkIfControllerExists($controller);
        $controllerInstance = $this->newControllerInstance($controller);
        $this->checkIfActionExists($controllerInstance, $action);

        return $controllerInstance->$action();
    }

    public function newMiddlewareInstance($middleware)
    {
        $middlewareNamespace = "App\\Http\\Middlewares\\{$middleware}";
        $middlewareInstance = new $middlewareNamespace();
        return $middlewareInstance;
    }

    public function newControllerInstance($controller)
    {
        $constrollerNamespace = "App\\Http\\Controllers\\{$controller}";
        $controllerInstance = new $constrollerNamespace();
        return $controllerInstance;
    }

    public function checkIfMiddlewareExists($middleware)
    {
        $middlewareNamespace = "App\\Http\\Middlewares\\{$middleware}";
        if (!class_exists($middlewareNamespace)) {
            throw new Exception("A middleware {$middleware} não existe.");
        }
    }

    public function checkIfControllerExists($controller)
    {
        $constrollerNamespace = "App\\Http\\Controllers\\{$controller}";
        if (!class_exists($constrollerNamespace)) {
            throw new Exception("O controller {$controller} não existe.");
        }
    }

    public function checkIfActionExists($controllerInstance, $action)
    {
        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("O método {$action} não existe.");
        }
    }
}
