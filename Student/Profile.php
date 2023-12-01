<?php
    require_once "ProfileHelper.php";
    session_start();

    $CollegeStudentInfo = SELECT_CollegeStudent(getUINFromUser($_SESSION['username']));
    $UserInfo = SELECT_User(getUINFromUser($_SESSION['username']));


    $first_name = $UserInfo['First_Name'];
    $m_initial = $UserInfo['M_Initial'];
    $last_name = $UserInfo['Last_Name'];
    $uin = $UserInfo['UIN'];
    $email = $UserInfo['Email'];
    $discord_name = $UserInfo['Discord_Name'];
    $username = $UserInfo['Username'];
    $password = $UserInfo['Password'];
    $gender = $CollegeStudentInfo['Gender'];
    $hispanic_latino = convertToBoolean($CollegeStudentInfo['Hispanic/Latino']) ? 'checked' : '';
    $race = $CollegeStudentInfo['Race'];
    $us_citizen = convertToBoolean($CollegeStudentInfo['U.S._Citizen']) ? 'checked' : '';
    $dob = $CollegeStudentInfo['DoB'];
    $first_gen = convertToBoolean($CollegeStudentInfo['First_Generation']) ? 'checked' : '';
    $gpa = $CollegeStudentInfo['GPA'];
    $major = $CollegeStudentInfo['Major'];
    $minor1 = $CollegeStudentInfo['Minor_1'];
    $minor2 = $CollegeStudentInfo['Minor_2'];
    $exp_grad = $CollegeStudentInfo['Expected_Graduation'];
    $school = $CollegeStudentInfo['School'];
    $curr_class = $CollegeStudentInfo['Current_Classification'];
    $student_type = $CollegeStudentInfo['Student_Type'];
    $phone = $CollegeStudentInfo['Phone'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $first_name = $_POST['first_name'];
        $m_initial = $_POST['m_initial'];
        $last_name = $_POST['last_name'];
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

        $username = (validUsername($_POST['username'], $uin)) ? $_POST['username'] : "";
        $gpa = (validGPA($_POST['gpa'])) ? $_POST['gpa'] : "";
        $phone = (validPhoneNumber($_POST['phone'])) ? $_POST['phone'] : "";


        if (validUsername($_POST['username'], $uin) && validGPA($_POST['gpa']) && validPhoneNumber($_POST['phone'])){

            if ($hispanic_latino == "checked"){
                $hispanic_latino = true;
            }

            if ($us_citizen == "checked"){
                $us_citizen = true;
            }

            if ($first_gen == "checked"){
                $first_gen = true;
            }

            UPDATE_User($uin, $first_name, $m_initial, $last_name, $username, $password, "Student", $email, $discord_name);

            UPDATE_CollegeStudent($uin, $gender, $hispanic_latino, $race, $us_citizen, $first_gen, 
            $dob, $gpa, $major, $minor1, $minor2, $exp_grad, 
            $school, $curr_class, $student_type, $phone);

            $_SESSION['username'] = $username;

            header("Location: Profile.php");
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
        <div class="skinnyMaroonBar"></div>
        <div class="greyBack"> 
            <div class="regBox">
                <a href="StudentHome.php">< Back</a>
                <p class="regWord">USER PROFILE PAGE</p>
                <div class="maroonDivider"></div>
                <form class="regForm" action="Profile.php" method="POST">
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
                        <div class="noError"></div>
                        <label>UIN</label>
                        <input class="textField" type="number" name="uin" step="1" value="<?php echo htmlspecialchars($uin); ?>" readonly>
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
                            require_once "ProfileHelper.php";
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
                            require_once "ProfileHelper.php";
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
                            require_once "ProfileHelper.php";
                            if (isset($_POST['username'])) {
                                if (!validUsername($_POST['username'], getUINFromUser($_SESSION['username']))){
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
                        <input class="textField" type="text" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
                    </div>
                    <input class="submitBtn" type="submit" value="Update">
                    
                
                </form>
            </div>
        </div>
    </div>
</body>
</html>