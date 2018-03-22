<?php

class ConnectionManager
{
    private static $mysqli;

    public static function initialize($host, $user, $pass, $db) {
        ConnectionManager::$mysqli = new mysqli($host, $user, $pass, $db);

        if (ConnectionManager::$mysqli->connect_errno) {
            die("Connection to DB failed. Application halted.");
        }
    }

    public static function obtainConnection() {
        return ConnectionManager::$mysqli;
    }

}