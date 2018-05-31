<?php

class ImageTools
{
    function createThumbnail($src, $dest, $desired_width) {
        $mime_type = image_type_to_mime_type(exif_imagetype($src));
        switch($mime_type) {
            case 'image/jpeg':
            case 'image/jpg':
                $source_image = imagecreatefromjpeg($src);
                break;
            case 'image/png':
                $source_image = imagecreatefrompng($src);
                break;
            case 'image/gif':
                $source_image = imagecreatefromgif($src);
                break;
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }
}