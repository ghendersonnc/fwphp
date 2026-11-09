<?php

namespace FW\Http\Controllers;

class PostController {
    public function getHandler(): void {
        echo 'HELLO GET';
    }

    public function postHandler(): void {
        echo 'HELLO POST';
    }

    public function putHandler(): void {
        echo 'HELLO PUT';
    }

    public function deleteHandler(): void {
        echo 'HELLO DELETE';
    }

    public function placeHandler(): void {
        echo 'HELLO PLACE';
    }
}