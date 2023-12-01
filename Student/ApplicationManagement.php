<!-- Code written by Sydney Beeler -->

<?php
    include "../connection.php";
    include "ApplicationManagementHelper.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Style/Home.css?v=<?php echo time(); ?>" >
</head>
<body>
    <div class="maroonBar">
        <a href="../Student/StudentHome.php" title="Back">←</a>
    </div>

<!-- 
    a. Insert: Submit application forms for various programs.
    b. Update: Edit application details as needed.
    c. Select: Review their own application information and status.
    d. Delete: Remove a program application 
-->

   <div class="greyBack"> 
        <div class="regBox">
            <p class="regWord">APPLICATION MANAGEMENT</p>
            <div class="maroonDivider"></div>

            <!-- Review, edit, and delete applications -->
            <!-- TODO--> 
            <div class="applicationTables">
                <h2>Review, Edit, and Delete Applications</h2>
                <br>
                <?php
                    displayApplicationsTable();
                ?>
            </div>
            
            <br> 
            <br>

            <!-- Insert new application -->
            <div class="insertApplication">
                <h2>New Application</h2>
                <br>
                <form method="POST">
                    <label>Program:</label>
                    <select name="Program">
                        <?php 
                            $sql = "SELECT * FROM programs WHERE Status='Active'"; 
                            $active_programs = mysqli_query($db_conn, $sql);

                            while ($program = mysqli_fetch_array($active_programs, MYSQLI_ASSOC)):; 
                        ?>
                            <option value="<?php echo $program["Program_Num"];?>">
                                <?php echo $program["Name"];?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <br>

                    <label>Uncompleted Certifications:</label>
                    <input type="text" name="Uncom_Cert" id="Uncom_Cert">
                    <br>

                    <label>Completed Certifications:</label>
                    <input type="text" name="Com_Cert" id="Com_Cert">
                    <br>

                    <label>Purpose Statement:</label>
                    <input type="text" name="Purpose_Statement" id="Purpose_Statement">
                    <br><br>

                    <input type="submit" name="insertApplication" value="Submit Application">
                </form>
                <br>
                <?php
                    if(array_key_exists('insertApplication', $_POST)) {
                        insertApplication();
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>