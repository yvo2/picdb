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

    public function add($currentPictureId, $galleryId, $description) {
        $prepared = $this->db->prepare("INSERT INTO $this->table (Id, Gallery_id, Description) VALUES (?, ?, ?)");
        $prepared->bind_param('iis', $currentPictureId, $galleryId, $description);
        $response = $prepared->execute();

        return $response;
    }

    public function getAllPictures($galleryId) {
        $prepared = $this->db->prepare("SELECT * FROM $this->table WHERE Gallery_id = ?");
        $prepared->bind_param('s', $galleryId);
        $prepared->execute();
        $result = $prepared->get_result();

        $pictures = array();

        while ($row = $result->fetch_assoc()) {
            $row["Description"] = htmlspecialchars($row["Description"]);

            $pictures[] = $row;
        }

        return $pictures;
    }

    public function delete($id) {
        $prepared = $this->db->prepare("DELETE FROM $this->table WHERE Id = ?");
        $prepared->bind_param('i', $id);
        $response = $prepared->execute();

        return $response;
    }

    public function updateDescription($id, $description) {
        $prepared = $this->db->prepare("UPDATE $this->table SET Description = ? WHERE Id = ?");
        $prepared->bind_param('si', $description, $id);
        $prepared->execute();
    }
}