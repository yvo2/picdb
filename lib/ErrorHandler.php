<?php

set_error_handler("customError");

function customError($errno, $errstr) {
    if (error_reporting() == 0) {
        return;
    }

    global $viewCompatMode;
    $viewCompatMode = true;

    if (strpos($errstr, 'HY000/2002') !== false) {
        printError("Die Verbindung zu der Datenbank ist fehlgeschlagen. Bitte versuchen sie es später erneut.");
    } else {
        // Debug
        var_dump($errstr);
        printError("Unbekannter Fehler. Bitte Kontaktieren Sie die Betreiber oder versuchen sie es später erneut.");
    };
}

function printError($msg) {
    global $viewCompatMode;
    require_once "view/Header.php";
    echo "<div class='content'><h1>Systemfehler</h1><p>Es ist ein Fehler auf dem Server aufgetreten.</p><p>$msg</p></div><button class='btn btn-primary' onclick='history.back();'>Zurück</button>";
    require_once "view/Footer.php";
    die();
}