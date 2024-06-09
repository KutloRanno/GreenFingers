<?php

include_once './DataAccess.php';
include_once './helpers.php';
class ProductController
{
    public function PrepPurchase()
    {
        try
        {
            //get username from session
            $username = $_SESSION['fullUsername']??'';
            $key = array_keys($_POST);
            $key = $key[0];

            // Define the regex pattern to get stock quantity stockId and store number

            // Match numeric portions with up to 7 digits
            preg_match_all('/\d{1,7}/', $key, $matches);

            // Extract the matched numeric portions
            $numericPortions = $matches[0];

            $stockQuantity = $numericPortions[0];
            $stockId=$numericPortions[1];
            $storeId =$numericPortions[2];

            //redirect to products view and pass variables to the url
            header("Location: productPurchaseView.php?stockQuantity=$stockQuantity&stockId=$stockId&storeId=$storeId&username=$username");
            exit();
        }
        catch(Exception $ex)
        {
            //set error message in session state
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error");

            //redirect to same page again
            header("Location: productsView.php");
            exit();
        }
    }

    public function PurchaseProduct()
    {
        try
        {
            $da =new DataAccess();
            $helpers =new Helpers();


            //get purchase details from url
            $accNo=$_REQUEST['accNo']??"0";
            $stockId=$_REQUEST['stockId'];
            $storeId =$_REQUEST['storeId'];
            $desiredQuantity=$_REQUEST['desiredQuantity'];

            if($accNo==="0") throw new Exception("Please pick your account number to proceed with purchase");

            //call my stored procedure for making Purchases and pass purchase info as parameters
            $sequel= "CALL MakePurchase(?,?,?,?)";

            $arrParams=array($stockId, $accNo, $desiredQuantity, $storeId);

            $result = $da->ExecuteCommand($sequel,$arrParams);

            //check success
            if(!$result>0) throw new Exception("Could not buy the product. Reload page and try again");

            //set success message in state
            $helpers->SetSuccessorOrErrorState("Product bought. You are the owner now!","info","pdpv");
            header("Location: productsView.php");
            exit();
        }
        catch(Exception $ex)
        {
            //set error message in state
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","pdpv");

            //redirect to same page again
            header("Location: productPurchaseView.php?stockId=$stockId&storeId=$storeId&stockQuantity=$desiredQuantity");
            exit();
        }
    }
}