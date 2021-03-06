<?php

class ConnectionManager
{
    private static $mysqli;

    public static function initialize($host, $user, $pass, $db) {
        ConnectionManager::$mysqli = new mysqli($host, $user, $pass, $db);
    }

    public static function obtainConnection() {
        return ConnectionManager::$mysqli;
    }

}