<?php

namespace FW\Http;

class Request {
    public array $get;
    public array $post;
    public array $d;
    public string $method;
    public string $endpoint;

    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->d = [];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->endpoint = explode('?', $_SERVER['REQUEST_URI'])[0];

        $this->endpoint = rtrim($this->endpoint, '/');
        $this->endpoint = ltrim($this->endpoint, '/');
        $this->endpoint = '/' . $this->endpoint;


        unset($_GET);
        unset($_POST);
        unset($_SERVER['REQUEST_URI']);
        unset($_SERVER['REQUEST_METHOD']);
    }

    public function set(string $key, mixed $var): void {
        $this->d[$key] = $var;
    }
}