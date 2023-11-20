<?php
    include "connection.php"; // imports everything from connection.php

    // Queries go here

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
    <div class="surface">
        <div class="maroonBar">
            <img src="https://cybersecurity.tamu.edu/wp-content/uploads/2022/09/cropped-720x140_TEES_CyberCenter_white_horiz.png"/>
        </div>
        <div class="greyBack"> 
            <div class="loginBox">
                <p class="loginWord"> LOGIN </p>
                <div class="maroonDivider"></div>
                <form class="loginForm">
                    <label>Username</label>
                    <input class="inputField" type="text" name="username">
                    <label>Password</label>
                    <input class="inputField" type="password" name="password">
                    <input class="submitBtn" type="submit" value="Sign In">
                </form>
                <div class="greyDivider"></div>
                <a href="registration.php">Create account</a>
            </div>
        </div>
    </div>
</body>
</html>