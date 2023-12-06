<?php
    function SELECT_All_Users(){
        include "../connection.php";

        $sql_query = "CREATE OR REPLACE VIEW user_view AS SELECT * FROM `user`";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }


        $sql_query = "SELECT * FROM `user_view`";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }


        $users = array();

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
        
    }

    function DELETE_Student($uin){

    }

    function DELETE_Admin($uin){

    }

    function PersonalProfileView($UINView){
        require_once "../Student/ProfileHelper.php";

        $origUINView = $UINView;
        $UINView = substr($UINView, 0, -4);

        $UserInfo = SELECT_User($UINView);

        $first_name = $UserInfo['First_Name'];
        $m_initial = $UserInfo['M_Initial'];
        $last_name = $UserInfo['Last_Name'];
        $uin = $UserInfo['UIN'];
        $email = $UserInfo['Email'];
        $discord_name = $UserInfo['Discord_Name'];
        $username = $UserInfo['Username'];
        $password = $UserInfo['Password'];

        


       
        echo '<form class="regForm" action="UserManagement.php" method="POST">
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>First Name</label>
                    <input class="textField" type="text" name="first_name" value="' . $first_name . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Middle Initial</label>
                    <input class="textField" type="text" name="m_initial" value="' . $m_initial . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Last Name</label>
                    <input class="textField" type="text" name="last_name" value="' . $last_name . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>UIN</label>
                    <input class="textField" type="number" name="uin" step="1" value="' . $uin . '" readonly>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Email</label>
                    <input class="textField" type="text" name="email" value="' .  $email . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Discord</label>
                    <input class="textField" type="text" name="discord_name" value="' . $discord_name . '" required>
                </div>

                <div class="greyDivider"></div>


                <div class="halfInputBox">';

                        
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

                    echo '
                    <label>Username</label>
                    <input class="textField" type="text" name="username" value="' . $username . '" required>
                </div>
                <div class="halfInputBox">
                    <div class="noError"></div>
                    <label>Password</label>
                    <input class="textField" type="text" name="password" value="' . $password . '" required>
                </div>


                <input class="submitBtn" type="submit" value="Update" name="AdminViewUpdate">
                <input class="submitBtn" type="submit" value="Delete" name="AdminViewDelete">
            
            </form>';
    }

    function ProfileView($UINView){
        require_once "../Student/ProfileHelper.php";

        $origUINView = $UINView;
        $UINView = substr($UINView, 0, -4);

        $CollegeStudentInfo = SELECT_CollegeStudent($UINView);
        $UserInfo = SELECT_User($UINView);



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

        


       
        echo '<form class="regForm" action="UserManagement.php" method="POST">
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>First Name</label>
                    <input class="textField" type="text" name="first_name" value="' . $first_name . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Middle Initial</label>
                    <input class="textField" type="text" name="m_initial" value="' . $m_initial . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Last Name</label>
                    <input class="textField" type="text" name="last_name" value="' . $last_name . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>UIN</label>
                    <input class="textField" type="number" name="uin" step="1" value="' . $uin . '" readonly>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Email</label>
                    <input class="textField" type="text" name="email" value="' .  $email . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Discord</label>
                    <input class="textField" type="text" name="discord_name" value="' . $discord_name . '" required>
                </div>

                <div class="greyDivider"></div>

                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Gender</label>
                    <input class="textField" type="text" name="gender" value="' . $gender . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Race</label>
                    <input class="textField" type="text" name="race" value="' . $race . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Date of Birth</label>
                    <input class="textField" type="date" name="dob" value="' . $dob . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Hispanic/Latino</label>
                    <input class="checkField" type="checkbox" name="hispanic_latino" ' . $hispanic_latino . '>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>U.S. Citizen</label>
                    <input class="checkField" type="checkbox" name="us_citizen" ' . $us_citizen . '>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>First Generation</label>
                    <input class="checkField" type="checkbox" name="first_gen" ' . $first_gen . '>
                </div>

                <div class="thirdInputBox">';
                    
                        
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
                
                echo '
                    <label>GPA</label>
                    <input class="textField" type="number" name="gpa" step="0.001" value= "' . $gpa . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Major</label>
                    <input class="textField" type="text" name="major" value="' . $major . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Minor 1</label>
                    <input class="textField" type="text" name="minor1" value="' . $minor1 . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Minor 2</label>
                    <input class="textField" type="text" name="minor2" value="' . $minor2 . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Expected Graduation Date</label>
                    <input class="textField" type="date" name="exp_grad" value='. $exp_grad . ' required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>School</label>
                    <input class="textField" type="text" name="school" value="' . $school . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Current Classification</label>
                    <input class="textField" type="text" name="curr_class" value="' . $curr_class . '" required>
                </div>
                <div class="thirdInputBox">
                    <div class="noError"></div>
                    <label>Student Type</label>
                    <input class="textField" type="text" name="student_type" value="' . $student_type . '" required>
                </div>
                <div class="thirdInputBox">';
                    
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
                
                echo '
                    <label>Phone Number</label>
                    <input class="textField" type="number" name="phone" step="1" value="' . $phone . '" required>
                </div>
                
                <div class="greyDivider"></div>


                <div class="halfInputBox">';

                        
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

                    echo '
                    <label>Username</label>
                    <input class="textField" type="text" name="username" value="' . $username . '" required>
                </div>
                <div class="halfInputBox">
                    <div class="noError"></div>
                    <label>Password</label>
                    <input class="textField" type="text" name="password" value="' . $password . '" required>
                </div>


                <input class="submitBtn" type="submit" value="Update" name="UINViewUpdate">
                <input class="submitBtn" type="submit" value="Deactivate" name="UINViewDeactivate">
                <input class="submitBtn" type="submit" value="Reactivate" name="UINViewReactivate">
                <input class="submitBtn" type="submit" value="Delete" name="UINViewDelete">
            
            </form>';
        

    }
?>