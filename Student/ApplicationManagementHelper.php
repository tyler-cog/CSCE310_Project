<!-- Code written by Sydney Beeler -->

<?php
    function updateApplication() {
        include "../connection.php";
        
        $ID = $_REQUEST['ID'];
        $Uncom_Cert = $_REQUEST['Uncom_Cert'];
        $Com_Cert = $_REQUEST['Com_Cert'];
        $Purpose_Statement = $_REQUEST['Purpose_Statement'];
        
        $sql_query = "UPDATE application SET Uncom_Cert='$Uncom_Cert', Com_Cert='$Com_Cert', Purpose_Statement='$Purpose_Statement' WHERE App_Num=$ID";
        $result = $db_conn->query($sql_query);
    }


    function deleteApplication() {
        include "../connection.php";
        
        $ID = $_REQUEST['ID'];
        $delete = $db_conn->query("DELETE FROM application WHERE App_Num=$ID");
    }


    function displayApplicationsTable() {
        include "../connection.php";

        session_start();
        $username = $_SESSION['username'];
        
        $UIN = $db_conn->query("SELECT UIN FROM user WHERE Username='$username'")->fetch_assoc()['UIN'];
        $sql_query = "SELECT programs.Name, programs.Program_Num, application.App_Num, application.Uncom_Cert, application.Com_Cert, application.Purpose_Statement 
                      FROM application JOIN programs 
                      ON application.Program_Num=programs.Program_Num AND application.UIN=$UIN";
        $applications = $db_conn->query($sql_query); 
    
        $html = '<div><table border="1">
                    <thead>
                    <tr>
                        <th>Program</th>
                        <th>Uncompleted Certifications</th>
                        <th>Completed Certifications</th>
                        <th>Purpose Statement</th>
                        <th>Application Status</th>
                    </tr>
                    </thead>
                    <tbody>';
    
        if ($applications && $applications->num_rows > 0) {
            while ($row = $applications->fetch_assoc()) {
                $ID = $row['Program_Num'];
                $result = $db_conn->query("SELECT * FROM track WHERE track.Program_Num=$ID AND track.UIN=$UIN");
                $status = "Submitted";
                if ($result->num_rows > 0) {
                    $status = "Accepted";
                }

                $html .= "<tr>
                            <form method='POST'>
                                <td>" . $row['Name'] . "</td>
                                <td><input type='text' style='width:300px' name='Uncom_Cert' value='" . $row['Uncom_Cert'] . "'</td>
                                <td><input type='text' style='width:300px' name='Com_Cert' value='" . $row['Com_Cert'] . "'</td>
                                <td><input type='text' style='width:200px' name='Purpose_Statement' value='" . $row['Purpose_Statement'] . "'</td>
                                <td>" . $status . "</td>
                                <td><input type='hidden' name='ID' value='" . $row['App_Num'] . "'</td>

                                <td><input type='submit' name='updateApplication' value='Update'></td>
                                <td><input type='submit' name='deleteApplication' value='Delete'></td>
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
    function insertApplication() {
        include "../connection.php";

        $username = $_SESSION['username'];
        $UIN = $db_conn->query("SELECT UIN FROM user WHERE Username='$username'")->fetch_assoc()['UIN'];

        $Program = $_POST['Program'];
        $Uncom_Cert = $_POST['Uncom_Cert'];
        $Com_Cert = $_POST['Com_Cert'];
        $Purpose_Statement = $_POST['Purpose_Statement'];

        $sql_query = "INSERT INTO application (UIN, Program_Num, Uncom_Cert, Com_Cert, Purpose_Statement) VALUES ($UIN, $Program, '$Uncom_Cert', '$Com_Cert', '$Purpose_Statement')";
        $result = $db_conn->query($sql_query);

        if ($result) {
            echo "Application submitted successfully.";
        } else {
            echo "Error submitting application: " . $db_conn->error;
        }
    }


    //////////////////////////////////////////////////////////////////////////////
    if(array_key_exists('updateApplication', $_POST)) {
        updateApplication();
    }
    else if(array_key_exists('deleteApplication', $_POST)) {
        deleteApplication();
    }
?>