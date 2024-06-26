<?php

//include external files needed
include_once './DataAccess.php';
include_once './helpers.php';
$da = new DataAccess();
$helpers = new Helpers();
include_once 'index.php';

if(isset($_SESSION['marker'])&&$_SESSION['marker']!=='rgsv') $_SESSION['message']=null;


?>

<!DOCTYPE html>
<html>
<head>
    <title>Create account</title>
    <meta charset="utf-8"/>
</head>

<form name="customers" id="customers" method="POST"  action="./router.php?route=register" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <label for="firstname">Firstname :</label>
        <input type="text" name="firstname" id="firstname" required="true" placeholder="Firstname"/>
        <br/>

        <label for="surname">Surname :</label>
        <input type="text" name="surname" id="surname" required="true" placeholder="Surname"/>
        <br/>

        <label for="gender">Gender :</label>
        <select name="gender" id="gender" >
            <option value="">Select</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select>
        <br/>

        <label for="dob">Date Of Birth :</label>
        <input type="date" name="dob" id="dob" />
        <br/>

        <label for="address">Address :</label>
        <input type="text" name="address" id="address" required="true" placeholder="Address"/>
        <br/>

        <label for="cellno">Cell Number :</label>
        <input type="text" name="cellno" id="cellno" required="true" placeholder="Cell Number"/>
        <br/>

        <label for="Email">Email :</label>
        <input type="email" name="email" id="email" required="true" placeholder="email"/>
        <br/>

        <label for="password">Password :</label>
        <input type="password" name="password" id="password" required="true" placeholder="Password"/>
        <br/>

        <label for="country">Country :</label>
        <select name="country" id="countryid" >
            <?php
            try{
            $arrData = $da->GetDataSQL("select * from Country");
            $helpers->LoadDropDown($arrData, 0, 1);
            }catch(Exception $ex){
                $helpers->SetSuccessorOrErrorState($ex->getMessage(),"error","rgsv");
            }
            ?>
        </select>
        <br/>

        <hr>
        <input type="submit" name="btnregister" id="btnregister" value="Register"/>
        <input type="reset" name="btnclear" id="btnclear" value="Clear"/>
        <br/>
        <p>Already have an account? Log in <a href="./loginView.php" >here</a> </p>

        <label>
            <?php

            if(!isset($_SESSION['message'])) exit();
             $helpers->ShowMessage($_SESSION['message']);

            if($_SESSION['resultType']==="info") header("Refresh: 2; url=router.php?route=home")&&exit();

            ?>
        </label>
    </fieldset>
</form>