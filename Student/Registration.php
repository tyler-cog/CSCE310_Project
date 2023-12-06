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
    $gender = "";
    $hispanic_latino = "";
    $race = "";
    $us_citizen = "";
    $dob = "";
    $first_gen = "";
    $gpa = "";
    $major = "";
    $minor1 = "";
    $minor2 = "";
    $exp_grad = "";
    $school = "";
    $curr_class = "";
    $student_type = "";
    $phone = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $first_name = $_POST['first_name'];
        $m_initial = $_POST['m_initial'];
        $last_name = $_POST['last_name'];
        $uin = $_POST['uin'];
        $email = $_POST['email'];
        $discord_name = $_POST['discord_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $hispanic_latino = isset($_POST['hispanic_latino']) ? 'checked' : '';
        $race = $_POST['race'];
        $us_citizen = isset($_POST['us_citizen']) ? 'checked' : '';
        $dob = $_POST['dob'];
        $first_gen = isset($_POST['first_gen']) ? 'checked' : '';
        $gpa = $_POST['gpa'];
        $major = $_POST['major'];
        $minor1 = $_POST['minor1'];
        $minor2 = $_POST['minor2'];
        $exp_grad = $_POST['exp_grad'];
        $school = $_POST['school'];
        $curr_class = $_POST['curr_class'];
        $student_type = $_POST['student_type'];
        $phone = $_POST['phone'];

        $uin = (validUIN($_POST['uin'])) ? $_POST['uin'] : "";
        $username = (validUsername($_POST['username'])) ? $_POST['username'] : "";
        $gpa = (validGPA($_POST['gpa'])) ? $_POST['gpa'] : "";
        $phone = (validPhoneNumber($_POST['phone'])) ? $_POST['phone'] : "";


        if (validUIN($_POST['uin']) && validUsername($_POST['username']) && validGPA($_POST['gpa']) && validPhoneNumber($_POST['phone'])){

            if ($hispanic_latino == "checked"){
                $hispanic_latino = true;
            }

            if ($us_citizen == "checked"){
                $us_citizen = true;
            }

            if ($first_gen == "checked"){
                $first_gen = true;
            }

            INSERT_User($uin, $first_name, $m_initial, $last_name, $username, $password, "Student", $email, $discord_name);

            INSERT_CollegeStudent($uin, $gender, $hispanic_latino, $race, $us_citizen, $first_gen, 
            $dob, $gpa, $major, $minor1, $minor2, $exp_grad, 
            $school, $curr_class, $student_type, $phone);

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
                <p class="regWord">STUDENT REGISTRATION </p>
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

                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Gender</label>
                        <input class="textField" type="text" name="gender" value="<?php echo htmlspecialchars($gender); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Race</label>
                        <input class="textField" type="text" name="race" value="<?php echo htmlspecialchars($race); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Date of Birth</label>
                        <input class="textField" type="date" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Hispanic/Latino</label>
                        <input class="checkField" type="checkbox" name="hispanic_latino" <?php echo $hispanic_latino; ?>>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>U.S. Citizen</label>
                        <input class="checkField" type="checkbox" name="us_citizen" <?php echo $us_citizen; ?>>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>First Generation</label>
                        <input class="checkField" type="checkbox" name="first_gen" <?php echo $first_gen; ?>>
                    </div>

                    <div class="thirdInputBox">
                        <?php
                            require_once "RegistrationHelper.php";
                            if (isset($_POST['gpa'])) {
                                if (!validGPA($_POST['gpa'])){
                                    echo '<div class="withError">
                                            <div class="errorMessage"> Invalid GPA</div>
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
                        <label>GPA</label>
                        <input class="textField" type="number" name="gpa" step="0.001" value="<?php echo htmlspecialchars($gpa); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Major</label>
                        <input class="textField" type="text" name="major" value="<?php echo htmlspecialchars($major); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Minor 1</label>
                        <input class="textField" type="text" name="minor1" value="<?php echo htmlspecialchars($minor1); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Minor 2</label>
                        <input class="textField" type="text" name="minor2" value="<?php echo htmlspecialchars($minor2); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Expected Graduation Date</label>
                        <input class="textField" type="date" name="exp_grad" value="<?php echo htmlspecialchars($exp_grad); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>School</label>
                        <input class="textField" type="text" name="school" value="<?php echo htmlspecialchars($school); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Current Classification</label>
                        <input class="textField" type="text" name="curr_class" value="<?php echo htmlspecialchars($curr_class); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Student Type</label>
                        <input class="textField" type="text" name="student_type" value="<?php echo htmlspecialchars($student_type); ?>" required>
                    </div>
                    <div class="thirdInputBox">
                        <?php
                            require_once "RegistrationHelper.php";
                            if (isset($_POST['phone'])) {
                                if (!validPhoneNumber($_POST['phone'])){
                                    echo '<div class="withError">
                                            <div class="errorMessage">Invalid Phone Number</div>
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
                        <label>Phone Number</label>
                        <input class="textField" type="number" name="phone" step="1" value="<?php echo htmlspecialchars($phone); ?>" required>
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