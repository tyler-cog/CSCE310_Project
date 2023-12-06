<!-- Code written by Gian Inguillo -->
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

    function DELETE_ApplicationWithDocument($uin){
        include "../connection.php";

        $sql_query = "SELECT * FROM application WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }

        $appNums = array();

        while ($row = $result->fetch_assoc()) {
            array_push($appNums, $row['App_Num']);
        }

        $db_conn->begin_transaction();

        // Go through each app number and delete the Document
        for ($i = 0; $i < count($appNums); $i++) {
            $sql_query = "DELETE FROM document WHERE App_Num = '$appNums[$i]'";
            $result = $db_conn->query($sql_query);

            if (!$result) {
                die("Query failed: " . $db_conn->error);
            }
        }

        $sql_query = "DELETE FROM application WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }

        $db_conn->commit();
    }

    function DELETE_EventTrackingwithEvent($uin){
        include "../connection.php";

        $db_conn->begin_transaction();

        $sql_query = "DELETE FROM event_tracking WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }

        $sql_query = "DELETE FROM event WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }


        $db_conn->commit();    
    }

    function DELETE_Track($uin){
        include "../connection.php";

        $sql_query = "DELETE FROM track WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }
    }

    function DELETE_ClassEnrollment($uin){
        include "../connection.php";
        $sql_query = "DELETE FROM class_enrollment WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }
    }


    function DELETE_InternApp($uin){
        include "../connection.php";
        $sql_query = "DELETE FROM intern_app WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }
    }


    function DELETE_CertEnrollment($uin){
        include "../connection.php";
        $sql_query = "DELETE FROM cert_enrollment WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }
    }

    function DELETE_CollegeStudent($uin){
        include "../connection.php";
        $sql_query = "DELETE FROM college_student WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }
    }

    function DELETE_User($uin){
        include "../connection.php";
        $sql_query = "DELETE FROM user WHERE UIN = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }
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

        $StudentInfo = SELECT_ViewStudent($UINView);
    
        $first_name = $StudentInfo['First_Name'];
        $m_initial = $StudentInfo['M_Initial'];
        $last_name = $StudentInfo['Last_Name'];
        $uin = $StudentInfo['UIN'];
        $email = $StudentInfo['Email'];
        $discord_name = $StudentInfo['Discord_Name'];
        $username = $StudentInfo['Username'];
        $password = $StudentInfo['Password'];
        $gender = $StudentInfo['Gender'];
        $hispanic_latino = convertToBoolean($StudentInfo['Hispanic_Latino']) ? 'checked' : '';
        $race = $StudentInfo['Race'];
        $us_citizen = convertToBoolean($StudentInfo['US_Citizen']) ? 'checked' : '';
        $dob = $StudentInfo['DoB'];
        $first_gen = convertToBoolean($StudentInfo['First_Generation']) ? 'checked' : '';
        $gpa = $StudentInfo['GPA'];
        $major = $StudentInfo['Major'];
        $minor1 = $StudentInfo['Minor_1'];
        $minor2 = $StudentInfo['Minor_2'];
        $exp_grad = $StudentInfo['Expected_Graduation'];
        $school = $StudentInfo['School'];
        $curr_class = $StudentInfo['Current_Classification'];
        $student_type = $StudentInfo['Student_Type'];
        $phone = $StudentInfo['Phone'];

        


       
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