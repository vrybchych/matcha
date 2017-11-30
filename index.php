<?php
// FRONT CONTROLLER

// 1. main settings
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

// 2. include system files
    define('ROOT', dirname(__FILE__));
    require_once (ROOT.'/components/Autoload.php');

// 3. DB connect
    DB::setup();

// 4. call router
    session_start();
    $router = new Router();
    $router->run();