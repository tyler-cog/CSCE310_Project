<!-- Code written by Sydney Beeler -->

<?php
    function selectActivePrograms() {
        include "../connection.php";
        
        $sql_query = "SELECT * FROM programs WHERE Status='Active'"; 
    
        $result = $db_conn->query($sql_query);
    
        if ($result) {
            return $result; 
        } else {
            die("Error fetching programs: " . $db_conn->error);
        }
    }


    function selectAllPrograms() {
        include "../connection.php";

        $sql_query = "SELECT * FROM programs"; 
    
        $result = $db_conn->query($sql_query);
    
        if ($result) {
            return $result; 
        } else {
            die("Error fetching programs: " . $db_conn->error);
        }
    }


    function updateProgram() {
        include "../connection.php";
        
        $ID = $_REQUEST['ID'];
        $Name = $_REQUEST['Name'];
        $Description = $_REQUEST['Description'];
        $Status = $_REQUEST['Status'];
        
        $sql_query = "UPDATE programs SET Name='$Name', Description='$Description', Status='$Status' WHERE Program_Num='$ID'";
        $result = $db_conn->query($sql_query);
    }


    function deleteProgram() {
        include "../connection.php";
        
        $ID = $_REQUEST['ID'];
        
        $delete = $db_conn->query("DELETE FROM programs WHERE Program_Num='$ID'");
    }


    function displayProgramsTable($active) {
        if ($active) {
            $programs = selectActivePrograms();
        }
        else {
            $programs = selectAllPrograms();
        }
        
        $html = '<div><table border="1">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>';
    
        if ($programs && $programs->num_rows > 0) {
            while ($row = $programs->fetch_assoc()) {
                $html .= "<tr>
                            <td>" . $row['Program_Num'] . "</td>
                            <form method='POST'>
                                <td><input type='text' style='width:120px' name='Name' value='" . $row['Name'] . "'</td>
                                <td><input type='text' style='width:600px' name='Description' value='" . $row['Description'] . "'</td>
                                <td><input type='text' style='width:60px' name='Status' value='" . $row['Status'] . "'</td>
                                <td><input type='hidden' name='ID' value='" . $row['Program_Num'] . "'</td>

                                <td><input type='submit' name='updateProgram' value='Update'></td>
                                <td><input type='submit' name='deleteProgram' value='Delete'></td>
                            </form>
                          </tr>";
            }
        } else {
            $html .= "<tr><td colspan='8'>No active programs found.</td></tr>";
        }

        echo $html;
        echo "</table>";
    }


    //////////////////////////////////////////////////////////////////////////////
    function insertProgram() {
        include "../connection.php";

        $Name = $_REQUEST['Name'];
        $Description = $_REQUEST['Description'];
        $Status = $_REQUEST['Status'];

        if ($Status == "active"){
            $Status = "Active";
        }
        
        $sql_query = "INSERT INTO programs (Name, Description, Status) VALUES ('$Name', '$Description', '$Status')";
        $result = $db_conn->query($sql_query);

        if ($result) {
            echo "New program added successfully.";
        } else {
            echo "Error adding program: " . $db_conn->error;
        }
    }


    //////////////////////////////////////////////////////////////////////////////
    function isValidProgramNum($ID) {
        include "../connection.php";

        $result = $db_conn->query("SELECT * FROM programs WHERE Program_Num=$ID");

        if (!$result) {
            die("Query failed: " . $db_conn->error);
        }

        if($result->num_rows == 1) {
            return true;
        }
        return false;
    }
 

    function generateReport() {
        include "../connection.php";

        $ID = $_POST['ID'];

        // get program name and status 
        $sql_query = "SELECT Name, Status FROM programs WHERE Program_Num=$ID";
        $result = $db_conn->query($sql_query)->fetch_assoc(); 
        $program = $result['Name'];
        $status = $result['Status'];
        echo "<br><h4> Program: " . $program . "</h4>";
        echo "Program status: " . $status;


        // create view showing all program students 
        $sql_query = "CREATE OR REPLACE VIEW `Program Students` AS
                      SELECT college_student.UIN, Gender, Hispanic_Latino, Race, First_Generation, US_Citizen, Major, GPA
                      FROM college_student 
                      JOIN track 
                      ON college_student.UIN=track.UIN 
                      AND track.Program_Num=$ID";

        $result = $db_conn->query($sql_query);
        $students = $db_conn->query("SELECT * FROM `Program Students`");


        // get number of students in the program
        $sql_query = "SELECT COUNT(*) as 'Student_Count' FROM `Program Students`";
        $student_count = $db_conn->query($sql_query)->fetch_assoc()['Student_Count']; 
        echo "<br> Students in program: " . $student_count;


        // get number of applications to the program
        $sql_query = "SELECT COUNT(*) as 'App_Count' FROM application WHERE application.Program_Num=$ID";
        $application_count = $db_conn->query($sql_query)->fetch_assoc()['App_Count'];
        echo "<br> Number of program applications: " . $application_count; 


        // get average GPA of students in the program 
        $sql_query = "SELECT AVG(GPA) AS 'Avg_GPA' FROM `Program Students`";
        $avg_GPA = $db_conn->query($sql_query)->fetch_assoc()['Avg_GPA'];
        echo "<br> Average student GPA: " . $avg_GPA;


        // get student demographic information
        echo "<br><h4> Student demographics: </h4>";

        $demo_table = '<div><table border="1">
                <thead>
                <tr>
                    <th>UIN</th>
                    <th>Gender</th>
                    <th>Hispanic/Latino</th>
                    <th>Race</th>
                    <th>First Generation</th>
                    <th>U.S. Citizen</th>
                </tr>
                </thead>
                <tbody>';

        if ($students && $students->num_rows > 0) {
            while ($row = $students->fetch_assoc()) {
                $HL = "No";
                $first_gen = "No";
                $citizen = "No";

                if ($row['Hispanic_Latino'] == 1) {
                    $HL = "Yes";
                }
                if ($row['First_Generation'] == 1) {
                    $first_gen = "Yes";
                } 
                if ($row['US_Citizen'] == 1) {
                    $citizen = "Yes";
                }

                $demo_table .= "<tr>
                        <td>" . $row['UIN'] . "</td>
                        <td>" . $row['Gender'] . "</td>
                        <td>" . $HL . "</td>
                        <td>" . $row['Race'] . "</td>
                        <td>" . $first_gen . "</td>
                        <td>" . $citizen . "</td>
                    </tr>";
            }
        } else {
            $demo_table .= "<tr><td colspan='8'>No students found.</td></tr>";
        }
    
        echo $demo_table;
        echo "</table>";


        // get majors and courses taken by students in the program
        echo "<br><h4> Student majors and courses: </h4>";
        $students = $db_conn->query("SELECT * FROM `Program Students`");
        $course_table = '<div><table border="1">
                <thead>
                <tr>
                    <th>UIN</th>
                    <th>Major</th>
                    <th>Courses</th>
                </tr>
                </thead>
                <tbody>';

        if ($students && $students->num_rows > 0) {
            while ($row = $students->fetch_assoc()) {
                $UIN = $row['UIN'];
                $sql_query = "SELECT classes.Name 
                      FROM classes JOIN class_enrollment 
                      WHERE classes.Class_ID=class_enrollment.Class_ID 
                      AND class_enrollment.UIN=$UIN";
                $classes = $db_conn->query($sql_query);

                $course_table .= "<tr>
                        <td>" . $row['UIN'] . "</td>
                        <td>" . $row['Major'] . "</td>
                        <td>
                            <table>
                                ";
                            if($classes->num_rows > 0){
                                while($course_row = $classes->fetch_assoc()) {
                                    $course_table .= "<tr>
                                                        <td>" . $course_row['Name'] . "</td>
                                                      </tr>";
                                }
                            }
                $course_table .= "
                            </table>
                        </td>
                    </tr>";
            }
        } else {
            $course_table .= "<tr><td colspan='8'>No students found.</td></tr>";
        }

        echo $course_table;
        echo "</table>";


        // get internship stats
        echo "<br><h4> Student internships: </h4>";

        $sql_query = "CREATE OR REPLACE VIEW `Internships` AS
                      SELECT internship.Is_Gov, intern_app.Status 
                      FROM internship 
                      JOIN intern_app 
                      ON internship.Intern_ID=intern_app.Intern_ID 
                      JOIN `Program Students`
                      ON intern_app.UIN=`Program Students`.UIN";
        $result = $db_conn->query($sql_query);

        $sql_query = "SELECT COUNT(*) as 'Num_Internships' FROM `Internships` WHERE Status='Offer accepted'";
        $intern_count = $db_conn->query($sql_query)->fetch_assoc()['Num_Internships']; 
        echo "Number of accepted internships for program students: " . $intern_count . "<br>";

        $sql_query = "SELECT COUNT(*) as 'Num_Federal' FROM `Internships` WHERE Is_Gov=0x01 AND Status='Offer accepted'";
        $federal_count = $db_conn->query($sql_query)->fetch_assoc()['Num_Federal']; 
        echo "Number of accepted federal internships for program students: " . $federal_count . "<br><br>";
        

        // get internship details for students in the program 
        $students = $db_conn->query("SELECT * FROM `Program Students`");
        $intern_table = '<div><table border="1">
                <thead>
                <tr>
                    <th>UIN</th>
                    <th>Internships</th>
                </tr>
                </thead>
                <tbody>';

        if ($students && $students->num_rows > 0) {
            while ($row = $students->fetch_assoc()) {
                $UIN = $row['UIN'];
                $sql_query = "SELECT internship.Name, internship.Description, internship.Employer, intern_app.Status,
                                     IF(internship.Is_Gov = 0x01, 'Yes', 'No') AS 'Is_Gov' 
                              FROM internship 
                              JOIN intern_app 
                              WHERE internship.Intern_ID=intern_app.Intern_ID 
                              AND intern_app.UIN=$UIN";
                $internships = $db_conn->query($sql_query);

                $intern_table .= "<tr>
                        <td>" . $row['UIN'] . "</td>
                        <td>";
                            if($internships->num_rows > 0) {
                                $intern_table .= "<table border='1'>
                                <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Employer</th>
                                    <th>Description</th>
                                    <th>Federal</th>
                                    <th>Application Status</th>
                                </tr>
                                </thead>";
                                while($internship_row = $internships->fetch_assoc()) {
                                    $intern_table .= "<tr>
                                                        <td>" . $internship_row['Name'] . "</td>
                                                        <td>" . $internship_row['Employer'] . "</td>
                                                        <td>" . $internship_row['Description'] . "</td>
                                                        <td>" . $internship_row['Is_Gov'] . "</td>
                                                        <td>" . $internship_row['Status'] . "</td>
                                                      </tr>";
                                }
                                $intern_table .= "</table>";
                            }
                $intern_table .= "
                        </td>
                    </tr>";
            }
        } else {
            $intern_table .= "<tr><td colspan='8'>No students found.</td></tr>";
        }

        echo $intern_table;
        echo "</table>";


        // get certification details for students in the program 
        echo "<br><h4> Student program certifications: </h4>";
        $students = $db_conn->query("SELECT * FROM `Program Students`");
        $cert_table = '<div><table border="1">
                <thead>
                <tr>
                    <th>UIN</th>
                    <th>Program Certifications</th>
                </tr>
                </thead>
                <tbody>';

        if ($students && $students->num_rows > 0) {
            while ($row = $students->fetch_assoc()) {
                $UIN = $row['UIN'];
                $sql_query = "SELECT certification.Level, certification.Name, certification.Description, 
                                     cert_enrollment.Status, cert_enrollment.Training_Status
                      FROM certification JOIN cert_enrollment 
                      WHERE cert_enrollment.Cert_ID=certification.Cert_ID 
                      AND cert_enrollment.UIN=$UIN
                      AND cert_enrollment.Program_Num=$ID";
                $certifications = $db_conn->query($sql_query);

                $cert_table .= "<tr>
                        <td>" . $row['UIN'] . "</td>
                        <td>";
                            if($certifications->num_rows > 0) {
                                $cert_table .= "<table border='1'>
                                <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Training Status</th>
                                </tr>
                                </thead>";
                                while($cert_row = $certifications->fetch_assoc()) {
                                    $cert_table .= "<tr>
                                                        <td>" . $cert_row['Level'] . "</td>
                                                        <td>" . $cert_row['Name'] . "</td>
                                                        <td>" . $cert_row['Description'] . "</td>
                                                        <td>" . $cert_row['Status'] . "</td>
                                                        <td>" . $cert_row['Training_Status'] . "</td>
                                                      </tr>";
                                }
                                $cert_table .= "</table>";
                            }
                $cert_table .= "
                        </td>
                    </tr>";
            }
        } else {
            $cert_table .= "<tr><td colspan='8'>No students found.</td></tr>";
        }

        echo $cert_table;
        echo "</table>";
    }


    //////////////////////////////////////////////////////////////////////////////
    if(array_key_exists('updateProgram', $_POST)) {
        updateProgram();
    }
    else if(array_key_exists('deleteProgram', $_POST)) {
        deleteProgram();
    }
?>