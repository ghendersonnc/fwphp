<?php

namespace FW\Http;

class Request {
    public array $get;
    public array $post;
    public array $d;
    public string $method;

    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->d = [];
        $this->method = $_SERVER['REQUEST_METHOD'];
        unset($_GET);
        unset($_POST);
    }

    public function set(string $key, mixed $var): void {
        $this->d[$key] = $var;
    }
}