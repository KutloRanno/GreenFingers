<?php

isset($_SESSION) || session_start();

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

        <li><em>Welcome <?php echo strtoupper($_SESSION['currentUsername']??"GUEST"). strtoupper("|{$userType}"); if($userType==='management'||$userType==='customer')echo "<h5>__LOGGED IN__</h5>" ?></em></li>
        <li ><a href="./homeView.php">HOME</a> </li>
        <li><a href="./productsView.php">PRODUCTS</a></li>

        <?php
        if(strtolower($userType)==='management')
            echo '<li ><a href="./stockLevelsView.php">STOCK WAREHOUSE REPORT</a></li> <li><a href="./router.php?route=logout">LOG OUT</a></li>';
        ?>

        <?php
        if(strtolower($userType)==='customer')
            echo '<li><a href="./bankingDetailsView.php">MY BANKING</a></li> 
                  <li><a href="./router.php?route=logout">LOG OUT</a></li>';
        ?>

        <?php
        if($userType==="") echo '<li><a href="./customerRegistrationView.php">CREATE ACCOUNT</a></li>
                                 <li><a href="./loginView.php">LOGIN</a></li>';
        ?>

    </ul>
</nav>
</body>
</html>

