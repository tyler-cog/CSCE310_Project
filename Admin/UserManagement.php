<?php
    require_once "../Student/ProfileHelper.php";
    
    // Code that runs if there is an update
    if (isset($_POST['UINViewUpdate'])){
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
        }
    }

    else if (isset($_POST['UINViewDeactivate'])){
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

        $username = (validUsername($_POST['username'], $uin)) ? $_POST['username'] : "";
        $gpa = (validGPA($_POST['gpa'])) ? $_POST['gpa'] : "";
        $phone = (validPhoneNumber($_POST['phone'])) ? $_POST['phone'] : "";


        if (validUsername($_POST['username'], $uin) && validGPA($_POST['gpa']) && validPhoneNumber($_POST['phone'])){
            UPDATE_User($uin, $first_name, $m_initial, $last_name, $username, $password, "Inact_Student", $email, $discord_name);  
        }
    }

    else if (isset($_POST['UINViewReactivate'])){
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

        $username = (validUsername($_POST['username'], $uin)) ? $_POST['username'] : "";
        $gpa = (validGPA($_POST['gpa'])) ? $_POST['gpa'] : "";
        $phone = (validPhoneNumber($_POST['phone'])) ? $_POST['phone'] : "";


        if (validUsername($_POST['username'], $uin) && validGPA($_POST['gpa']) && validPhoneNumber($_POST['phone'])){
            UPDATE_User($uin, $first_name, $m_initial, $last_name, $username, $password, "Student", $email, $discord_name);  
        }
    }

    else if (isset($_POST['UINViewDelete'])){

    }
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Style/UserManagement.css?v=<?php echo time(); ?>" >
</head>
<body>
<div class="surface">
        <div class="skinnyMaroonBar"></div>
        <div class="greyBack"> 
            <div class="regBox">
                <a href="../Admin/AdminHome.php">< Back</a>
                <p class="regWord"> USER MANAGEMENT </p>
                <div class="maroonDivider"></div>
                
                <div class="userContainer">
                    <div class="userHeader">
                        <div class="mUserItem">UIN</div>
                        <div class="mUserItem">First Name</div>
                        <div class="mUserItem">M Initial</div>
                        <div class="mUserItem">Last Name</div>
                        <div class="mUserItem">Userame</div>
                        <div class="mUserItem">Password</div> 
                        <div class="mUserItem">User Type</div>
                        <div class="mUserItem">Email</div>
                        <div class="mUserItem">Discord</div>
                        <div class="mUserItem">-</div>
                    </div>

                    <form action="UserManagement.php" method="POST">
                    <?php
                        require_once "UserManagementHelper.php";
                        session_start();
            
                        $array = SELECT_All_Users();

                        foreach ($array as $user) {
                            $n = $user['UIN'] . "View";
                            echo "<div class='userHeader'>
                            <div class='wUserItem'>{$user['UIN']}</div>  
                            <div class='wUserItem'>{$user['First_Name']}</div>  
                            <div class='wUserItem'>{$user['M_Initial']}</div>  
                            <div class='wUserItem'>{$user['Last_Name']}</div>  
                            <div class='wUserItem'>{$user['Username']}</div>  
                            <div class='wUserItem'>{$user['Password']}</div>  
                            <div class='wUserItem'>{$user['User_Type']}</div>  
                            <div class='wUserItem'>{$user['Email']}</div>  
                            <div class='wUserItem'>{$user['Discord_Name']}</div>
                            <div class='wUserItem'>" . ((($user['User_Type'] == 'Student') || ($user['User_Type'] == 'Inact_Student') || ($user['Username'] == $_SESSION["username"])) ? 
                            
                            "<input class='btnUserItem' type='submit' name={$n} value='Edit Profile'>" : ' ') . "</div>
                          </div>";
                        }
                    ?>
                    </form>
                </div>
                <div class="maroonDivider"></div>
                <?php
                    require_once "UserManagementHelper.php";
                    require_once "../Student/ProfileHelper.php";
            
                    $array = SELECT_All_Users();

                    foreach ($array as $user) {
                        
                        $UINView = $user['UIN'] . "View";
                        if (isset($_POST[$UINView])){

                            // If user is an Admin
                            if ($user["User_Type"] == "Admin"){
                                echo "Admin Editing " . $UINView;
                                
                            }

                            // If user is a student
                            else {
                                echo "Student Editing " . $UINView;
                                ProfileView($UINView);
                                
                                }
                        }
                    }

                    

                ?>
            </div>
        </div>
    </div>
</body>
</html>
