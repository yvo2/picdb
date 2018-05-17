<?php
require_once 'lib/Repository.php';

class PictureRepository extends Repository
{
    function __construct()
    {
        parent::__construct("picture");
    }

    function nextId() {
        $prepared = $this->db->prepare("SELECT Id FROM $this->table ORDER BY Id DESC LIMIT 1");
        $prepared->execute();
        $result = $prepared->get_result();

        if ($result->num_rows == 0) {
            return 1;
        }

        return $result->fetch_object()->Id + 1;
    }

    public function add($currentPictureId, $galleryId) {
        $prepared = $this->db->prepare("INSERT INTO $this->table (Id, Gallery_id) VALUES (?, ?)");
        $prepared->bind_param('ii', $currentPictureId, $galleryId);
        $response = $prepared->execute();

        return $response;
    }

    public function getAllPictures($galleryId) {
        $prepared = $this->db->prepare("SELECT * FROM $this->table WHERE Gallery_id = ?");
        $prepared->bind_param('s', $galleryId);
        $prepared->execute();
        $result = $prepared->get_result();

        $pictures = array();

        while ($row = $result->fetch_object()) {
            $pictures[] = $row;
        }

        return $pictures;
    }
}