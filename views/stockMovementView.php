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

<?php


try{

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        print("<pre>");
        //print_r($_POST);
        print("</pre>");


        //get data for saving
        $storeid    = $_POST["storeid"]??0;
        $storename  = $_POST["storename"]??"";
        $productid  = $_POST["productid"]??"0";
        $productname= $_POST["productname"]??"";
        $producttype= $_POST["producttype"]??"";
        $price      = $_POST["price"]??"0";
        $stocklevel = $_POST["stocklevel"]??"0";
        $storetoid  = $_REQUEST["storetoid"]??"0";
        $quantity   = $_REQUEST["quantity"]??"0";
        $timemoved  = $da->GetCurrentTime();
        $datemoved  = $da->GetCurrentDate();
        $staffid    = 11;

        if(isset($_POST['btnregister'])){

            $params = array($datemoved, $timemoved, $productid, $storeid, $storetoid, $quantity, $staffid);
            //print_r($params);

            //validate data
            if( $storetoid=="0" || $quantity=="0" ){
                throw new Exception("Please select Store ID To, and Quantity Moved !!");
            }else if($stocklevel < $quantity){
                throw new Exception("Quantity is greater than available stock !!");
            }else if($stocklevel = 0){
                throw new Exception("Stock is not available, stock movement process failed !!");
            }else if($storeid == $storetoid){
                throw new Exception("You cant move stock within the same store !!");
            }

            //----TRANSACTIONS----
            //prepare to save data
            $sql="INSERT INTO class_stock_warehouse (DATE_MOVED,TIME_MOVED,PRODUCT_ID,STORE_ID_FROM,STORE_ID_TO,QUANTITY,MEMBER_ID) VALUES (?,?,?,?,?,?,?);";
            $count = $da->ExecuteCommand($sql, $params);

            //update new quantity in products for target store +
            $params = array($quantity, $productid, $storetoid);
            $sql="UPDATE class_products SET QUANTITY=QUANTITY+? WHERE PRODUCT_ID=? AND STORE_ID=?;";
            $count = $da->ExecuteCommand($sql, $params);

            //update new quantity in products for current store -
            $params = array($quantity, $productid, $storeid);
            $sql="UPDATE class_products SET QUANTITY=QUANTITY-? WHERE PRODUCT_ID=? AND STORE_ID=?;";
            $count = $da->ExecuteCommand($sql, $params);
            //-------------

            //confirm success
            if($count > 0){
                print("Stock movement process completed successfully !!");
            }else{
                die("Stock movement process failed !!");
            }


        }

    }


} catch (Exception $ex) {
    print($ex->getMessage());
}
?>