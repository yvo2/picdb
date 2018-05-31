<?php
require_once 'lib/Repository.php';
require_once 'repository/UserRepository.php';
require_once 'repository/PictureRepository.php';
require_once 'config/config.php';

class GalleryRepository extends Repository
{
    function __construct()
    {
        parent::__construct("gallery");
    }

    public function create($user, $name, $description) {
        $prepared = $this->db->prepare("INSERT INTO $this->table (Name, User_Id, Description) VALUES (?, ?, ?)");
        $prepared->bind_param('sis', $name, $user->Id, $description);

        $prepared->execute();

        return $prepared->insert_id;
    }

    public function getByUser($user) {
        $prepared = $this->db->prepare("SELECT Name, Id, Description FROM $this->table WHERE User_Id = ?;");
        $prepared->bind_param('i', $user->Id);

        $prepared->execute();

        $result = $prepared->get_result();

        $galleries = array();

        while($row = $result->fetch_assoc()) {
            //XSS prevention
            $row["Name"] = htmlspecialchars($row["Name"]);
            $row["Description"] = htmlspecialchars($row["Description"]);

            $galleries[] = $row;
        }

        return $galleries;
    }

    public function updateGallery($id, $name, $description) {
        $prepared = $this->db->prepare("UPDATE $this->table SET Name = ?, Description = ? WHERE Id = ?");
        $prepared->bind_param('ssi', $name, $description, $id);
        $prepared->execute();
    }

    public function delete($id) {
        $pictureRepository = new PictureRepository();
        $images = $pictureRepository->getAllPictures($id);

        foreach($images as $image) {
            global $config;
            $path = $config["datapath"]."\\".$id."_".$image["Id"];
            unlink($path . ".image");
            unlink($path . ".thumb.image");
            $pictureRepository->delete($image["Id"]);
        }

        $prepared = $this->db->prepare("DELETE FROM $this->table WHERE Id = ?");
        $prepared->bind_param('i', $id);
        $response = $prepared->execute();

        return $response;
    }

    public function getAllGalleries($galleryId) {
        $prepared = $this->db->prepare("SELECT * FROM $this->table WHERE User_id = ?");
        $prepared->bind_param('s', $galleryId);
        $prepared->execute();
        $result = $prepared->get_result();

        $pictures = array();

        while ($row = $result->fetch_assoc()) {
            $row["Name"] = htmlspecialchars($row["Name"]);
            $row["Description"] = htmlspecialchars($row["Description"]);

            $pictures[] = $row;
        }

        return $pictures;
    }

}