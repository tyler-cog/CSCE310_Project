<!-- 

    Code was written by Riley Szecsy

-->



<!-- Includes the php files needed so that the dont need to be included in the future -->
<?php
    include "../connection.php";
    include "ProgramProgressHelper.php";
    //$_POST = array();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProgramProgress</title>
    <link rel="stylesheet" href="../Style/ProgramProgress.css">
</head>
<body>
    <a href="../Admin/AdminHome.php" title="Back">←</a>

    <div class="title">
        <h1>ADMIN PROGRAM PROGRESS TRACKING<h1>
    </div> 

    <div class="section">
        <h2>STUDENT SELECTION</h2>
        <div class="studentSelection">
        <!-- This php block makes sure that the UIN entered is valid and the stores that UIN in a session variable called UIN -->
            <form class="studentSelectionForm" action="ProgramProgress.php" method="POST">
                <?php


                    session_start();

                    if(!empty($_POST["UIN"])){

                        $UIN = $_POST["UIN"];
                        if (!(isValidUIN($UIN))){
                            echo '<h3>**INVALID UIN PLEASE ENTER NEW UIN**<h3>';
                        }
                        else{
                            $_SESSION['UIN'] = $UIN;
                        }

                        
                    }
                ?>
                <label>UIN:</label>
                <input type="text" id="UIN" name="UIN">
                <input type="submit" value="Submit">
                </form>
            </form>
        </div>
    </div>

    <div class="section">
        <h2>COURSE ENROLLMENT</h2>
        <div class="studentSelection">
            <!-- This calls the adminCourseEnrollment function from the helper php file -->
            <?php
                adminCourseEnrollment($_SESSION["UIN"]);
            ?>

            <br>

            <!-- Insert form for adding course enrollments that queries the database on sumbit -->
            <form class="CourseEnrollmentInsert" action="ProgramProgress.php" method="POST">
                    
                
                <label>UIN:</label>
                <input type="text" id="UINInsert" name="UINInsert">
                    
                <label>Class Name:</label>
                <input type="text" id="Class_IDInsert" name="Class_IDInsert">
                
                <label>Status:</label>
                <input type="text" id="StatusInsert" name="StatusInsert">

                <label>Semester:</label>
                <input type="text" id="SemesterInsert" name="SemesterInsert">

                <label>Year:</label>
                <input type="text" id="YearInsert" name="YearInsert">

                <input type='hidden' name='InsertCourseEnrollment' value='insertCourseEnrollment'>
                
                
                <input type="submit" value="Submit">
            </form>
            
        </div>
    </div>

    <div class="section">
        <h2>CERTIFICATIONS</h2>
        <div class="studentSelection">
            <!-- This calls the adminCertifications function from the helper php file -->
            <?php
                adminCertifications($_SESSION["UIN"]);
            ?>
            <br>

             <!-- Insert form for adding certifications that queries the database on sumbit -->
            <form class="Certification" action="ProgramProgress.php" method="POST">
                    <label>UIN:</label>
                    <input type="text" id="Cert_UINInsert" name="Cert_UINInsert">
                    
                    <label>Cert Name:</label>
                    <input type="text" id="Cert_CertIDInsert" name="Cert_CertIDInsert">

                    <label>Cert Level:</label>
                    <input type="text" id="Cert_LevelInsert" name="Cert_LevelInsert">
                    
                    <label>Status:</label>
                    <input type="text" id="Cert_StatusInsert" name="Cert_StatusInsert">

                    <label>Traning Status:</label>
                    <input type="text" id="Cert_Training_StatusInsert" name="Cert_Training_StatusInsert">

                    <label>Program:</label>
                    <input type="text" id="Cert_Program_NumInsert" name="Cert_Program_NumInsert">

                    <label>Semester:</label>
                    <input type="text" id="Cert_SemesterInput" name="Cert_SemesterInput">

                    <label>Year:</label>
                    <input type="text" id="Cert_YearInsert" name="Cert_YearInsert">

                    <input type='hidden' name='InsertCertification' value='insertCertification'>

                    <input type="submit" value="Submit">


            </form>

        </div>
    </div>

    <div class="section">
        <h2>INTERNSHIPS</h2>
        <!-- This calls the adminInternships function from the helper php file -->
        <?php
            adminInternships($_SESSION["UIN"]);
        ?>
        <br>

        <!-- Insert form for adding internships that queries the database on sumbit -->
        <form class="Internships" action="ProgramProgress.php" method="POST">
            <label>UIN:</label>
            <input type="text" id="Intern_UINInsert" name="Intern_UINInsert">
            
            <label>Internship Name:</label>
            <input type="text" id="Intern_InternIDInsert" name="Intern_InternIDInsert">

            <label>Employer:</label>
            <input type="text" id="Intern_EmployerInsert" name="Intern_EmployerInsert">
            
            <label>Status:</label>
            <input type="text" id="Intern_StatusInsert" name="Intern_StatusInsert">

            <label>Year:</label>
            <input type="text" id="Intern_YearInsert" name="Intern_YearInsert">

            <input type='hidden' name='InsertIntern' value='insertIntern'>

            <input type="submit" value="Submit">
        </form>



    </div>

    <div class="section">
        <h2>PROGRAMS</h2>
        <!-- This calls the adminInternships function from the helper php file -->
        

    </div>

    <div class="section">
        <h2>PROGRAM APPLICATIONS</h2>
        <p>Content for section 6 goes here.</p>
    </div>
</body>
</html>
