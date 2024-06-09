<?php
isset($_SESSION)||session_start();
if(isset($_SESSION['marker'])&&$_SESSION['marker']!=='stv') $_SESSION['message']=null;//clears message in session from other page
//include external files needed
include_once './DataAccess.php';
include_once './helpers.php';
include_once 'index.php';
$helpers = new Helpers();
$da = new DataAccess();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock Warehouse Report</title>
    <meta charset="utf-8"/>
</head>

<form name="StockWarehouseReport" id="StockWarehouseReport" method="POST" action="./router.php?route=prepmovementdetails" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <h2>Stock Warehouse Report</h2>

        <?php

        try {

            $sql = "select stockId as 'Stock ID', stockTypeName as 'Stock Type',prodName as 'Stock Name', prodDescription as 'Description', Quantity ,prodCost as 'Cost per unit (P)', storeName as 'Store Name',CONCAT('<input type=''submit'' name=''btnmovestock|',Quantity,'_',stockId, '_', storeId,''' value=''MOVE STOCK''>') as 'Select'
                from StockLevelByStore_view;";
            $arrData = $da->GetData($sql);


            //load table
            $helpers->LoadHtmlTable($arrData);
        }
        catch(Exception $ex)
        {
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","stv");
        }
        ?>
        <label>
            <?php
            if(!isset($_SESSION['message'])||$_SESSION['message']==="") exit();
            $helpers->ShowMessage($_SESSION['message']);
            ?>
        </label>
    </fieldset>
</form>
</html>