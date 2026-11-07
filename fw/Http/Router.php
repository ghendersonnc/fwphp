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
    /**
     * @var array
     */
    private array $middlewares = [];

    public function middleware($middlewares = []): Router {
        $this->middlewares = $middlewares;
        return $this;
    }

    public function prefix(string $prefix, Closure $callback = null): Router {
        $callback($this, $prefix);
        return $this;
    }

    public function get(string $path, $handler,): Router {
        $this->createRoute($path, $handler, 'GET');
        return $this;
    }

    public function post(string $path, $handler): Router {
        $this->createRoute($path, $handler, 'POST');
        return $this;
    }

    public function put(string $path, $handler): Router {
        $this->createRoute($path, $handler, 'PUT');
        return $this;
    }

    public function delete(string $path, $handler): Router {
        $this->createRoute($path, $handler, 'DELETE');
        return $this;
    }

    public function route(): void {
        $route = $this->routes[REQUEST->method][REQUEST->endpoint] ?? null;

        if (!$route) {
            $this->tryForMethodNotAllowed();
            http_response_code(404);
            die('Not Found');
        }

        $route->handle();
    }

    private function createRoute(string $path, $handler, $method): void {
        $path = $this->trimSlashes($path);

        $this->routes[$method][$path] = new Route($method, $path, $handler);

        foreach ($this->middlewares as $middleware) {
            $this->routes[$method][$path]->middlewares[] = $middleware;
        }

    }

    private function trimSlashes($path): string {
        $path = rtrim($path, '/');
        $path = ltrim($path, '/');
        $path = preg_replace('/\/+/', '/', $path);

        return '/' . $path;
    }

    private function tryForMethodNotAllowed(): void {
        $methods = array_diff(['GET', 'POST', 'PUT', 'DELETE'], [REQUEST->method]);
        foreach ($methods as $method) {
            $route = $this->routes[$method][REQUEST->endpoint] ?? null;
            if ($route) {
                http_response_code(405);
                die('Method Not Allowed');
            }
        }
    }

}