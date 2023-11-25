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