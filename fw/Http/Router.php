<?php

namespace FW\Http;

class Router {
    /**
     * @var array<Route>
     */
    public array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    public function get(string $path,  $handler, $middlewares = []): Route {
        return $this->createRoute($path, $handler, 'GET', $middlewares);
    }

    public function post(string $path, $handler, $middlewares = []): Route {
        return $this->createRoute($path, $handler, 'POST', $middlewares);
    }

    public function put(string $path, $handler, $middlewares = []): Route {
        return $this->createRoute($path, $handler, 'PUT', $middlewares);
    }

    public function delete(string $path, $handler, $middlewares = []): Route {
        return $this->createRoute($path, $handler, 'DELETE', $middlewares);
    }

    public function route(): void {
        $route = explode('?', $_SERVER['REQUEST_URI'])[0];
        $x = $this->routes[REQUEST->method][$route] ?? null;

        if (!$x) {
            http_response_code(404);
            die('Not Found');
        }

        $x->handle();
    }

    private function createRoute(string $path, $handler, $method, $middlewares): Route {
        $this->routes[$method][$path] = new Route($method, $path, $handler);

        foreach ($middlewares as $middleware) {
            $this->routes[$method][$path]->middlewares[] = $middleware;
        }

        return $this->routes[$method][$path];
    }

}