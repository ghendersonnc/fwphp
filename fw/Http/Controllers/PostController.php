<?php

namespace FW\Http\Controllers;

class PostController {
    public function getHandler() {
        echo 'HELLO GET';
    }

    public function postHandler() {
        echo 'HELLO POST';
    }

    public function putHandler() {
        echo 'HELLO PUT';
    }

    public function deleteHandler() {
        echo 'HELLO DELETE';
    }
}