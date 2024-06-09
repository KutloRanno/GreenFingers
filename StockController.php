<?php
require_once './DataAccess.php';
require_once './helpers.php';

$data = new DataAccess();

class StockController
{

    public function PrepMovementDetails(): void
    {
        $helpers = new Helpers();
        try
        {

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

            header("Location: stockMovementView.php?stockQuantity=$stockQuantity&stockId=$stockId&storeId=$storeId");
            exit();
        }
        catch(Exception $ex)
        {
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","stv");
            header("Location: stockLevelsView.php");
            exit();
        }

    }

    public function MoveStock()
    {
        $da = new DataAccess();
        $helpers=new Helpers();
        try
        {

            //now fetch movement details here
            $storeFromId=$_POST['storeId'];
            $storeToId=$_POST['storeToId'];
            $storeFromName=$_POST['storename'];
            $moveQuantity=$_POST['quantity'];
            $maxMoveQuantity=$_POST['stocklevel'];
            $stockId=$_POST['stockId'];

            if($moveQuantity>$maxMoveQuantity) throw new Error('Cannot move more than available stock!');
            if($storeFromId == $storeToId) throw new Exception("You cannot move stock within the same store !!");

            //now make a call to my stored Procedure in my database

            $sql = 'CALL UpdateStoreId(?,?,?,?)';
            $arrParams=array($stockId, $storeFromId, $storeToId, $moveQuantity);

            $result = $da->ExecuteCommand($sql,$arrParams);

            //test if logged in
            if(!$result>0) throw new Exception("Could not move products reload page and try again in a minute");

            $helpers->SetSuccessorOrErrorState("Stock move success!","info","stv");

            header('Location: stockLevelsView.php');

        }
        catch(Exception $ex)
        {
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","stv");
            header("Location: stockLevelsView.php");
        }
    }
}