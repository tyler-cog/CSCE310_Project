
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
                <form class="loginForm" action="index.php" method="POST">
                    <?php
                        include "connection.php"; // imports everything from connection.php

                        $username = "";
                        $password = "";
                        $wrong = false;

                        if(!empty($_POST["username"]) && !empty($_POST["password"])){

                            // Sets username and password from form
                            $username = $_POST["username"];
                            $password = $_POST["password"];

                            $sql_query = "SELECT * FROM `user` WHERE `Username` = '$username'";

                            $login_result = $db_conn->query($sql_query);

                            if (!$login_result) {
                                die("Query failed: " . $conn->error);
                            }
                            
                            // If the result of the query is nothing
                            if ($login_result->num_rows == 0){
                                echo "Incorrect Username or Password";
                            }

                            // Loops through all the data in query (in this case, just does it once)
                            while ($row = $login_result->fetch_assoc()) {
                                // Do something with each row of data

                                // If password is correct
                                if ($password == $row["Password"]){

                                    if ($row["User_Type"] == "Student") {
                                        header("Location: StudentHomePage.php");
                                        exit();
                                    }

                                    if ($row["User_Type"] == "Admin") {
                                        header("Location: AdminHomePage.php");
                                        exit();
                                    }
                                }

                                // If password is wrong
                                else {
                                    echo "Incorrect Username or Password";
                                }
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