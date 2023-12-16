<?php

//include external files needed
include_once '../DataAccess.php';
include_once '../helpers.php';
$helpers = new Helpers();
$da = new DataAccess();

$storeId = $_REQUEST['storeId'];
$stockQuantity=$_REQUEST['stockQuantity'];
$stockId=$_REQUEST['stockId'];

//get store name based on the storeId passed
$sql = 'select storeName from Store where storeId = :storeId';
$arrParam=array(":storeId"=>$storeId);

$data = $da->GetData($sql,$arrParam);

$storeName = $data[0]['storeName'];

?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Stock Movement</title>
        <meta charset="utf-8"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>

    <form name="stockmovement" id="stockmovement" method="POST" action="../router.php?route=movestock" >
        <fieldset id="fldsetcontrols" name="fldsetcontrols">

            <h2>Stock Movement Form</h2>

            <input type="hidden" name="storeId" id="storeId" value="<?php echo $_REQUEST['storeId']??'0' ?>" />
            <input type="hidden" name="stockId" id="stockId" value="<?php echo $stockId?>" />

            <label for="storename">Move from :</label>
            <input type="text" name="storename" id="storename" readonly="true" placeholder="Store Name" value="<?php echo $storeName ?>" />
            <br/>

            <label for="stocklevel">Maximum movable quantity :</label>
            <input type="text" name="stocklevel" id="stocklevel" readonly="true" placeholder="Stock Level" value="<?php echo $_REQUEST['stockQuantity']??'0' ?>" />
            <br/>

            <label for="storeToId">Move To :</label>
            <select name="storeToId" id="storeToId" >
                <?php
                $arrdata = $da->GetData("Select storeId, storeName from Store order by storeId asc;");
                $helpers->LoadDropDown($arrdata);
                ?>
            </select>
            <br/>

            <label for="quantity">Quantity :</label>
            <input type="text" name="quantity" id="quantity" required="true" placeholder="Quantity"/>
            <br/>

            <hr>
            <input type="reset" name="btnclear" id="btnclear" value="Clear"/>
            <input type="submit" name="btnmove" id="btnmove" value="Move Stock"/>

            <br/>
        </fieldset>
    </form>

    </html>