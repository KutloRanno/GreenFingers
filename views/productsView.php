<?php

//include external files needed
include_once '../DataAccess.php';
include_once '../helpers.php';
$helpers = new Helpers();
$da = new DataAccess();

var_dump($_SESSION);var_dump($_REQUEST);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <meta charset="utf-8"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<form name="Products" id="Products" method="POST" action="../router.php?route=preppurchase" >
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
            print($ex->getMessage());
        }
        ?>
    </fieldset>
</form>
</html>