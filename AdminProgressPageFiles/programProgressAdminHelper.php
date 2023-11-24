<?php

    function isValidUIN($UIN){
        include "../connection.php";
        $sql_query = "SELECT * FROM `college_student` WHERE `UIN` = '$UIN'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        if($result->num_rows == 1){
            return true;
        }
        else{
            return false;
        }

        
    }

    

?>