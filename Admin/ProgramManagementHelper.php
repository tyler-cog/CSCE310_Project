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

    
    if(array_key_exists('updateProgram', $_POST)) {
        updateProgram();
    }
    else if(array_key_exists('deleteProgram', $_POST)) {
        deleteProgram();
    }

?>