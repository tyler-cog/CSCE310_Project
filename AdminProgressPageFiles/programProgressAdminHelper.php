<?php

    function isValidUIN($UIN){
        include "../connection.php";
        $sql_query = "SELECT * FROM `college_student` WHERE `UIN` = '$UIN'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }

        if($result->num_rows == 1){
            return true;
        }
        else{
            return false;
        }

        
    }

    function adminCourseEnrollment($UIN){
        include "../connection.php";
        $sql_query = "SELECT * FROM `class_enrollment` WHERE `UIN` = '$UIN'";
        $result = $db_conn->query($sql_query);

        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        echo "<table border='1'>
        <tr>
            <th>CE_Num</th>
            <th>UIN</th>
            <th>Class_ID</th>
            <th>Status</th>
            <th>Semester</th>
            <th>Year</th>
        </tr>";

        foreach ($data as $row) {
            echo "<tr>";
            echo "<form action='programProgressAdmin.php' method='post'>";
            echo "<td>" . $row["CE_Num"] . "</td>";
            echo "<td>" . $row["UIN"] . "</td>";
            echo "<td><input type='text' name='Class_IDInput' value='" . $row["Class_ID"] . "'></td>";
            echo "<td><input type='text' name='StatusInput' value='" . $row["Status"] . "'></td>";
            echo "<td><input type='text' name='SemesterInput' value='" . $row["Semester"] . "'></td>";
            echo "<td><input type='text' name='YearInput' value='" . $row["Year"] . "'></td>";
            echo "<td><input type='hidden' name='CE_NumInput' value='" . $row["CE_Num"] . "'>";
            echo "<td><input type='hidden' name='UINInput' value='" . $row["UIN"] . "'>";
            echo "<td><input type='hidden' name='UpdateCourseEnrollment' value='updateCourseEnrollment'>";
            echo "<input type='submit' value='Update'></td>";
            echo "</form>";
            echo "<form action='programProgressAdmin.php' method='post'>";
            echo "<td><input type='hidden' name='CE_Num' value='" . $row["CE_Num"] . "'>";
            echo "<td><input type='hidden' name='DeleteCourseEnrollment' value='deleteCourseEnrollment'>";
            echo "<input type='submit' value='Delete'></td>";
            echo "</form>";
            echo "</tr>";
        }

        echo "</table>";

    }

    function deleteCourseEnrollment($CE_Num){
        include "../connection.php";
        $sql_query = "DELETE FROM `class_enrollment` WHERE `CE_Num` = '$CE_Num'";
        $result = $db_conn->query($sql_query);
    }


    function updateCourseEnrollment(){
        include "../connection.php";

        $CE_NumInput = $_POST['CE_NumInput'];
        $UIN_Input = $_POST['UINInput'];
        $Class_IDInput = $_POST['Class_IDInput'];
        $StatusInput = $_POST['StatusInput'];
        $SemesterInput = $_POST['SemesterInput'];
        $YearInput = $_POST['YearInput'];


        $sql_query = "UPDATE `class_enrollment` SET Class_ID='$Class_IDInput', Status='$StatusInput', Semester='$SemesterInput', Year='$YearInput' WHERE CE_Num='$CE_NumInput' AND UIN='$UIN_Input'";
        $result = $db_conn->query($sql_query);
    }



    function insertCourseEnrollment(){
        include "../connection.php";

        $UIN = $_POST['UINInsert'];
        $Class_ID = $_POST['Class_IDInsert'];
        $Status = $_POST['StatusInsert'];
        $Semester = $_POST['SemesterInsert'];
        $Year = $_POST['YearInsert'];
        
        $sql_query = "INSERT INTO `class_enrollment` (UIN, Class_ID, Status, Semester, Year) VALUES ($UIN, $Class_ID, '$Status', '$Semester', '$Year')";
        $result = $db_conn->query($sql_query);
    }

    /*
        ISSUE IS THAT NEED TO DO IT LIKE THE UPDATE AND DELETE

        GETTING CALLED EVERYTIME THE PAGE LOADS (Table and INSERT)
    
    
    */


    if(array_key_exists('DeleteCourseEnrollment',$_POST)){
        deleteCourseEnrollment($_POST['CE_Num']);
    }
    else if(array_key_exists('UpdateCourseEnrollment', $_POST)){
        updateCourseEnrollment();
    }
    else if(array_key_exists('InsertCourseEnrollment', $_POST)){
        insertCourseEnrollment();
    }

?>



