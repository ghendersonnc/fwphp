<?php

namespace FW\Http\Middleware;

class TestAnotherMiddleware {
    public function handle(callable $next): void {
        echo 'MW Two';
        $next();
    }
}