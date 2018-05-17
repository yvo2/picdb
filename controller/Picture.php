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

        $path = $config["datapath"]."\\".$gallery->Id."_".$picture->Id;

        $extension = $thumb ? ".thumb.image" : ".image";

        $image = file_get_contents($path . $extension);

        $image_mime = image_type_to_mime_type(exif_imagetype($path.$extension));
        header('Content-type: '.$image_mime);

        echo $image;
        die();
    }

}