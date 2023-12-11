<?php

//include external files needed
include_once '../DataAccess.php';
$da = new DataAccess();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<form name="Login" id="Login" method="POST" action="../router.php?route=login" >
    <fieldset id="fldsetcontrols" name="fldsetcontrols">

        <h3>System Login</h3>

        <label for="username">Username :</label>
        <input type="text" name="username" id="username" required="true" placeholder="Username"/>
        <br/>

        <label for="password">Password :</label>
        <input type="password" name="password" id="password" required="true" placeholder="Password"/>
        <br/>

        <hr>
        <input type="reset" name="btnclear" id="btnclear" value="Clear"/>
        <input type="submit" name="btnlogin" id="btnlogin" value="Login"/>


        <br/>
    </fieldset>
</form>

</html>
