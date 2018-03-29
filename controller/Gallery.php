<?php
require_once './repository/GalleryRepository.php';
require_once './lib/SessionManager.php';

class Gallery {

    function index($view) {
        $view->login();

        $view->setName("Gallery");



    }

    function create($view) {
        $view->login();

        $view->setName("Gallery_create");
        $view->galleryValidation = "";
        $view->valid = true;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            @$name = $_POST["name"];

            if (strlen($name) < 4) {
                $view->galleryValidation = "Der Name muss grösser als 4 Zeichen sein.";
                $view->valid = false;
            }
            if (strlen($name) > 32) {
                $view->galleryValidation = "Der Name muss kürzer als 32 Zeichen sein.";
                $view->valid = false;
            }

            if ($view->valid) {
                $galleryRepository = new GalleryRepository();
                $sessionManager = new SessionManager();

                $galleryRepository->create($sessionManager->getUser(), $name);
                header("Location: /Gallery");
                die("Gallery created.");
            }
        }
    }

}