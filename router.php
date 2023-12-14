<?php

require 'controllers/AuthController.php';
require 'controllers/StockController.php';

//$da = new DataAccess();

session_start();
$route = $_GET['route'] ?? 'home';
//$GLOBALS['app_data'] = $da->GetDataSql("select stockId as 'Stock ID', stockTypeName as 'Stock Type',prodName as 'Stock Name', prodDescription as 'Description', Quantity ,prodCost as 'Cost per unit (P)', storeName as 'Store Name',CONCAT('<input type=''submit'' name=''btnmovestock|', stockId, '_', storeId,''' value=''MOVE STOCK''>')
//                from StockLevelByStore_view;");

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
    case 'getmovementdetails':
        $stockController = new StockController();
        $stockController->GetMovementDetails();

    case 'movestock':
        $stockController=new StockController();
        $stockController->MoveStock();
    default:
        // Handle 404 or redirect to home
        break;
}

