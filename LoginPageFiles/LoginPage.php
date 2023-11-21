<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="LoginPage.css">
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
                <form class="loginForm" action="LoginPage.php" method="POST">
                    <?php
                        include "../connection.php"; // imports everything from connection.php
                        include "loginHelper.php"; // imports helper functions
                        session_start(); // Allows session variables to be used

                        $username = "";
                        $password = "";

                        if(!empty($_POST["username"]) && !empty($_POST["password"])){
                            // Sets username and password from form
                            $username = $_POST["username"];
                            $password = $_POST["password"];

                            // Checks if login is correct
                            if (isValidUsernameLogin($username, $password)){

                                // checks if student or admin
                                if (userType($username) == "Student"){
                                    $_SESSION['username'] = $username; // Saves to session variable
                                    header("Location: ../StudentHomePageFiles/StudentHomePage.php");
                                    exit();
                                }

                                else if (userType($username) == "Admin"){
                                    $_SESSION['username'] = $username; // Saves to session variable
                                    header("Location: ../AdminHomePageFiles/AdminHomePage.php");
                                    exit();
                                }
                            }

                            else {
                                echo "Incorrect Username or Password";
                            }
                        }
                    ?>
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