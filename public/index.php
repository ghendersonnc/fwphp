<?php
require __DIR__ . '/../vendor/autoload.php';

use FW\Http\Controllers\HomeController;
use FW\Http\Controllers\PostController;
use FW\Http\Controllers\RandomController;
use FW\Http\Middleware\TestAnotherMiddleware;
use FW\Http\Middleware\TestMiddleware;
use FW\Http\Request;
use FW\Http\Router;

const REQUEST = new Request();

$router = new Router();


$router->middleware([new TestMiddleware()])->get('/', [new HomeController(), 'index']);
$router->middleware([new TestAnotherMiddleware()])->get('/random', [new RandomController(), 'index']);

$router->middleware([new TestMiddleware(), new TestAnotherMiddleware()])->prefix('/post', function (Router $router, string $prefix) {
    $router->get($prefix, [new PostController(), 'getHandler']);
    $router->post($prefix, [new PostController(), 'postHandler']);
    $router->put($prefix, [new PostController(), 'putHandler']);
    $router->delete($prefix, [new PostController(), 'deleteHandler']);
    $router->get($prefix . '/place', [new PostController(), 'placeHandler']);
});

$router->route();