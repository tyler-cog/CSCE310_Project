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
        <a href="../Admin/AdminHome.php" title="Back">←</a>
    </div>

   <div class="greyBack"> 
            <div class="regBox">
                <p class="regWord">PROGRAM MANAGEMENT</p>
                <div class="maroonDivider"></div>

                <div class="section">
                    <h2>View, Update, and Delete Programs</h2>
                    <div class="programSelection">
                        <?php
                            if(array_key_exists('selectActivePrograms', $_POST)) {
                                echo displayProgramsTable($active=TRUE);
                            }
                            else if(array_key_exists('selectAllPrograms', $_POST)) {
                                echo displayProgramsTable($active=FALSE);
                            }
                        ?>

                        <br>

                        <!-- Buttons to view active or all programs -->
                        <form method="post"> 
                            <input type="submit" name="selectActivePrograms" class="button" value="View Active Programs" /> 
                            <input type="submit" name="selectAllPrograms" class="button" value="View All Programs" /> 
                        </form> 
                        

                    </div>
                </div>
            </div>
    </div>
</body>
</html>
