<?php
global $config;
// In der Variable $config werden alle Daten in einem Array gespeichert, welche für Benutzer- und Routenhandling wichtg sind.
$config = array(
    "deploy"    => 'live',
    "database" => array(
        "host"      => 'localhost:3306',
        "username"  => 'root',
        "password"  => '',
        "database"  => 'picdb'
    ),
    "datapath" => 'C:\newxampp\htdocs\picdb_pictures'
);
?>