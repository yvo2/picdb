<?php

class RootView {

    private $subView;

    public function __construct($subView) {
        $this->subView = $subView;
    }

    public function display() {
        require 'view/Header.php';
        $this->subView->display();
        require 'view/Footer.php';
    }
}

?>