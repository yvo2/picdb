<?php

require_once 'repository/UserRepository.php';

class SessionManager {
    public function signInAsId($id) {
        $_SESSION["userId"] = $id;
    }
    public function isSignedIn() {
        return isset($_SESSION["userId"]);
    }
    public function getUser() {
        if (!$this->isSignedIn()) {
            $user = (object) array('signedIn' => false);
            return $user;
        }
        $userRepository = new UserRepository();
        $user = (object) $userRepository->readById($_SESSION["userId"]);
        $user->signedIn = true;
        return $user;
    }
}