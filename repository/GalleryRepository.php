<?php
require_once 'lib/Repository.php';

class GalleryRepository extends Repository
{
    function __construct()
    {
        parent::__construct("gallery");
    }

    public function create($user, $name) {
        $prepared = $this->db->prepare("INSERT INTO $this->table (Name, User_Id) VALUES (?, ?)");
        $prepared->bind_param('si', $name, $user->Id);

        $prepared->execute();

        return $prepared->insert_id;
    }

    public function getByUser($user) {
        $prepared = $this->db->prepare("SELECT Name, Id FROM $this->table WHERE User_Id = ?;");
        $prepared->bind_param('i', $user->Id);

        $prepared->execute();

        $result = $prepared->get_result();

        $galleries = array();

        while($row = $result->fetch_assoc()) {
            //XSS prevention
            $row["Name"] = htmlspecialchars($row["Name"]);

            $galleries[] = $row;
        }

        return $galleries;
    }

}