<?php

namespace FW\Http;

class Route {
    /**
     * @var string $method
     * @var string $path
     * @var array $middlewares
     */
    public string $method;
    public string $path;
    public array $middlewares;
    public mixed $handler;

    public function __construct(string $method, string $path, $handler) {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
        $this->middlewares = [];
    }

    public function handle()  {
        if ($this->method !== $_SERVER['REQUEST_METHOD']) {
            http_response_code(405);
            die('Method not allowed');
        }


        foreach ($this->middlewares as $middleware) {
            $middleware->handle();
        }

        return ($this->handler)();
    }
}