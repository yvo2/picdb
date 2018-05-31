<?php

set_error_handler("customError");

function customError($errno, $errstr) {
    $viewCompatMode = true;

    require_once "view/Header.php";

    if (strpos($errstr, 'HY000/2002') !== false) {
        printError("Die Verbindung zu der Datenbank ist fehlgeschlagen. Bitte versuchen sie es später erneut.");
    } else {
        printError("Unbekannter Fehler. Bitte Kontaktieren Sie die Betreiber oder versuchen sie es später erneut.");
    }

    require_once "view/Footer.php";
    die();
}

function printError($msg) {
    echo "<div class='content'><h1>Systemfehler</h1><p>Es ist ein Fehler auf dem Server aufgetreten.</p><p>$msg</p></div>";
}