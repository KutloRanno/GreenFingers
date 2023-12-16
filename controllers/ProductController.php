<?php

include_once './DataAccess.php';
include_once './helpers.php';
class ProductController
{
    public function prepPurchase()
    {
        try
        {
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

            header("Location: views/productPurchaseView.php?stockQuantity=$stockQuantity&stockId=$stockId&storeId=$storeId&username=$username");

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}