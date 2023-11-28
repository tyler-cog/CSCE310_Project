<?php
    function validUIN($uin){
        include "../connection.php";
        if ($uin == ""){
            return true;
        }

        $uin = (int)$uin;

        if (($uin <= 0) || ($uin > 99999999999)){
            return false;
        }

        $sql_query = "SELECT * FROM `user` WHERE `UIN` = '$uin'";
        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        
        // If there's a result
        if ($result->num_rows > 0){
            return false;
        }

        else {
            return true;
        }
    }

    function validEventID($event_id) {
        include "../connection.php";

        // Prepare the SQL query using placeholders
        $sql_query = "SELECT * FROM `event` WHERE `Event_ID` = ?";
        $stmt = $db_conn->prepare($sql_query);

        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }

        // Bind the parameter
        $stmt->bind_param("i", $event_id); // Assuming Event_ID is an integer

        // Execute the query
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }

        // Get the result
        $result = $stmt->get_result();

        // Check if there are any rows
        return $result->num_rows > 0;
    }
    function INSERT_Doc($doc_num, $app_num, $doc_link, $doc_type){
        include "../connection.php";
        // $sql_query = "SELECT * FROM 'programs' WHERE 'Program_Num' = '$program_num'";
        // $result = $db_conn->query($sql_query);

        $sql_query = "INSERT INTO document
        (Doc_Num, App_Num, Link, Doc_Type) 
        VALUES 
        ('$doc_num', '$app_num', '$doc_link', '$doc_type')";

        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
    }

    function UPDATE_Doc($doc_num, $app_num, $doc_link, $doc_type) {
        include "../connection.php"; // Adjust the path as necessary
    
        // SQL query to update the document
        $sql_query = "UPDATE document SET 
                        App_Num = ?, 
                        Link = ?, 
                        Doc_Type = ?
                      WHERE Doc_Num = ?";
        
        // Prepare the statement
        $stmt = $db_conn->prepare($sql_query);
    
        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }
    
        // Bind the parameters to the placeholders
        $stmt->bind_param("ssss", $app_num, $doc_link, $doc_type, $doc_num);
    
        // Execute the statement
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
    
        // Close the statement
        $stmt->close();
    }    

    function GET_All_Docs() {
        include "../connection.php"; // Adjust the path as necessary
    
        $sql_query = "SELECT * FROM document"; // Modify if you have a different table name or structure
    
        $result = $db_conn->query($sql_query);
    
        if ($result) {
            return $result; // Return the result object
        } else {
            die("Error fetching documents: " . $db_conn->error);
        }
    }

    function displayDocsTable() {
        include "../connection.php"; // Adjust the path as necessary
        $docs = GET_All_Docs();
    
        $html = '<div>
                    <h2>Current Documents</h2>
                    <table border="1">';
    
        $html .= '<thead>
                    <tr>
                        <th>Doc Number</th>
                        <th>App Number</th>
                        <th>Link</th>
                        <th>Doc Type </th>
                    </tr>
                </thead>
                <tbody>';
    
        if ($docs && $docs->num_rows > 0) {
            while ($row = $docs->fetch_assoc()) {
                $html .= "<tr>
                            <td>" . $row['Doc_Num'] . "</td>
                            <td>" . $row['App_Num'] . "</td>
                            <td>" . $row['Link'] . "</td>
                            <td>" . $row['Doc_Type'] . "</td>
                          </tr>";
            }
        } else {
            $html .= "<tr><td colspan='8'>No current documents found.</td></tr>";
        }
    
        // $html .= '</tbody></table></div>';
    
        return $html;
    }
    
?>