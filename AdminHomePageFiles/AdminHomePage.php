<?php
    session_start();
    $username = $_SESSION['username'];
    echo $username . " Admin Homepage";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
   <div> Admin Homepage </div>
</body>
</html>