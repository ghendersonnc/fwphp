<?php


use FW\Http\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase {

    public function test_route_contains_its_parameters_and_handler() {
        $handler = function () {
        };
        $route = new Route('GET', '/users', $handler);

        $this->assertSame('GET', $route->method);
        $this->assertSame('/users', $route->path);
        $this->assertSame($handler, $route->handler);
        $this->assertSame([], $route->middlewares);
    }

    public function test_route_runs_middleware_before_handler_GET() {
        $events = [];
        $middleware = new class(function () use (&$events) {
            $events[] = 'middleware';
        }) {
            private $callback;

            public function __construct(callable $callback) {
                $this->callback = $callback;
            }

            public function handle(callable $next) {
                ($this->callback)();
                $next();
            }
        };
        $handler = function () use (&$events) {
            $events[] = 'handler';
            return 'handled';
        };
        $route = new Route('GET', '/users', $handler);
        $route->middlewares[] = $middleware;
        $route->handle();
        $this->assertSame([$middleware], $route->middlewares);
        $this->assertSame(['middleware', 'handler'], $events);
    }

    public function test_route_runs_middleware_before_handler_POST() {
        $events = [];
        $middleware = new class(function () use (&$events) {
            $events[] = 'middleware';
        }) {
            private $callback;

            public function __construct(callable $callback) {
                $this->callback = $callback;
            }

            public function handle(callable $next) {
                ($this->callback)();
                $next();
            }
        };
        $handler = function () use (&$events) {
            $events[] = 'handler';
            return 'handled';
        };
        $route = new Route('POST', '/users', $handler);
        $route->middlewares[] = $middleware;
        $route->handle();
        $this->assertSame([$middleware], $route->middlewares);
        $this->assertSame(['middleware', 'handler'], $events);
    }

    public function test_route_runs_middleware_before_handler_PUT() {
        $events = [];
        $middleware = new class(function () use (&$events) {
            $events[] = 'middleware';
        }) {
            private $callback;

            public function __construct(callable $callback) {
                $this->callback = $callback;
            }

            public function handle(callable $next) {
                ($this->callback)();
                $next();
            }
        };
        $handler = function () use (&$events) {
            $events[] = 'handler';
            return 'handled';
        };
        $route = new Route('PUT', '/users', $handler);
        $route->middlewares[] = $middleware;
        $route->handle();
        $this->assertSame([$middleware], $route->middlewares);
        $this->assertSame(['middleware', 'handler'], $events);
    }

    public function test_route_runs_middleware_before_handler_DELETE() {
        $events = [];
        $middleware = new class(function () use (&$events) {
            $events[] = 'middleware';
        }) {
            private $callback;

            public function __construct(callable $callback) {
                $this->callback = $callback;
            }

            public function handle(callable $next) {
                ($this->callback)();
                $next();
            }
        };
        $handler = function () use (&$events) {
            $events[] = 'handler';
            return 'handled';
        };
        $route = new Route('DELETE', '/users', $handler);
        $route->middlewares[] = $middleware;
        $route->handle();
        $this->assertSame([$middleware], $route->middlewares);
        $this->assertSame(['middleware', 'handler'], $events);
    }
}
