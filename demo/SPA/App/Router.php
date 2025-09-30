<?php

namespace App;

class Router
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public  function routeToAction()
    {
        // Normalize request
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        error_log($method);
        error_log($uri);

        // Match route
        if (isset($this->routes[$method][$uri])) {
            [$class, $action] = $this->routes[$method][$uri];

            if (class_exists($class) && method_exists($class, $action)) {
                $controller = new $class();
                return $controller->$action();
            } else {
                http_response_code(500);
                echo "Controller or method not found: {$class}::{$action}";
                exit;
            }
        }

        // If not matched
        http_response_code(404);
        echo "404 Not Found: {$method} {$uri}";
    }
}