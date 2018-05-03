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

        $prepared = $this->db->prepare("SELECT * FROM User WHERE email = ?");
        $prepared->bind_param('s', $email);

        $prepared->execute();

        $result = $prepared->get_result()->fetch_object();

        $password = hash("sha256", $password . $result->salt);

        if ($result->Password == $password) {
            return $result;
        }

        return null;
    }

    function checkCredentials($email, $password) {
        $result = $this->getByCredentials($email, $password);

        return $result != null;
    }

    function existsEmail($email) {
        $prepared = $this->db->prepare("SELECT * FROM $this->table WHERE email = ?");
        $prepared->bind_param('s', $email);

        $prepared->execute();

        $result = $prepared->get_result();
        return $result->num_rows != 0;
    }

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function create($email, $password, $displayname) {
        $salt = $this->generateRandomString(20);

        $password = hash ("sha256" , $password . $salt);
        $prepared = $this->db->prepare("INSERT INTO $this->table (email, password, displayname, salt) VALUES (?, ?, ?, ?)");
        $prepared->bind_param('ssss', $email, $password, $displayname, $salt);

        $prepared->execute();

        return $prepared->insert_id;
    }

}