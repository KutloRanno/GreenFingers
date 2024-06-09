<?php

require 'AuthController.php';
require 'StockController.php';
require 'ProductController.php';
require 'BankController.php';

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
            $productController->PrepPurchase();
            break;
        case 'purchaseproduct':
            $productController =new ProductController();
            $productController->PurchaseProduct();
            break;
        case 'addaccno':
            $bankController = new BankController();
            $bankController->addBankAccount();
            break;
        default:
            // Handle 404 or redirect to home
            break;
    }
}catch (Exception $ex){
    print($ex->getMessage());
}
