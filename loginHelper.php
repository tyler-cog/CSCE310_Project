<?php
    function isValidLogin($username, $password){
        include "connection.php";
        $sql_query = "SELECT * FROM `user` WHERE `Username` = '$username'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        
        // If there's a result
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();

            // If password is correct
            if ($password == $row["Password"]){
                return true;
            }

            // If password is wrong
            else {
                return false;
            }
        }

        else {
            return false;
        }
        
    }

    function userType($username){
        include "connection.php";
        $sql_query = "SELECT * FROM `user` WHERE `Username` = '$username'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        // If the result of the query is nothing
        if ($result->num_rows == 0){
            return false;
        }

        // If the result of the query is nothing
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();

            // Student
            if ($row["User_Type"] == "Student"){
                return "Student";
            }

            // Admin
            if ($row["User_Type"] == "Admin"){
                return "Admin";
            }
        }
    }
?>