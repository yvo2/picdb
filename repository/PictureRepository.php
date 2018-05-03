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

        if (!$result) {
            return 1;
        }

        return $result->fetch_object()->Id + 1;
    }
}