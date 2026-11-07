<?php

use FW\Http\Request;
use FW\Http\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

    public function setUp(): void {
        parent::setUp();
    }

    public function test_get_route_created() {
        $router = new Router();
        $router->get('/test', function() {})->build();
        $this->assertContains('GET /test', $router->getRoutes());
    }

    public function test_post_route_created() {
        $router = new Router();

        $router->post('/test', function() {})->build();
        $this->assertContains('POST /test', $router->getRoutes());
    }

    public function test_put_route_created() {
        $router = new Router();

        $router->put('/test', function() {})->build();
        $this->assertContains('PUT /test', $router->getRoutes());
    }

    public function test_delete_route_created() {
        $router = new Router();

        $router->delete('/test', function() {})->build();
        $this->assertContains('DELETE /test', $router->getRoutes());
    }

    public function test_prefixed_routes_created_for_each_method() {
        $router = new Router();

        $router->prefix('/api', function(Router $router, string $prefix) {
            $router->get($prefix . '/users', function() {});
            $router->post($prefix . '/users', function() {});
            $router->put($prefix . '/users', function() {});
            $router->delete($prefix . '/users', function() {});
        })->build();

        $this->assertArrayHasKey('/api/users', $router->routes['GET']);
        $this->assertArrayHasKey('/api/users', $router->routes['POST']);
        $this->assertArrayHasKey('/api/users', $router->routes['PUT']);
        $this->assertArrayHasKey('/api/users', $router->routes['DELETE']);
    }
}
