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

    public function add($currentPictureId, $galleryId)
    {
        $prepared = $this->db->prepare("INSERT INTO $this->table (Id, Gallery_id) VALUES (?, ?)");
        $prepared->bind_param('ii', $currentPictureId, $galleryId);
        $response = $prepared->execute();

        var_dump($response);

        return $response;
    }
}