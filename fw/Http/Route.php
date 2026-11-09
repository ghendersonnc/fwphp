<?php

namespace FW\Http;

class Route {
    public array $middlewares;
    public $handler;

    public function __construct(public readonly string $method, public readonly string $path, callable $handler) {
        $this->handler = $handler;
        $this->middlewares = [];
    }

    public function handle(): void {
        array_reduce(array_reverse($this->middlewares), fn($handler, $middleware) => fn() => $middleware->handle($handler), $this->handler)();
    }
}