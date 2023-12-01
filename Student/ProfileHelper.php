<?php


    function validGPA($gpa){
        $gpa = (float)$gpa;

        if ($gpa < 0){
            return false;
        }

        if ($gpa > 4){
            return false;
        }

        return true;
    }

    function validUsername($username, $uin){
        include "../connection.php";
        $sql_query = "SELECT * FROM `user` WHERE `Username` = '$username'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        
        // If there's a result
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if ($row['UIN'] == $uin){
                return true;
            }

            else {
                return false;
            }

        }

        else {
            return true;
        }

    }

    function validPhoneNumber($phone){
        $phone = (float)$phone;

        if (!($phone == (int)$phone)){
            return false;
        }

        if ($phone < 0){
            return false;
        }

        return true;
    }

    function getUINFromUser($username){
        include "../connection.php";

        $sql_query = "SELECT * FROM `user` WHERE `Username` = '$username'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }


        $row = $result->fetch_assoc();
        return $row['UIN'];
    }

    function convertToBoolean($value) {
        return ($value == hex2bin('01'));
    }

    function SELECT_CollegeStudent($uin){
        include "../connection.php";

        $sql_query = "SELECT * FROM `college_student` WHERE `UIN` = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $row = $result->fetch_assoc();
        return $row;
    }


    function SELECT_User($uin){
        include "../connection.php";

        $sql_query = "SELECT * FROM `user` WHERE `UIN` = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $row = $result->fetch_assoc();
        return $row;
    }

    function UPDATE_CollegeStudent($uin, $gender, $hispanic_latino, $race, $us_citizen, $first_generation, 
    $dob, $gpa, $major, $minor1, $minor2, $expected_graduation, 
    $school, $current_classification, $student_type, $phone){
        include "../connection.php";

        $sql_query = "UPDATE college_student
                    SET Gender = '$gender',
                        `Hispanic/Latino` = UNHEX('$hispanic_latino'),
                        Race = '$race',
                        `U.S._Citizen` = UNHEX('$us_citizen'),
                        First_Generation = UNHEX('$first_generation'),
                        DoB = '$dob',
                        GPA = '$gpa',
                        Major = '$major',
                        Minor_1 = '$minor1',
                        Minor_2 = '$minor2',
                        Expected_Graduation = '$expected_graduation',
                        School = '$school',
                        Current_Classification = '$current_classification',
                        Student_Type = '$student_type',
                        Phone = '$phone'
                    WHERE UIN = '$uin'";

        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
    }

    function UPDATE_User($uin, $first_name, $m_initial, $last_name, $username, $password, $user_type, $email, $discord_name) {
        include "../connection.php";
    
        $sql_query = "UPDATE user
                      SET First_Name = '$first_name',
                          M_Initial = '$m_initial',
                          Last_Name = '$last_name',
                          Username = '$username',
                          Password = '$password',
                          User_Type = '$user_type',
                          Email = '$email',
                          Discord_Name = '$discord_name'
                      WHERE UIN = '$uin'";
    
        $result = $db_conn->query($sql_query);
    
        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }
    }

    




?>