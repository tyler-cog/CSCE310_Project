<!-- Code written by Sydney Beeler -->

<?php
    include "../connection.php";
    include "ProgramManagementHelper.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Program Information Management</title>
    <link rel="stylesheet" href="../Style/Home.css">
</head>
<body>
    <div class="maroonBar">
        <a class="arrow" href="../Admin/AdminHome.php" title="Back">← Back</a>
    </div>

   <div class="greyBack"> 
        <div class="regBox">
            <p class="regWord">PROGRAM MANAGEMENT</p>
            <div class="maroonDivider"></div>

            <!-- View, edit, and delete programs -->
            <!-- TODO: update delete query if needed --> 
            <div class="programTable">
                <h2>View, Edit, and Delete Programs</h2>
                <br>
                <!-- Buttons to view active or all programs -->
                <form method="POST"> 
                    <input type="submit" name="selectActivePrograms" class="button" value="View Active Programs" /> 
                    <input type="submit" name="selectAllPrograms" class="button" value="View All Programs" /> 
                </form> 

                <?php
                    if(array_key_exists('selectActivePrograms', $_POST)) {
                        displayProgramsTable($active=TRUE);
                    }
                    else if(array_key_exists('selectAllPrograms', $_POST)) {
                        displayProgramsTable($active=FALSE);
                    }
                ?>
            </div>
            
            <br> 
            <br>

            <!-- Insert new program -->
            <div class="insertProgram">
                <h2>Add New Program</h2>
                <br>
                <form method="POST">
                    <label>Name:</label>
                    <input type="text" name="Name" id="Name">
                    
                    <label>Description:</label>
                    <input type="text" name="Description" id="Description">

                    <label>Status:</label>
                    <input type="text" name="Status" id="Status">

                    <input type="submit" name="insertProgram" value="Insert">
                </form>
                <br>
                <?php
                    if(array_key_exists('insertProgram', $_POST)) {
                        insertProgram();
                    }
                ?>
            </div>

            <br>
            
            <!-- Generate report for a specified program --> 
            <!-- TODO --> 
            <!-- 
                Number of total program students
                Courses taken by program students
                Certifications of program students 
                Minority participation
                Number of students pursuing federal internships
                Student internships
                Majors of program students
            -->
            <div class="programReport">
                <h2>Generate Report</h2>
                <br>
                <form method="POST">
                    <label>Program ID:</label>
                    <input type="int" name="ID" id="ID">
                    
                    <input type="submit" name="generateReport" value="Generate Report">

                    <?php                        
                        if (!empty($_POST['ID'])) {
                            if (!(isValidProgramNum($_POST['ID']))) {
                                echo '<br><br> ERROR: invalid Program ID.';
                            }
                            else{
                                generateReport();
                            }
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
