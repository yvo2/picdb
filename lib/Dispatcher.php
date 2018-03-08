<?php

class Dispatcher {

    function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = strtok($uri);
        $uri = trim($uri,'/');

        $uriParts = explode('/', $uri);

        if (count($uriParts) == 0) {
            $controller = "DefaultController";
            $action = "index";
        } else if (count($uriParts) == 1) {
            $controller = $uriParts[0];
            $action = "index";
        } else if (count($uriParts) == 2) {
            $controller = $uriParts[0];
            $action = $uriParts[1];
        } else {
            return false;
        }

        return true;
    }
}