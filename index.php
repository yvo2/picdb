<?php
session_start();

require_once 'lib/Dispatcher.php';
require_once 'config/config.php';
require_once 'database/ConnectionManager.php';

// Initialize DB
global $config;
ConnectionManager::initialize($config['database']['host'], $config['database']['username'], $config['database']['password'], $config['database']['database']);

$dispatcher = new Dispatcher();
$dispatcher->dispatch();