<?php


use FW\Http\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase {

    public function test_route_contains_its_parameters_and_handler() {
        $handler = function() {};
        $route = new Route('GET', '/users', $handler);

        $this->assertSame('GET', $route->method);
        $this->assertSame('/users', $route->path);
        $this->assertSame($handler, $route->handler);
        $this->assertSame([], $route->middlewares);
    }

    public function test_route_runs_middlewares_before_handler_and_returns_handler_result() {
        $events = [];
        $middleware = new class(function() use (&$events) {
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
        $handler = function() use (&$events) {
            $events[] = 'handler';
            return 'handled';
        };
        $route = new Route('POST', '/users', $handler);
        $route->middlewares[] = $middleware;
        $route->handle();
        $this->assertSame([$middleware], $route->middlewares);
        $this->assertSame(['middleware', 'handler'], $events);
    }
}
