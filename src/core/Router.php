<?php

namespace Src\Core;

class Router {
    private $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $path = rtrim($path, '/') ?: '/';
        
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptDir !== '/' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
            $path = rtrim($path, '/') ?: '/';
        }

        if (isset($this->routes[$method][$path])) {
            $callback = $this->routes[$method][$path];

            if (is_array($callback)) {
                $controller = new $callback[0];
                $action = $callback[1];
                return $controller->$action();
            }

            if (is_callable($callback)) {
                return $callback();
            }
        }

        // 404
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
    }
}
