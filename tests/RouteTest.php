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
        $this->assertMiddlewareRunsBeforeHandler('GET');
    }

    public function test_route_runs_middleware_before_handler_POST() {
        $this->assertMiddlewareRunsBeforeHandler('POST');
    }

    public function test_route_runs_middleware_before_handler_PUT() {
        $this->assertMiddlewareRunsBeforeHandler('PUT');
    }

    public function test_route_runs_middleware_before_handler_DELETE() {
        $this->assertMiddlewareRunsBeforeHandler('DELETE');
    }

    private function makeMiddleware(array &$events): object {
        return new class(function () use (&$events) {
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
    }

    private function makeHandler(array &$events): Closure {
        return function () use (&$events) {
            $events[] = 'handler';
            return 'handled';
        };
    }

    private function assertMiddlewareRunsBeforeHandler(string $method): void {
        $events = [];
        $middleware = $this->makeMiddleware($events);

        $route = new Route($method, '/users', $this->makeHandler($events));
        $route->middlewares[] = $middleware;
        $route->handle();

        $this->assertSame([$middleware], $route->middlewares);
        $this->assertSame(['middleware', 'handler'], $events);
    }
}