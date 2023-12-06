<!-- Code written by Gian Inguillo -->
<?php
    require_once "RegistrationHelper.php";

    $first_name = "";
    $m_initial = "";
    $last_name = "";
    $uin = "";
    $email = "";
    $discord_name = "";
    $username = "";
    $password = "";
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $first_name = $_POST['first_name'];
        $m_initial = $_POST['m_initial'];
        $last_name = $_POST['last_name'];
        $uin = $_POST['uin'];
        $email = $_POST['email'];
        $discord_name = $_POST['discord_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        

        $uin = (validUIN($_POST['uin'])) ? $_POST['uin'] : "";
        $username = (validUsername($_POST['username'])) ? $_POST['username'] : "";
        


        if (validUIN($_POST['uin']) && validUsername($_POST['username'])){

            INSERT_User($uin, $first_name, $m_initial, $last_name, $username, $password, "Admin", $email, $discord_name);

            header("Location: ../LoginPage/LoginPage.php");
            exit();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Style/Registration.css?v=<?php echo time(); ?>" >
</head>
<body>
    <div class="surface">
        <div class="maroonBar">
            <img src="https://cybersecurity.tamu.edu/wp-content/uploads/2022/09/cropped-720x140_TEES_CyberCenter_white_horiz.png"/>
        </div>
        <div class="greyBack"> 
            <div class="regBox">
                <a href="../LoginPage/LoginPage.php">< Back</a>
                <p class="regWord">ADMIN REGISTRATION </p>
                <div class="maroonDivider"></div>
                <form class="regForm" action="Registration.php" method="POST">
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>First Name</label>
                        <input class="textField" type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Middle Initial</label>
                        <input class="textField" type="text" name="m_initial" value="<?php echo htmlspecialchars($m_initial); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Last Name</label>
                        <input class="textField" type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <?php
                            require_once "RegistrationHelper.php";
                            if (isset($_POST['uin'])) {
                                if (!validUIN($_POST['uin'])){
                                    echo '<div class="withError">
                                            <div class="errorMessage">UIN already taken or invalid</div>
                                        </div>';
                                }
                                else {
                                    echo '<div class="noError"></div>';
                                }
                            }

                            else {
                                echo '<div class="noError"></div>';
                            }
                        ?>
                        <label>UIN</label>
                        <input class="textField" type="number" name="uin" step="1" value="<?php echo htmlspecialchars($uin); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Email</label>
                        <input class="textField" type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Discord</label>
                        <input class="textField" type="text" name="discord_name" value="<?php echo htmlspecialchars($discord_name); ?>" required>
                    </div>

                    <div class="greyDivider"></div>

                    <div class="halfInputBox">
                        <?php
                            require_once "RegistrationHelper.php";
                            if (isset($_POST['username'])) {
                                if (!validUsername($_POST['username'])){
                                    echo '<div class="withError">
                                            <div class="errorMessage">Username already taken</div>
                                        </div>';
                                }
                                else {
                                    echo '<div class="noError"></div>';
                                }
                            }

                            else {
                                echo '<div class="noError"></div>';
                            }
                        ?>
                        <label>Username</label>
                        <input class="textField" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>
                    <div class="halfInputBox">
                        <div class="noError"></div>
                        <label>Password</label>
                        <input class="textField" type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
                    </div>
                    <input class="submitBtn" type="submit" value="Register">
                    
                
                </form>
            </div>
        </div>
    </div>
</body>
</html>