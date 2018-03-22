<?php

require_once './lib/Repository.php';
require_once './database/ConnectionManager.php';

class UserRepository extends Repository
{
    function __construct()
    {
        parent::__construct("User");
    }

    function getByCredentials($email, $password) {
        $password = hash("sha256", $password);

        $prepared = $this->db->prepare("SELECT * FROM User WHERE email = ? AND password = ?");
        $prepared->bind_param('ss', $email, $password);

        $prepared->execute();

        $result = $prepared->get_result();

        return $result;
    }

    function checkCredentials($email, $password) {
        $result = $this->getByCredentials($email, $password);

        return $result->num_rows != 0;
    }

    function existsEmail($email) {
        $prepared = $this->db->prepare("SELECT * FROM $this->table WHERE email = ?");
        $prepared->bind_param('s', $email);

        $prepared->execute();

        $result = $prepared->get_result();
        return $result->num_rows != 0;
    }

    public function create($email, $password) {
        $password = hash ("sha256" , $password);
        $prepared = $this->db->prepare("INSERT INTO $this->table (email, password) VALUES (?, ?)");
        $prepared->bind_param('ss', $email, $password);

        $prepared->execute();

        return $prepared->insert_id;
    }

}