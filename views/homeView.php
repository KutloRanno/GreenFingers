<?php

if(!isset($_SESSION)) session_start();

$userType=$_SESSION['userType']??'';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<nav>
    <ul>
        <?php
        $_SESSION['fullUsername']=$_REQUEST['fullUsername']??'';
        ?>
        <li><em>Welcome <?php echo strtoupper($_REQUEST['current_username']??"GUEST"). strtoupper("|{$userType}") ?></em></li>
        <li ><a href="./views/homeView.php">HOME</a> </li>
        <li><a href="./views/productsView.php">PRODUCTS</a></li>

        <?php
        if(isset($_REQUEST['current_username']) && strtolower($userType)==='management')
            echo '<li ><a href="./views/stockLevelsView.php">STOCK WAREHOUSE REPORT</a></li> <li><a href="../router.php?action=logout">LOG OUT</a></li>';
        if(isset($_REQUEST['current_username'])&&strtolower($userType)==='customer')
            echo '<li><a href="./views/bankingDetailsView.php">MY BANKING</a></li> <li>PURCHASE</li> 
                  <li><a href="../router.php?action=logout">LOG OUT</a></li>';
        ?>

        <?php
        if(!isset($_REQUEST['current_username'])) echo '<li><a href="./views/customerRegistrationView.php">CREATE ACCOUNT</a></li>';
        ?>

        <?php
        if(!isset($_REQUEST['current_username'])) echo '<li><a href="./views/loginView.php">LOGIN</a></li>'
        ?>
    </ul>
</nav>
</body>
</html>

