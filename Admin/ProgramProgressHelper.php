<!-- 

    This code was written by Riley Szecsy

 --> 



<?php


    //This function checks if the UIN entered is contained within the database
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

    //Function called to display table of all courses that the 'UIN' passed in is taking or completed
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

        //For each loop that creates a table that not only displays the table but allows users to update and delete rows as needed 
        foreach ($data as $row) {
            echo "<tr>";
            echo "<form action='ProgramProgress.php' method='post'>";
            echo "<td>" . $row["CE_Num"] . "</td>";
            echo "<td>" . $row["UIN"] . "</td>";
            echo "<td><input type='text' name='Class_IDInput' value='" . $row["Class_ID"] . "'></td>";
            echo "<td><input type='text' name='StatusInput' value='" . $row["Status"] . "'></td>";
            echo "<td><input type='text' name='SemesterInput' value='" . $row["Semester"] . "'></td>";
            echo "<td><input type='text' name='YearInput' value='" . $row["Year"] . "'></td>";
            echo "<td><input type='hidden' name='CE_NumInput' value='" . $row["CE_Num"] . "'>";
            echo "<td><input type='hidden' name='UINInput' value='" . $row["UIN"] . "'>";
            echo "<td><input type='hidden' name='UpdateCourseEnrollment' value='updateCourseEnrollment'>"; //the updateCourseEnrollment value triggerrs the if statment in the main part of this php file and puts all the values in the post array to be accesssed later
            echo "<input type='submit' value='Update'></td>";
            echo "</form>";
            echo "<form action='ProgramProgress.php' method='post'>";
            echo "<td><input type='hidden' name='CE_Num' value='" . $row["CE_Num"] . "'>";
            echo "<td><input type='hidden' name='DeleteCourseEnrollment' value='deleteCourseEnrollment'>"; //the deleteCourseEnrollment value triggerrs the if statment in the main part of this php file and puts all the values in the post array to be accesssed later
            echo "<input type='submit' value='Delete'></td>";
            echo "</form>";
            echo "</tr>";
        }

        echo "</table>";

    }

    //Function that queries the database and deletes the specifc course a UIN is taking given the specific CE_NUM
    function deleteCourseEnrollment($CE_Num){
        include "../connection.php";
        $sql_query = "DELETE FROM `class_enrollment` WHERE `CE_Num` = '$CE_Num'";
        $result = $db_conn->query($sql_query);
    }


    //Function that queries the database and updates a particular row of the course enrollment table for the a particular UIN
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


    //Function that queries the database and inserts a new record into the class_enrollment table based on the values passed in by the admin
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


    //Function called to display table of all certification that the 'UIN' passed in has or is taking
    function adminCertifications($UIN){
        include "../connection.php";
        $sql_query = "SELECT * FROM `cert_enrollment` WHERE `UIN` = '$UIN'";

        $result = $db_conn->query($sql_query);


        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }


        echo "<table border='1'>
        <tr>
            <th>CertE_Num</th>
            <th>UIN</th>
            <th>Cert_ID</th>
            <th>Status</th>
            <th>Traning_Status</th>
            <th>Program_Num</th>
            <th>Semester</th>
            <th>Year</th>
        </tr>";


        //For each loop that creates a table that not only displays the table but allows users to update and delete rows as needed

        foreach ($data as $row) {
            echo "<tr>";
            echo "<form action='ProgramProgress.php' method='post'>";
            echo "<td>" . $row["CertE_Num"] . "</td>";
            echo "<td>" . $row["UIN"] . "</td>";
            echo "<td><input type='text' name='Cert_IDInput' value='" . $row["Cert_ID"] . "'></td>";
            echo "<td><input type='text' name='Cert_StatusInput' value='" . $row["Status"] . "'></td>";
            echo "<td><input type='text' name='Cert_Training_StatusInput' value='" . $row["Training_Status"] . "'></td>";
            echo "<td><input type='text' name='Cert_Program_NumInput' value='" . $row["Program_Num"] . "'></td>";
            echo "<td><input type='text' name='Cert_SemesterInput' value='" . $row["Semester"] . "'></td>";
            echo "<td><input type='text' name='Cert_YearInput' value='" . $row["Year"] . "'></td>";
            echo "<td><input type='hidden' name='Cert_CertE_NumInput' value='" . $row["CertE_Num"] . "'>";
            echo "<td><input type='hidden' name='Cert_UINInput' value='" . $row["UIN"] . "'>";
            echo "<td><input type='hidden' name='UpdateCertification' value='updateCertification'>"; //the updateCourseEnrollment value triggerrs the if statment in the main part of this php file and puts all the values in the post array to be accesssed later
            echo "<input type='submit' value='Update'></td>";
            echo "</form>";
            echo "<form action='ProgramProgress.php' method='post'>";
            echo "<td><input type='hidden' name='CertE_Num' value='" . $row["CertE_Num"] . "'>";
            echo "<td><input type='hidden' name='DeleteCertification' value='deleteCertification'>"; //the deleteCourseEnrollment value triggerrs the if statment in the main part of this php file and puts all the values in the post array to be accesssed later
            echo "<input type='submit' value='Delete'></td>";
            echo "</form>";
            echo "</tr>";
        }

        echo "</table>";

    }

    //Function that queries the database and deletes the specifc certification a UIN has given the CertE_Num
    function deleteCertification($CertE_Num){
        include "../connection.php";
        $sql_query = "DELETE FROM `cert_enrollment` WHERE `CertE_Num` = '$CertE_Num'";
        $result = $db_conn->query($sql_query);
    }

    //Function that queries the database and updates a particular row of the certifications table for the a particular UIN
    function updateCertification(){
        include "../connection.php";
        
        $Cert_CertE_NumInput = $_POST['Cert_CertE_NumInput'];
        $Cert_UINInput = $_POST['Cert_UINInput'];
        $Cert_IDInput = $_POST['Cert_IDInput'];
        $Cert_StatusInput = $_POST['Cert_StatusInput'];
        $Cert_Traning_StatusInput = $_POST['Cert_Training_StatusInput'];
        $Cert_Program_NumInput = $_POST['Cert_Program_NumInput'];
        $Cert_SemesterInput = $_POST['Cert_SemesterInput'];
        $Cert_YearInput = $_POST['Cert_YearInput'];

        $sql_query = "UPDATE `cert_enrollment` SET Cert_ID='$Cert_IDInput', Status='$Cert_StatusInput', Training_Status='$Cert_Traning_StatusInput', Program_Num='$Cert_Program_NumInput', Semester='$Cert_SemesterInput', Year='$Cert_YearInput' WHERE CertE_Num='$Cert_CertE_NumInput' AND UIN='$Cert_UINInput'";
        $result = $db_conn->query($sql_query);

    }

    //Function that queries the database and inserts a new record into the cert_enrollment table based on the values passed in by the admin
    function insertCertification(){
        include "../connection.php";

        $UIN = $_POST['Cert_UINInsert'];
        $Cert_ID = $_POST['Cert_CertIDInsert'];
        $Status = $_POST['Cert_StatusInsert'];
        $Training_Status = $_POST['Cert_Training_StatusInsert'];
        $Program_Num = $_POST['Cert_Program_NumInsert'];
        $Semester = $_POST['Cert_SemesterInput'];
        $Year = $_POST['Cert_YearInsert'];


        $sql_query = "INSERT INTO `cert_enrollment` (UIN, Cert_ID, Status, Training_Status, Program_Num, Semester, Year) VALUES ($UIN, $Cert_ID, '$Status', '$Training_Status', $Program_Num, '$Semester', '$Year')";
        $result = $db_conn->query($sql_query);
    }


    //Main part of the php file, when a submit button is pressed the values contained within the input determine which function should be called
    if(array_key_exists('DeleteCourseEnrollment',$_POST)){
        deleteCourseEnrollment($_POST['CE_Num']);
    }
    else if(array_key_exists('UpdateCourseEnrollment', $_POST)){
        updateCourseEnrollment();
    }
    else if(array_key_exists('InsertCourseEnrollment', $_POST)){
        insertCourseEnrollment();
    }
    else if(array_key_exists('DeleteCertification',$_POST)){
        deleteCertification($_POST['CertE_Num']);
    }
    else if(array_key_exists('UpdateCertification',$_POST)){
        updateCertification();
    }
    else if(array_key_exists('InsertCertification', $_POST)){
        insertCertification();
    }
    


?>



