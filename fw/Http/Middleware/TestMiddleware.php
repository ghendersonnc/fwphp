<?php

namespace FW\Http\Middleware;

class TestMiddleware {

    public function handle(callable $next): void {
        echo 'MW One';
        $next();
    }
}