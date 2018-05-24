<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.05.2018
 * Time: 08:46
 */

require_once 'lib/SessionManager.php';
require_once 'repository/PictureRepository.php';
require_once 'repository/GalleryRepository.php';
require_once 'config/config.php';

class Picture {

    public function single() {
        $id = $_GET["id"];
        @$thumb = $_GET["thumb"];

        $sessionManager = new SessionManager();
        $pictureRepository = new PictureRepository();
        $galleryRepository = new GalleryRepository();

        global $config;

        $picture = $pictureRepository->readById($id)->fetch_object();
        $gallery = $galleryRepository->readById($picture->Gallery_id)->fetch_object();

        if ($sessionManager->getUser()->Id != $gallery->User_Id) {
            die("No access");
        }

        $path = $config["datapath"]."\\".$gallery->Id."_".$picture->Id;

        $extension = $thumb ? ".thumb.image" : ".image";

        $image = file_get_contents($path . $extension);

        $image_mime = image_type_to_mime_type(exif_imagetype($path.$extension));
        header('Content-type: '.$image_mime);

        echo $image;
        die();
    }

    public function delete($view) {
        $id = $_GET["id"];

        $sessionManager = new SessionManager();
        $pictureRepository = new PictureRepository();
        $galleryRepository = new GalleryRepository();

        $picture = $pictureRepository->readById($id)->fetch_assoc();
        $gallery = $galleryRepository->readById($picture["Gallery_id"])->fetch_object();

        $view->picture = $picture;

        if ($sessionManager->getUser()->Id != $gallery->User_Id) {
            $view->noAccess();
            die();
        }

        $view->setName("Picture_delete");
    }

    public function doDelete($view) {
        $id = $_POST["id"];

        $sessionManager = new SessionManager();
        $pictureRepository = new PictureRepository();
        $galleryRepository = new GalleryRepository();

        $picture = $pictureRepository->readById($id)->fetch_assoc();
        $gallery = $galleryRepository->readById($picture["Gallery_id"])->fetch_object();

        if ($sessionManager->getUser()->Id != $gallery->User_Id) {
            $view->noAccess();
            die();
        }

        $pictureRepository->delete($id);

        global $config;
        $path = $config["datapath"]."\\".$gallery->Id."_".$picture["Id"];
        unlink($path . ".image");
        unlink($path . ".thumb.image");
        header("Location: /Gallery/single?id=".$gallery->Id);
        die();
    }

    public function edit($view) {
        $id = $_GET["id"];

        $sessionManager = new SessionManager();
        $pictureRepository = new PictureRepository();
        $galleryRepository = new GalleryRepository();

        $picture = $pictureRepository->readById($id)->fetch_assoc();
        $gallery = $galleryRepository->readById($picture["Gallery_id"])->fetch_object();

        $view->picture = $picture;

        if ($sessionManager->getUser()->Id != $gallery->User_Id) {
            $view->noAccess();
            die();
        }

        $view->setName("Picture_edit");
    }

    public function doEdit($view) {
        $id = $_POST["id"];
        $description = $_POST["description"];

        if (strlen($description) > 1024) {
            $view->galleryValidation = "Die Beschreibung muss kürzer als 1024 Zeichen sein.";
            return;
        }

        $sessionManager = new SessionManager();
        $pictureRepository = new PictureRepository();
        $galleryRepository = new GalleryRepository();

        $picture = $pictureRepository->readById($id)->fetch_assoc();
        $gallery = $galleryRepository->readById($picture["Gallery_id"])->fetch_object();

        $view->picture = $picture;

        if ($sessionManager->getUser()->Id != $gallery->User_Id) {
            $view->noAccess();
            die();
        }

        $pictureRepository->updateDescription($picture["Id"], $description);

        header("Location: /Gallery/single?id=".$gallery->Id);
        die();
    }

}