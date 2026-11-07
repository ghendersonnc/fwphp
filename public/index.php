<?php
require __DIR__ . '/../vendor/autoload.php';

use FW\Http\Controllers\HomeController;
use FW\Http\Controllers\PostController;
use FW\Http\Middleware\TestAnotherMiddleware;
use FW\Http\Middleware\TestMiddleware;
use FW\Http\Request;
use FW\Http\Router;

const REQUEST = new Request();

$router = new Router();

$router->get('/', [new HomeController(), 'index'], [new TestAnotherMiddleware(), new TestMiddleware()]);
$router->get('/post', [new PostController(), 'getHandler'], [new TestAnotherMiddleware()]);
$router->post('/post', [new PostController(), 'postHandler']);
$router->put('/post', [new PostController(), 'putHandler']);
$router->delete('/post', [new PostController(), 'deleteHandler']);
$router->route();