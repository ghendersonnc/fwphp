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

    public function handle() {
        array_reduce(array_reverse($this->middlewares),  function ($handler, $middleware) {
            return function () use ($handler, $middleware) {
                return $middleware->handle($handler);
            };
        }, $this->handler)();
    }
}