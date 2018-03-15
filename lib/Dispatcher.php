<?php
require_once 'View.php';
require_once 'RootView.php';

/**
 * Class Dispatcher
 * Dispatches a request to the controller
 */
class Dispatcher {

    function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = strtok($uri);
        $uri = trim($uri,'/');

        $uriParts = explode('/', $uri);

        if (count($uriParts) == 0 || $uri == '') {
            $controller = "Home";
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

        require_once "controller/$controller.php";
        $ctrl = new $controller();

        $view = new View();
        $view = $ctrl->$action($view);

        $rtView = new RootView($view);
        $rtView->display();

        return true;
    }
}