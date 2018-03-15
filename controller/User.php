<?php

class User {

    public function login($view) {
        $view->setName('User_login');
        $view->invalid = false;
        $view->validationErrors = array();
        @$email = $_POST["email"];
        @$password = $_POST["password"];
        $view->email = $email;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userRepository = new UserRepository();
            if (!isset($email) || strlen($email) == 0) {
                $view->invalid = true;
                array_push($view->properties['validationErrors'], "Bitte gib eine valide Email-Adresse ein.");
            }
            if (!isset($password) || strlen($password) == 0) {
                $view->invalid = true;
                array_push($view->properties['validationErrors'], "Bitte gib ein valides Passwort ein.");
            }
            if (!$userRepository->checkCredentials($email, $password) && !$view->invalid) {
                $view->invalid = true;
                array_push($view->properties['validationErrors'], "Die Email-Passwort-Kombination ist nicht korrekt.");
            }
            if (!$view->invalid) {
                $sessionHandler = new SessionManager();
                var_dump($sessionHandler->isSignedIn());
                $user = $userRepository->getByCredentials($email, $password);
                $sessionHandler->signInAsId($user->id);
                global $config;
                $path = $config["path"];
                header("Location:{$path}user?blogId=" . $user->id);
                die("Login successfull.");
            }
        }
    }

}