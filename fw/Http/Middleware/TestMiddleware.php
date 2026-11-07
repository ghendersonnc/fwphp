<?php

namespace FW\Http\Middleware;

class TestMiddleware {
    public function handle(): void {
        echo 'MW One';
    }
}