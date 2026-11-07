<?php

namespace FW\Http\Middleware;

class TestAnotherMiddleware {
    public function handle(): void {
        echo 'MW Two';
    }
}