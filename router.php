<?php

require 'controllers/AuthController.php';
session_start();
$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'home':

        $authController = new AuthController();
        $authController->home();
        break;

    case 'register':
        $authController = new AuthController();
        $authController->register();
        break;
    case 'login':
//        require 'controllers/AuthController.php';
        $authController = new AuthController();
        $authController->login();
        break;
    // Add more routes as needed...
    default:
        // Handle 404 or redirect to home
        break;
}

