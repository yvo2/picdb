<?php

require_once 'lib/SessionManager.php';
require_once 'repository/UserRepository.php';

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
                $user = $userRepository->getByCredentials($email, $password);
                $sessionHandler->signInAsId($user->Id);
                header("Location:/User");
                die("Login successfull.");
            }
        }
    }

    public function register($view) {
        $userRepository = new UserRepository();
        $sessionManager = new SessionManager();
        $view->setName('User_register');
        $view->title = "Register";
        $view->valid = true;
        $view->email = '';
        $view->displayname = '';
        $view->emailValidationMessage = '';
        $view->passwordValidationMessage = '';
        $view->passwordValidationRepeatMessage = '';
        $view->displayNameValidationMessage = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            @$email = htmlspecialchars($_POST["rt-email"]);
            @$password = $_POST["rt-password"];
            @$passwordrepeat = $_POST["rt-password-repeat"];
            @$displayname = htmlspecialchars($_POST["rt-displayname"]);
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $view->emailValidationMessage = "Bitte eine valide Email-Addresse eingeben.";
                $view->valid = false;
            }
            if (strlen($password) < 8) {
                $view->passwordValidationMessage = "Bitte Passwort eingeben, welches mindestens 8 Zeichen lang ist.";
                $view->valid = false;
            }
            if (strlen($passwordrepeat) < 8) {
                $view->passwordValidationRepeatMessage = "Bitte das Passwort wiederholen.";
                $view->valid = false;
            }
            if (strlen($displayname) > 32) {
                $view->displayNameValidationMessage = "Bitte einen kürzeren Anzeigenamen verwenden (Maximal 32 Zeichen).";
                $view->valid = false;
            }
            if (strlen($displayname) < 4) {
                $view->displayNameValidationMessage = "Bitte längeren Anzeigenamen verwenden (Mindestens 5 Zeichen).";
                $view->valid = false;
            }
            if (!($passwordrepeat == $password)) {
                $view->passwordValidationRepeatMessage = "Bitte das Passwort korrekt wiederholen.";
                $view->valid = false;
            }
            if ($userRepository->existsEmail($email)) {
                $view->emailValidationMessage = "Diese Email-Addresse ist bereits vergeben.";
                $view->valid = false;
            }
            if ($view->valid) {
                try {
                    // Create user in database
                    $id = $userRepository->create($email, $password, $displayname);
                    $sessionManager->signInAsId($id);
                    header("Location: /User/registersuccess");
                    die('<a href="/User/registersuccess">Weiter.</a>');
                } catch (Exception $e) {
                    die('Ein Fehler ist aufgetreten.');
                }
            }
            $view->email = $email;
            $view->displayname = $displayname;
        }
    }

    public function registersuccess($view) {
        $view->setName('User_registersuccess');
    }

    public function index($view) {
        $view->setName('User');
        $view->login();

        $sessionManager = new SessionManager();
        $userRepository = new UserRepository();

        $user = $sessionManager->getUser();

        $view->displayname = htmlspecialchars($user->Displayname);
        $view->email = htmlspecialchars($user->Email);

        $view->valid = true;
        $view->emailValidationMessage = '';
        $view->passwordValidationMessage = '';
        $view->passwordValidationRepeatMessage = '';
        $view->displayNameValidationMessage = '';
        $view->changeSuccess = '';
        $view->passwordChangeSuccess = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            @$email = htmlspecialchars($_POST["rt-email"]);
            @$password = $_POST["rt-password"];
            @$passwordrepeat = $_POST["rt-password-repeat"];
            @$displayname = htmlspecialchars($_POST["rt-displayname"]);

            $wantsChangePassword = $password != "";

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $view->emailValidationMessage = "Bitte eine valide Email-Addresse eingeben.";
                $view->valid = false;
            }
            if (strlen($password) < 8 && $wantsChangePassword) {
                $view->passwordValidationMessage = "Bitte Passwort eingeben, welches mindestens 8 Zeichen lang ist.";
                $view->valid = false;
            }
            if (strlen($passwordrepeat) < 8 && $wantsChangePassword) {
                $view->passwordValidationRepeatMessage = "Bitte das Passwort wiederholen.";
                $view->valid = false;
            }
            if (strlen($displayname) > 32) {
                $view->displayNameValidationMessage = "Bitte einen kürzeren Anzeigenamen verwenden (Maximal 32 Zeichen).";
                $view->valid = false;
            }
            if (strlen($displayname) < 4) {
                $view->displayNameValidationMessage = "Bitte längeren Anzeigenamen verwenden (Mindestens 5 Zeichen).";
                $view->valid = false;
            }
            if (!($passwordrepeat == $password)) {
                $view->passwordValidationRepeatMessage = "Bitte das Passwort korrekt wiederholen.";
                $view->valid = false;
            }
            if ($userRepository->existsEmail($email) && $email != $user->Email) {
                $view->emailValidationMessage = "Diese Email-Addresse ist bereits vergeben.";
                $view->valid = false;
            }
            if ($view->valid) {
                try {
                    // Create user in database
                    $userRepository->changeInfo($user->Id, $email, $displayname);

                    $view->email = $email;
                    $view->displayname = $displayname;
                    $view->changeSuccess = "Deine Änderungen wurden gespeichert.";

                    if ($wantsChangePassword) {
                        $userRepository->changePassword($user->Id, $password);
                        $view->passwordChangeSuccess = "Dein neues Passwort wurde übernommen.";
                    }
                    return;
                } catch (Exception $e) {
                    die('Ein Fehler ist aufgetreten.');
                }
            }
            $view->email = $email;
            $view->displayname = $displayname;
        }
    }

    public function doDelete($view) {
        $view->login();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sessionManager = new SessionManager();
            $user = $sessionManager->getUser();

            $userRepository = new UserRepository();
            $userRepository->delete($user->Id);

            session_destroy();
            header("Location: /");
            die("Deleted!");
        }
    }

    public function logout($view) {
        session_destroy();
        header('Location: /');
        die('Logged out successfully');
    }
}