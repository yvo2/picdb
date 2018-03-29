<?php

class Gallery {

    function index($view) {
        $view->setName("Gallery");
    }

    function create($view) {
        $view->setName("Gallery_create");
    }

}