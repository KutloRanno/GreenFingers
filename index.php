<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Router Example</title>
</head>
<body>
<h1>Router Example</h1>

<!-- Include the login view based on the action -->
<?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    include "views/{$action}View.php";
}
?>

</body>
</html>
