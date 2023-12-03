<!-- 

    Code was written by Riley Szecsy

-->



<!-- Includes the php files needed so that they don't need to be included in the future -->
<?php
    include "../connection.php";
    include "ProgramProgressHelper.php";

    session_start();

    //Function that gets student UIN from the username
    $UIN = getUIN($_SESSION['username']);

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
    <a href="../Student/StudentHome.php" title="Back">←</a>

    <div class="title">
        <h1>STUDENT PROGRAM PROGRESS TRACKING<h1>
    </div> 


    <div class="section">
        <h2>COURSE ENROLLMENT</h2>
        <div class="studentSelection">
            <!-- This calls the studentCourseEnrollment function from the helper php file -->
            <?php
                studentCourseEnrollment($UIN);
            ?>

            <br>

            <!-- Insert form for adding course enrollments that queries the database on submit -->
            <form class="CourseEnrollmentInsert" action="ProgramProgress.php" method="POST">
                    
                <?php
                    echo "<td><input type='hidden' name='UINInsert' value='" . $UIN . "'></td>";
                ?>
                    
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
            <!-- This calls the studentCertifications function from the helper php file -->
            <?php
                studentCertifications($UIN);
            ?>
            <br>

             <!-- Insert form for adding certifications that queries the database on submit -->
            <form class="Certification" action="ProgramProgress.php" method="POST">
                    
                    <?php
                        echo "<td><input type='hidden' name='Cert_UINInsert' value='" . $UIN . "'></td>";
                    ?>
                
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
        <!-- This calls the studentInternships function from the helper php file -->
        <?php
            studentInternships($UIN);
        ?>
        <br>

        <!-- Insert form for adding internships that queries the database on submit -->
        <form class="Internships" action="ProgramProgress.php" method="POST">


            <?php
                echo "<td><input type='hidden' name='Intern_UINInsert' value='" . $UIN . "'></td>";
            ?>

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
        <!-- This calls the studentPrograms function from the helper php file -->
        <?php
            studentPrograms($UIN);
        ?>

        <br>
        <!-- Insert form for adding program track that queries the database on submit -->
        <form class="Programs" action="ProgramProgress.php" method="POST">

            <?php
                echo "<td><input type='hidden' name='Program_UINInsert' value='" . $UIN . "'></td>";
            ?>
            
            <label>Program Name:</label>
            <input type="text" id="Program_Program_NameInsert" name="Program_Program_NameInsert">

            <input type='hidden' name='InsertProgram' value='insertProgram'>

            <input type="submit" value="Submit">
        </form>

    </div>
</body>
</html>
