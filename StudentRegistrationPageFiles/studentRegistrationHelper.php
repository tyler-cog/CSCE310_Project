<?php
    function validUIN($uin){
        include "../connection.php";
        if ($uin == ""){
            return true;
        }

        $uin = (int)$uin;

        if (($uin <= 0) || ($uin > 99999999999)){
            return false;
        }

        $sql_query = "SELECT * FROM `user` WHERE `UIN` = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        
        // If there's a result
        if ($result->num_rows > 0){
            return false;
        }

        else {
            return true;
        }
    }

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

    function validUsername($username){
        include "../connection.php";
        $sql_query = "SELECT * FROM `user` WHERE `Username` = '$username'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        
        // If there's a result
        if ($result->num_rows > 0){
            return false;
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

    function INSERT_CollegeStudent($uin, $gender, $hispanic_latino, $race, $us_citizen, $first_generation, 
    $dob, $gpa, $major, $minor1, $minor2, $expected_graduation, 
    $school, $current_classification, $student_type, $phone){
        include "../connection.php";

        $sql_query = "INSERT INTO college_student 
        (UIN, Gender, `Hispanic/Latino`, Race, `U.S._Citizen`, First_Generation, DoB, GPA, 
        Major, Minor_1, Minor_2, Expected_Graduation, School, Current_Classification, 
        Student_Type, Phone) 
        VALUES 
        ('$uin', '$gender', UNHEX('$hispanic_latino'), '$race', UNHEX('$us_citizen'), UNHEX('$first_generation'), 
        '$dob', '$gpa', '$major', '$minor1', '$minor2', '$expected_graduation', 
        '$school', '$current_classification', '$student_type', '$phone')";


        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
    }

    function INSERT_User($uin, $first_name, $m_initial, $last_name, $username, $password, $user_type, $email, $discord_name){
        include "../connection.php";

        $sql_query = "INSERT INTO user 
        (UIN, First_Name, M_Initial, Last_Name, Username, Password, User_Type, Email, Discord_Name) 
        VALUES 
        ('$uin', '$first_name', '$m_initial', '$last_name', '$username', '$password', '$user_type', '$email', '$discord_name')";

        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
    }
?>