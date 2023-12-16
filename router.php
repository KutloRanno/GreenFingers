<?php

require 'controllers/AuthController.php';
require 'controllers/StockController.php';
require 'controllers/ProductController.php';
require 'controllers/BankController.php';

//$da = new DataAccess();

session_start();
$route = $_GET['route'] ?? 'home';

try {


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
        case 'prepmovementdetails':
            $stockController = new StockController();
            $stockController->PrepMovementDetails();
            break;
        case 'movestock':
            $stockController = new StockController();
            $stockController->MoveStock();
            break;
        case 'logout':
            $authController = new AuthController();
            $authController->logout();
            break;
        case 'preppurchase':
            $productController = new ProductController();
            $productController->prepPurchase();

        case 'addaccno':
            $bankController = new BankController();
            $bankController->addBankAccount();
        default:
            // Handle 404 or redirect to home
            break;
    }
}catch (Exception $ex){
    print($ex->getMessage());
}
