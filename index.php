<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenShop</title>
</head>
<body>
<h1>Welcome to GreenFingers Online</h1>

<!-- Include the login view based on the action -->
<?php
/*if (isset($_GET['action'])) {
    $action = $_GET['action'];
    include "views/{$action}View.php";
}*/
include "homeView.php";
?>

</body>
</html>
