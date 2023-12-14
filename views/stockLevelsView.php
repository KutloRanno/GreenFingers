<?php

//include external files needed
include_once '../DataAccess.php';
include_once '../helpers.php';
$helpers = new Helpers();
$da = new DataAccess();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock Warehouse Report</title>
    <meta charset="utf-8"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<form name="StockWarehouseReport" id="StockWarehouseReport" method="POST" action="../router.php?route=getmovementdetails" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <h2>Stock Warehouse Report</h2>

        <?php

        try {

            $sql = "select stockId as 'Stock ID', stockTypeName as 'Stock Type',prodName as 'Stock Name', prodDescription as 'Description', Quantity ,prodCost as 'Cost per unit (P)', storeName as 'Store Name',CONCAT('<input type=''submit'' name=''btnmovestock|',Quantity,'_',stockId, '_', storeId,''' value=''MOVE STOCK''>')
                from StockLevelByStore_view;";
            $arrData = $da->GetData($sql);


            //load table
            $helpers->LoadHtmlTable($arrData);
        }
        catch(Exception $ex)
        {
            print($ex->getMessage());
        }
        ?>
    </fieldset>
</form>
</html>