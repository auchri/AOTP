<?php

use AOTP\FrontController;
use AOTP\Router;

require_once 'config/main.php';

$router = new Router();

try {
    $router->routeFromActualUri();
    FrontController::getInstance()->printPage();
} catch (Exception $e) {
    echo $e->getMessage();
}