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
    private array $routesToBuild = [];

    public function middleware($middlewares = []): Router {
        $this->middlewares = $middlewares;
        return $this;
    }

    public function prefix(string $prefix, Closure $callback = null): Router {
        $callback($this, $prefix);
        return $this;
    }

    public function get(string $path, $handler): Router {
        return $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler): Router {
        return $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, $handler): Router {
        return $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, $handler): Router {
        return $this->addRoute('DELETE', $path, $handler);
    }

    public function route(): void {
        /**
         * @var Route $route
         */
        $route = $this->routes[REQUEST->method][REQUEST->endpoint] ?? null;

        if (!$route) {
            $this->tryForMethodNotAllowed();
            http_response_code(404);
            die('Not Found');
        }

        $route->handle();
    }

    public function build(): void {
        foreach ($this->routesToBuild as $route) {
            $this->createRoute($route['path'], $route['handler'], $route['method']);
        }

        $this->routesToBuild = [];
        $this->middlewares = [];
    }

    public function getRoutes(): array {
        $routesResult = [];
        foreach ($this->routes as $method => $routes) {
            foreach ($routes as $route) {
                $routesResult[] = $method . ' ' . $route->path;
            }
        }
        return $routesResult;
    }


    private function createRoute(string $path, $handler, $method): void {
        $path = $this->trimSlashes($path);

        $this->routes[$method][$path] = new Route($method, $path, $handler);

        $this->routes[$method][$path]->middlewares = $this->middlewares;
    }

    private function addRoute(string $method, string $path, $handler): Router {
        $this->routesToBuild[] = [
            'path' => $path,
            'handler' => $handler,
            'method' => $method
        ];
        return $this;
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