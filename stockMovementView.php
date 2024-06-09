<?php
isset($_SESSION)||session_start();
if(isset($_SESSION['marker'])&&$_SESSION['marker']!=='stv') $_SESSION['message']=null;//clears message in session from other page

//include external files needed
include_once './DataAccess.php';
include_once './helpers.php';
include_once 'index.php';
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
    </head>

    <form name="stockmovement" id="stockmovement" method="POST" action="./router.php?route=movestock" >
        <fieldset id="fldsetcontrols" name="fldsetcontrols">

            <h2>Stock Movement Form</h2>

            <input type="hidden" name="storeId" id="storeId" value="<?php echo $_REQUEST['storeId']??'0' ?>" />
            <input type="hidden" name="stockId" id="stockId" value="<?php echo $stockId?>" />

            <label for="storename">Move from :</label>
            <input type="text" name="storename" id="storename" readonly  value="<?php echo $storeName ?>" />
            <br/>

            <label for="stocklevel">Maximum movable quantity :</label>
            <input type="text" name="stocklevel" id="stocklevel" readonly  value="<?php echo $_REQUEST['stockQuantity']??'0' ?>" />
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
            <input type="number" name="quantity" id="quantity" required min="1" max="<?php echo $_REQUEST['stockQuantity']??'0' ?>"/>
            <br/>

            <hr>
            <input type="reset" name="btnclear" id="btnclear" value="Clear"/>
            <input type="submit" name="btnmove" id="btnmove" value="Move Stock"/>

            <br/>
            <label>
                <?php
                if(!isset($_SESSION['message'])||$_SESSION['message']==="") exit();
                $helpers->ShowMessage($_SESSION['message']);
                ?>
            </label>
        </fieldset>
    </form>
    </html>