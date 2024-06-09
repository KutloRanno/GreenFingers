<?php
isset($_SESSION) || session_start();
//include external files needed
include_once './DataAccess.php';
include_once './helpers.php';

if(isset($_SESSION['marker'])&&$_SESSION['marker']!=='lgnv') $_SESSION['message']=null;

$da = new DataAccess();
$helpers = new Helpers();

include_once 'index.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8"/>
</head>

<form name="Login" id="Login" method="POST" action="./router.php?route=login" >
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
        <p>Don't have an account yet? Register <a href="./customerRegistrationView.php" >here</a> </p>
        <br/>

        <label>
            <?php
            if(!isset($_SESSION['message'])||$_SESSION['message']===""||$_SESSION['message']==null) exit();
            $helpers->ShowMessage($_SESSION['message']);

            ?>
        </label>
    </fieldset>
</form>
</html>
