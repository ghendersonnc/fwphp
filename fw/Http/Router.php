<?php

namespace FW\Http;

use Closure;

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

    public function prefix(string $prefix, Closure $callback): void {
        $callback($this, $prefix);
    }

    public function get(string $path, $handler, $middlewares = []): Route {
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
        $endpoint = explode('?', $_SERVER['REQUEST_URI'])[0];
        $methods = array_diff(['GET', 'POST', 'PUT', 'DELETE'], [REQUEST->method]);
        $route = $this->routes[REQUEST->method][$endpoint] ?? null;

        if (!$route) {

            foreach ($methods as $method) {
                $route = $this->routes[$method][$endpoint] ?? null;
                if ($route) {
                    http_response_code(405);
                    die('Method Not Allowed');
                }
            }

            http_response_code(404);
            die('Not Found');
        }

        $route->handle();
    }

    private function createRoute(string $path, $handler, $method, $middlewares): Route {
        $path = $this->trimSlashes($path);

        $this->routes[$method][$path] = new Route($method, $path, $handler);

        foreach ($middlewares as $middleware) {
            $this->routes[$method][$path]->middlewares[] = $middleware;
        }

        return $this->routes[$method][$path];
    }

    private function trimSlashes($path): string {
        $path = rtrim($path, '/');
        $path = ltrim($path, '/');
        $path = preg_replace('/\/+/', '/', $path);

        return '/' . $path;
    }


}