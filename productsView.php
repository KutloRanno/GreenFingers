<?php

isset($_SESSION) || session_start();
if(isset($_SESSION['marker'])&&$_SESSION['marker']!=='pdpv') $_SESSION['message']=null;//clears message in session from other page

//include external files needed
include_once './DataAccess.php';
include_once './helpers.php';
$helpers = new Helpers();
$da = new DataAccess();
include './index.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <meta charset="utf-8"/>
</head>

<form name="Products" id="Products" method="POST" action="./router.php?route=preppurchase" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <h2>View Our Catalog</h2>

        <?php

        try {

            $sql = "select prodName as 'Product Name', StockTypeName as 'Product Type',prodName as 'Product Name', prodDescription as 'Description', Quantity as 'Available' ,prodCost as 'Cost per unit (P)', storeName as 'Store Name',CONCAT('<input type=''submit'' name=''btnbuyproduct|' ,Quantity,'_',stockId, '_', storeId,''' value=''Buy product''>') as 'Select'
                from StockLevelByStore_view;";
            $arrData = $da->GetData($sql);


            //load table
            $helpers->LoadHtmlTable($arrData);
        }
        catch(Exception $ex)
        {
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","pdpv");
        }
        ?>
    </fieldset>
    <label>
        <?php
        if(!isset($_SESSION['message'])||$_SESSION['message']==="") exit();
        $helpers->ShowMessage($_SESSION['message']);
        ?>
    </label>

</form>
</html>