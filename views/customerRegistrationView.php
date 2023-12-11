<?php

//include external files needed
include_once './DataAccess.php';
$da = new DataAccess();
$helpers = new Helpers();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>
    <meta charset="utf-8"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<form name="customers" id="customers" method="POST" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <label for="firstname">Firstname :</label>
        <input type="text" name="firstname" id="firstname" required="true" placeholder="Firstname"/>
        <br/>

        <label for="surname">Surname :</label>
        <input type="text" name="surname" id="surname" required="true" placeholder="Surname"/>
        <br/>

        <label for="gender">Gender :</label>
        <select name="gender" id="gender" >
            <?php
            $arrdata = $da->GetGenderData();
            $da->LoadDropDown($arrdata);
            ?>
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

        <label for="username">Username :</label>
        <input type="text" name="username" id="username" required="true" placeholder="Username"/>
        <br/>

        <label for="password">Password :</label>
        <input type="password" name="password" id="password" required="true" placeholder="Password"/>
        <br/>

        <label for="countryid">Country :</label>
        <select name="countryid" id="countryid" >
            <?php
            $arrdata = $da->GetDataSQL("select * from class_countries");
            $da->LoadDropDown($arrdata, 0, 1);
            ?>
        </select>
        <br/>

        <label for="dateregistered">Date Registered :</label>
        <input type="date" name="dateregistered" id="dateregistered" />
        <br/>

        <hr>
        <input type="submit" name="btnregister" id="btnregister" value="Register"/>
        <input type="submit" name="btnupdate" id="btnupdate" value="Update"/>
        <input type="submit" name="btndelete" id="btndelete" value="Delete"/>
        <input type="reset" name="btnclear" id="btnclear" value="Clear"/>

        <br/>
    </fieldset>
</form>