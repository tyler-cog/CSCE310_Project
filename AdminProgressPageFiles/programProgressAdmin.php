<?php
    include "../connection.php";
    include "programProgressAdminHelper.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProgramProgressAdmin</title>
    <link rel="stylesheet" href="programProgress.css">
</head>
<body>

    <div class="title">
        <h1>ADMIN PROGRAM PROGRESS TRACKING<h1>
    </div> 

    <div class="section">
        <h2>STUDENT SELECTION</h2>
        <div class="studentSelection">
        <form class="studentSelectionForm" action="programProgressAdmin.php" method="POST">
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
            <?php
                adminCourseEnrollment($_SESSION["UIN"]);
            ?>

            <br>

            <form class="CourseEnrollmentInsert" action="programProgressAdmin.php" method="POST">
                    
                
                <label>UIN:</label>
                <input type="text" id="UINInsert" name="UINInsert">
                    
                <label>Class ID:</label>
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
        <p>Content for section 3 goes here.</p>
    </div>

    <div class="section">
        <h2>INTERNSHIPS</h2>
        <p>Content for section 4 goes here.</p>
    </div>

    <div class="section">
        <h2>PROGRAMS</h2>
        <p>Content for section 5 goes here.</p>
    </div>

    <div class="section">
        <h2>PROGRAM APPLICATIONS</h2>
        <p>Content for section 6 goes here.</p>
    </div>
</body>
</html>
