<?php
isset($_SESSION)||session_start();

if(isset($_SESSION['marker'])&&$_SESSION['marker']!=='pdpv') $_SESSION['message']=null;//clears message in session from other page


//include external files needed
include_once './DataAccess.php';
include_once './helpers.php';
include_once 'index.php';
$helpers = new Helpers();
$da = new DataAccess();


//want to get product details using storeId
$sequel = "select stockName,prodCost from Stock,Product where 
                                                 Stock.stockId=:stockId AND Product.stockId=Stock.stockId limit 1";
$arrParam=array(':stockId'=>$_REQUEST['stockId']);
$prodInfo=$da->GetData($sequel,$arrParam);

$storeId = $_REQUEST['storeId'];
$stockQuantity=$_REQUEST['stockQuantity'];
$stockId=$_REQUEST['stockId'];
//$userName=$_REQUEST['username'];

//get store name based on the storeId passed
$sql = 'select storeName from Store where storeId = :storeId';
$arrParam=array(":storeId"=>$storeId);

$data = $da->GetData($sql,$arrParam);

$storeName = $data[0]['storeName'];

print('break on through the night.');
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Purchase Product</title>
        <meta charset="utf-8"/>
    </head>

    <form name="productpurchase" id="purchaseproduct" method="POST" action="./router.php?route=purchaseproduct" >
        <fieldset id="fldsetcontrols" name="fldsetcontrols">

            <h2>Buy product</h2>

            <input type="hidden" name="storeId" id="storeId" value="<?php echo $_REQUEST['storeId']??'0' ?>" />
            <input type="hidden" name="stockId" id="stockId" value="<?php echo $stockId?>" />

            <label for="storeName">Store Name :</label>
            <input type="text" name="storeName" id="storeName" readonly="true" value="<?php echo $storeName ?>" />
            <br/>

            <label for="productname">Product Name :</label>
            <input type="text" name="productname" id="productname" readonly="true" value="<?php echo $prodInfo[0]['stockName'] ?>" />
            <br/>

            <label for="availablequantity">Available quantity :</label>
            <input type="text" required name="availablequantity" id="availablequantity" readonly="readonly" value="<?php echo $_REQUEST['stockQuantity']??'0' ?>" />
            <br/>

            <label for="prodPrice">Price per unit :</label>
            <input type="text" name="prodPrice" readonly id="prodPrice" value="<?php echo $prodInfo[0]['prodCost'] ?>"/>
            <br/>

            <label for="desiredQuantity">Pick quantity you want to buy :</label>
            <input type="number" required name="desiredQuantity" id="desiredQuantity" max="<?php echo $_REQUEST['stockQuantity'] ?>" min="1"/>
            <br/>

            <label for="accNo">Select account number</label>
            <select name="accNo" id="accNo" >
                <?php
                try{
                    $sequel= "select * from customer_bank where
                    customer_bank.cusId=:cusId ;";
                    $arrParam=array(":cusId"=>$_SESSION['cusId']);
                    $arrData = $da->GetData($sequel,$arrParam);
//                    var_dump($arrData.'what is happening');exit;
                    $helpers->LoadDropDown($arrData, 2, 2);
                }catch(Exception $ex){
                    $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","pdpv");
                }
                ?>
            </select>

            <hr>
            <input type="submit" name="btnbuy" id="btnbuy" value="Buy product"/>

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

