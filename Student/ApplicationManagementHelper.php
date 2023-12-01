<!-- Code written by Sydney Beeler -->

<?php
    function displayApplicationsTable() {
        include "../connection.php";

        session_start();
        $username = $_SESSION['username'];
        
        $UIN = $db_conn->query("SELECT UIN FROM user WHERE Username='$username'")->fetch_assoc()['UIN'];
        $applications = $db_conn->query("SELECT * FROM application WHERE UIN=$UIN"); 
    
        $html = '<div><table border="1">
                    <thead>
                    <tr>
                        <th>Program</th>
                        <th>Uncompleted Certifications</th>
                        <th>Completed Certifications</th>
                        <th>Purpose Statement</th>
                    </tr>
                    </thead>
                    <tbody>';
    
        if ($applications && $applications->num_rows > 0) {
            while ($row = $applications->fetch_assoc()) {
                $html .= "<tr>
                            <td>" . $row['Program_Num'] . "</td>
                            <td>" . $row['Uncom_Cert'] . "</td>
                            <td>" . $row['Com_Cert'] . "</td>
                            <td>" . $row['Purpose_Statement'] . "</td>
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

        session_start();
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

?>