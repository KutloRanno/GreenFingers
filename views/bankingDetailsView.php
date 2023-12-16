<?php

//include external files needed
include_once '../DataAccess.php';
include_once '../helpers.php';

$da = new DataAccess();
$helpers = new Helpers();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Banking</title>
    <meta charset="utf-8"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<form name="Login" id="Login" method="POST" action="../router.php?route=addaccno" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <h3>ADD ACCOUNT NUMBER</h3>
        <label for="bankid">Bank :</label>
        <select name="bankid" id="bankid" >
            <?php
            try{
                $arrData = $da->GetDataSQL("select * from Bank");
                $helpers->LoadDropDown($arrData, 0, 1);
            }catch(Exception $ex){
                print($ex->getMessage());
            }
            ?>
        </select>


        <label for="accno">Account Number :</label>
        <input type="number" name="accno" id="accno" required="true" placeholder="Account number"/>
        <br/>

        <hr/>
        <input type="submit" name="btnadd" id="btnadd" value="Add"/>

        <hr/>
        <h3>Available Bank Accounts</h3>
        <?php
var_dump($_SESSION);exit;
            $sequel="SELECT B.bankName,CB.accountNumber FROM Customer C JOIN Customer_Bank CB ON C.cusId = CB.cusId
            JOIN Bank B ON CB.bankSortCode = B.bankSortCode WHERE C.cusEmailAddress = ?;";

            $arrParam=array($_REQUEST['fullUsername']);

            $bankAccdata = $da->GetData($sequel,$arrParam);
            $helpers->LoadHtmlTable($bankAccdata);
        ?>
        <br/>
    </fieldset>
</form>

</html>