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

    //Function used to translate the Class_ID to Class_Name
    function getCourseName($Class_ID){
        include "../connection.php";
        $sql_query = "SELECT Name FROM classes WHERE Class_ID = '$Class_ID'";

        $result = $db_conn->query($sql_query);

        if ($result) {
            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                // Access individual columns in the current row
                $Class_Name = $row["Name"];
                return $Class_Name;

            }

        }
    }

    //Function used to translate the Class_Name to Class_ID
    function getClassID($Class_Name){
        include "../connection.php";
        $sql_query = "SELECT Class_ID FROM classes WHERE Name = '$Class_Name'";

        $result = $db_conn->query($sql_query);

        if ($result) {
            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                // Access individual columns in the current row
                $Class_ID = $row["Class_ID"];
                return $Class_ID;

            }

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
            <th>Class Name</th>
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


            //echo "<td><input type='text' name='Class_IDInput' value='" . $row["Class_ID"] . "'></td>";
            echo "<td><input type='text' name='Class_IDInput' value='" . getCourseName($row["Class_ID"]) . "'></td>";


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
        $Class_IDInput = getClassID($_POST['Class_IDInput']);
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
        $Class_ID = getClassID($_POST['Class_IDInsert']);
        $Status = $_POST['StatusInsert'];
        $Semester = $_POST['SemesterInsert'];
        $Year = $_POST['YearInsert'];
        
        $sql_query = "INSERT INTO `class_enrollment` (UIN, Class_ID, Status, Semester, Year) VALUES ($UIN, $Class_ID, '$Status', '$Semester', '$Year')";
        $result = $db_conn->query($sql_query);
    }


    //Function used to translate the cert_id to the certificaiton name
    function getCertName($Cert_ID){
        include "../connection.php";
        $sql_query = "SELECT Name FROM `certification` WHERE Cert_ID = '$Cert_ID'";

        $result = $db_conn->query($sql_query);

        if ($result) {
            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                // Access individual columns in the current row
                $Cert_Name = $row["Name"];
                return $Cert_Name;

            }

        }
    }

    //Function used to translate the cert_id to the level of the certificaiton
    function getCertLevel($Cert_ID){
        include "../connection.php";
        $sql_query = "SELECT Level FROM `certification` WHERE Cert_ID = '$Cert_ID'";

        $result = $db_conn->query($sql_query);

        if ($result) {
            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                // Access individual columns in the current row
                $Cert_Level = $row["Level"];
                return $Cert_Level;

            }

        }
    }


    //Function used to translate the cert_name and level to get the specific cert_id
    function getCertID($Cert_Name, $Cert_Level){
        include "../connection.php";
        $sql_query = "SELECT Cert_ID FROM `certification` WHERE Name = '$Cert_Name' AND Level = '$Cert_Level'";


        $result = $db_conn->query($sql_query);

        if ($result) {
            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                // Access individual columns in the current row
                $Cert_ID = $row["Cert_ID"];
                return $Cert_ID;

            }

        }

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
            <th>Cert Name</th>
            <th>Level </th>
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
            echo "<td><input type='text' name='Cert_IDInput' value='" . getCertName($row["Cert_ID"]) . "'></td>";
            
            
            echo "<td><input type='text' name='Cert_LevelInput' value='" . getCertLevel($row["Cert_ID"]) . "'></td>";
            
            
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
        $Cert_IDInput = getCertID($_POST['Cert_IDInput'],$_POST['Cert_LevelInput']);
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
        $Cert_ID = getCertID($_POST['Cert_CertIDInsert'], $_POST['Cert_LevelInsert']);
        $Status = $_POST['Cert_StatusInsert'];
        $Training_Status = $_POST['Cert_Training_StatusInsert'];
        $Program_Num = $_POST['Cert_Program_NumInsert'];
        $Semester = $_POST['Cert_SemesterInput'];
        $Year = $_POST['Cert_YearInsert'];


        $sql_query = "INSERT INTO `cert_enrollment` (UIN, Cert_ID, Status, Training_Status, Program_Num, Semester, Year) VALUES ($UIN, $Cert_ID, '$Status', '$Training_Status', $Program_Num, '$Semester', '$Year')";
        $result = $db_conn->query($sql_query);
    }



    //Function used to translate the intern_id to the name of the internship
    function getInternName($Intern_ID){
        include "../connection.php";
        $sql_query = "SELECT Name FROM `internship` WHERE Intern_ID = '$Intern_ID'";

        $result = $db_conn->query($sql_query);

        if ($result) {
            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                // Access individual columns in the current row
                $Intern_Name = $row["Name"];
                return $Intern_Name;
            }

        }
    }

    //Function used to translate the intern_id to the employer of the internship
    function getInternEmployer($Intern_ID){
        include "../connection.php";
        $sql_query = "SELECT Employer FROM `internship` WHERE Intern_ID = '$Intern_ID'";

        $result = $db_conn->query($sql_query);

        if ($result) {
            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                // Access individual columns in the current row
                $Intern_Employer = $row["Employer"];
                return $Intern_Employer;
            }

        }
    }

    //Function used to translate the name and employer of the internship to the specific intern_id
    function getInternID($Intern_Name, $Intern_Employer){
        include "../connection.php";
        $sql_query = "SELECT Intern_ID FROM `internship` WHERE Name = '$Intern_Name' AND Employer = '$Intern_Employer'";


        $result = $db_conn->query($sql_query);

        if ($result) {
            // Loop through the results
            while ($row = $result->fetch_assoc()) {
                // Access individual columns in the current row
                $Intern_ID = $row["Intern_ID"];
                return $Intern_ID;

            }

        }
    }


    //Function called to display table of all internships that the 'UIN' passed has applied for, been rejected from, or has accepted
    function adminInternships($UIN){
        include "../connection.php";
        $sql_query = "SELECT * FROM `intern_app` WHERE `UIN` = '$UIN'";
        $result = $db_conn->query($sql_query);

        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        echo "<table border='1'>
        <tr>
            <th>IA_Num</th>
            <th>UIN</th>
            <th>Internship Name</th>
            <th>Employer</th>
            <th>Status</th>
            <th>Year</th>
        </tr>";

        //For each loop that creates a table that not only displays the table but allows users to update and delete rows as needed
        foreach ($data as $row) {
            
            echo "<tr>";
            echo "<form action='ProgramProgress.php' method='post'>";
            echo "<td>" . $row["IA_Num"] . "</td>";
            echo "<td>" . $row["UIN"] . "</td>";
           
            echo "<td><input type='text' name='Intern_Intern_IDInput' value='" . getInternName($row["Intern_ID"]) . "'></td>";
            echo "<td><input type='text' name='Intern_EmployerInput' value='" . getInternEmployer($row["Intern_ID"]) . "'></td>";
           
            echo "<td><input type='text' name='Intern_StatusInput' value='" . $row["Status"] . "'></td>";
            echo "<td><input type='text' name='Intern_YearInput' value='" . $row["Year"] . "'></td>";
            echo "<td><input type='hidden' name='Intern_IA_NumInput' value='" . $row["IA_Num"] . "'>";
            echo "<td><input type='hidden' name='Intern_UINInput' value='" . $row["UIN"] . "'>";
            echo "<td><input type='hidden' name='UpdateIntern' value='updateIntern'>"; //the updateCourseEnrollment value triggerrs the if statment in the main part of this php file and puts all the values in the post array to be accesssed later
            echo "<input type='submit' value='Update'></td>";
            echo "</form>";
            echo "<form action='ProgramProgress.php' method='post'>";
            echo "<td><input type='hidden' name='IA_Num' value='" . $row["IA_Num"] . "'>";
            echo "<td><input type='hidden' name='DeleteIntern' value='deleteIntern'>"; //the deleteCourseEnrollment value triggerrs the if statment in the main part of this php file and puts all the values in the post array to be accesssed later
            echo "<input type='submit' value='Delete'></td>";
            echo "</form>";
            echo "</tr>";
        }


        echo "</table>";
    }

    //Function that queries the database and deletes the specifc internship a UIN has given the IA_Num
    function deleteIntern($IA_Num){
        include "../connection.php";
        $sql_query = "DELETE FROM `intern_app` WHERE `IA_Num` = '$IA_Num'";
        $result = $db_conn->query($sql_query); 
    }

    //Function that queries the database and updates a particular row of the internship table for the a particular UIN
    function updateIntern(){
        include "../connection.php";
        $IA_Num = $_POST['Intern_IA_NumInput'];
        $UIN = $_POST['Intern_UINInput'];
        $Intern_ID = getInternID($_POST['Intern_Intern_IDInput'], $_POST['Intern_EmployerInput']);
        $Status = $_POST['Intern_StatusInput'];
        $Year = $_POST['Intern_YearInput'];

        $sql_query = "UPDATE `intern_app` SET Intern_ID='$Intern_ID', Status='$Status', Year='$Year' WHERE IA_Num='$IA_Num' AND UIN='$UIN'";
        $result = $db_conn->query($sql_query);

    }

    //Function that queries the database and inserts a new record into the intern_app table based on the values passed in by the admin
    
    
    function insertIntern(){
        include "../connection.php";

        
        $UIN = $_POST['Intern_UINInsert'];
        $Intern_ID = getInternID($_POST['Intern_InternIDInsert'], $_POST['Intern_EmployerInsert']);
        $Status = $_POST['Intern_StatusInsert'];
        $Year = $_POST['Intern_YearInsert'];

        $sql_query = "INSERT INTO `intern_app` (UIN, Intern_ID, Status, Year) VALUES ($UIN, $Intern_ID, '$Status', '$Year')";
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
    else if(array_key_exists('DeleteIntern',$_POST)){
        deleteIntern($_POST['IA_Num']);
    }
    else if(array_key_exists('UpdateIntern',$_POST)){
        updateIntern();
    }
    else if(array_key_exists('InsertIntern',$_POST)){
        insertIntern();
    }

?>



