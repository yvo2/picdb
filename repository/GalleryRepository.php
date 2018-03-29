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

}