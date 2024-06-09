<?php
isset($_SESSION) || session_start();
if(isset($_SESSION['marker'])&&$_SESSION['marker']!=='bnkv') $_SESSION['message']=null;//clears message in session from other page

//include external files needed
include_once './DataAccess.php';
include_once './helpers.php';

$da = new DataAccess();
$helpers = new Helpers();

include "./index.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Banking</title>
    <meta charset="utf-8"/>
</head>

<form name="Login" id="Login" method="POST" action="./router.php?route=addaccno" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <h3>ADD ACCOUNT NUMBER</h3>
        <label for="bankid">Bank :</label>
        <select name="bankid" id="bankid" >
            <?php
            try{
                $arrData = $da->GetDataSQL("select * from Bank");
                $helpers->LoadDropDown($arrData, 0, 1);
            }catch(Exception $ex){
                $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","bnkv");
            }
            ?>
        </select>


        <label for="accno">Account Number :</label>
        <input type="number" name="accno" id="accno" required="true" placeholder="Account number"/>
        <br/>

        <hr/>
        <input type="submit" name="btnadd" id="btnadd" value="Add"/>

        <hr/>
        <h3>Your Available Bank Accounts</h3>
        <?php
        try {
            $sequel="SELECT B.bankName,CB.accountNumber FROM Customer C JOIN Customer_Bank CB ON C.cusId = CB.cusId
            JOIN Bank B ON CB.bankSortCode = B.bankSortCode WHERE C.cusEmailAddress = ?;";

            $arrParam=array($_SESSION['fullUsername']);

            $bankAccdata = $da->GetData($sequel,$arrParam);

            if(count($bankAccdata)==0)exit();

            $helpers->LoadHtmlTable($bankAccdata);
        }catch(Exception $ex){
            $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","bnkv");
            header("Location: bankingDetailsView.php");
            exit();
        }

        ?>
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