<?php

define('ROOT', dirname(__DIR__));   // 'E:\WWW\SSMS'
define('DS', DIRECTORY_SEPARATOR);  // '\' or '/' depend on os

if (isset($_GET['route'])) {
    $route = $_GET['route'];
}

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'Application.php');

new Application();