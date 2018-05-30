<?php
require_once './repository/GalleryRepository.php';
require_once './repository/PictureRepository.php';
require_once './lib/SessionManager.php';
require_once './config/config.php';
require_once './tools/ImageTools.php';

class Gallery {

    function index($view) {
        $view->login();

        $view->setName("Gallery");

        $galleryRepository = new GalleryRepository();
        $sessionManager = new SessionManager();

        $view->galleries = $galleryRepository->getByUser($sessionManager->getUser());
    }

    function create($view) {
        $view->login();

        $view->setName("Gallery_create");
        $view->galleryValidation = "";
        $view->valid = true;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            @$name = $_POST["name"];
            @$description = $_POST["description"];

            if (strlen($name) < 4) {
                $view->galleryValidation = "Der Name muss grösser als 4 Zeichen sein.";
                $view->valid = false;
            }
            if (strlen($name) > 32) {
                $view->galleryValidation = "Der Name muss kürzer als 32 Zeichen sein.";
                $view->valid = false;
            }
            if (strlen($description) > 1024) {
                $view->galleryValidation = "Die Beschreibung muss kürzer als 1024 Zeichen sein.";
            }

            if ($view->valid) {
                $galleryRepository = new GalleryRepository();
                $sessionManager = new SessionManager();

                $galleryRepository->create($sessionManager->getUser(), $name, $description);
                header("Location: /Gallery");
                die("Gallery created.");
            }
        }
    }

    function single($view) {
        $view->login();
        $view->setName("Gallery_single");

        $sessionManager = new SessionManager();
        $galleryRepository = new GalleryRepository();
        $pictureRepository = new PictureRepository();

        $gallery = $galleryRepository->readById($_GET['id'])->fetch_object();

        if ($gallery->User_Id == $sessionManager->getUser()->Id) {
            $view->gallery = $gallery;
            $view->pictures = $pictureRepository->getAllPictures($gallery->Id);
            return;
        } else {
            $view->noAccess();
        }
    }

    function upload($view) {
        $view->login();
        $view->setName("Gallery_upload");

        $sessionManager = new SessionManager();
        $galleryRepository = new GalleryRepository();

        $gallery = $galleryRepository->readById($_GET['id'])->fetch_object();

        if ($gallery->User_Id == $sessionManager->getUser()->Id) {
            $view->gallery = $gallery;
            return;
        } else {
            $view->noAccess();
        }
    }

    function delete($view) {
        $view->login();
        $view->setName("Gallery_delete");

        $sessionManager = new SessionManager();
        $galleryRepository = new GalleryRepository();

        $gallery = $galleryRepository->readById($_GET['id'])->fetch_object();

        if ($gallery->User_Id == $sessionManager->getUser()->Id) {
            $view->gallery = $gallery;
            return;
        } else {
            $view->noAccess();
        }
    }

    function doDelete($view) {
        $view->login();
        $id = $_POST["id"];

        $sessionManager = new SessionManager();
        $galleryRepository = new GalleryRepository();
        $pictureRepository = new PictureRepository();

        $gallery = $galleryRepository->readById($id)->fetch_object();

        if ($gallery->User_Id == $sessionManager->getUser()->Id) {
            $galleryRepository->delete($gallery->Id);
            header('Location: /Gallery');
            die();
        } else {
            $view->noAccess();
        }
    }

    function edit($view) {
        $view->login();
        $view->setName("Gallery_edit");

        $sessionManager = new SessionManager();
        $galleryRepository = new GalleryRepository();

        $gallery = $galleryRepository->readById($_GET['id'])->fetch_object();

        if ($gallery->User_Id == $sessionManager->getUser()->Id) {
            $view->gallery = $gallery;
            return;
        } else {
            $view->noAccess();
        }
    }

    function doEdit($view) {
        $view->login();

        $id = $_POST["id"];
        $name = $_POST["name"];
        $description = $_POST["description"];

        $sessionManager = new SessionManager();
        $galleryRepository = new GalleryRepository();

        $gallery = $galleryRepository->readById($id)->fetch_object();

        if ($gallery->User_Id == $sessionManager->getUser()->Id) {
            $galleryRepository->updateGallery($id, $name, $description);
            header("Location: /Gallery/single?id=" . $gallery->Id);
            die();
        } else {
            $view->noAccess();
            return;
        }
    }

    function doUpload($view) {
        $view->login();
        $view->setName("Gallery_doUpload");
        @$description = $_POST["description"];

        if (strlen($description) > 1024) {
            $view->galleryValidation = "Die Beschreibung muss kürzer als 1024 Zeichen sein.";
            $this->upload($view);
            return;
        }

        $sessionManager = new SessionManager();
        $galleryRepository = new GalleryRepository();
        $pictureRepository = new PictureRepository();

        $gallery = $galleryRepository->readById($_POST['galleryId'])->fetch_object();

        if ($gallery->User_Id != $sessionManager->getUser()->Id) {
            $view->noAccess();
            return;
        }

        global $config;
        $currentPictureId = $pictureRepository->nextId();
        $target_file = $config['datapath'] . "/" . $gallery->Id . "_" . $currentPictureId;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if($_FILES["picture"]["size"] > 4000000) {
            $view->galleryValidation = "Das Bild muss kleiner als 4MB sein (aktuelle Grösse: " . ($_FILES["picture"]["size"] / 1000000) . "MB)";
            die($view->galleryValidation);
            return;
        }

        if ($uploadOk & move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file . ".image")) {
            // Generate thumbnail
            $imageTools = new ImageTools();
            $imageTools->createThumbnail($target_file . ".image", $target_file . ".thumb.image", 200);

            $pictureRepository->add($currentPictureId, $gallery->Id, $description);

            header('Location: /Gallery/single?id='.$gallery->Id);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

}