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

    function validDocID($doc_num) {
        include "../connection.php";

        // Prepare the SQL query using placeholders
        $sql_query = "SELECT * FROM `document` WHERE `Doc_Num` = ?";
        $stmt = $db_conn->prepare($sql_query);

        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }

        // Bind the parameter
        $stmt->bind_param("i", $doc_num); // Assuming Event_ID is an integer

        // Execute the query
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }

        // Get the result
        $result = $stmt->get_result();

        // Check if there are any rows
        return $result->num_rows > 0;
    }

    function validAppNum($app_num) {
        include "../connection.php";
    
        // Get the UIN of the current user using the get_UIN() function
        $currentUserUIN = get_UIN();  // Assuming get_UIN() is defined in the scope
    
        // Prepare the SQL query using placeholders
        $sql_query = "SELECT * FROM `application` WHERE `App_Num` = ? AND `UIN` = ?";
        $stmt = $db_conn->prepare($sql_query);
    
        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }
    
        // Bind the parameters
        $stmt->bind_param("is", $app_num, $currentUserUIN);
    
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

        // echo "app_num: " . htmlspecialchars($app_num) . "<br>";

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

    function DELETE_Doc($doc_num) {
        include "../connection.php"; // Adjust the path as necessary

        // SQL query to delete the document
        $sql_query = "DELETE FROM document WHERE Doc_Num = ?";
        
        // Prepare the statement
        $stmt = $db_conn->prepare($sql_query);

        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }

        // Bind the parameter to the placeholder
        $stmt->bind_param("s", $doc_num);

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
    function get_Documents() {
        include "../connection.php";
        // session_start();
    
        // Get the UIN of the current user using the get_UIN() function
        $currentUserUIN = get_UIN();  // Assuming get_UIN() is defined in the scope
        // echo "Current User's UIN: " . htmlspecialchars($currentUserUIN) . "<br>";
        if ($currentUserUIN) {
            // Prepare the SQL statement to fetch documents associated with the user's UIN
            $sql = "SELECT * FROM document WHERE App_Num IN (SELECT App_Num FROM application WHERE UIN = ?)";
            $stmt = $db_conn->prepare($sql);
            $stmt->bind_param("s", $currentUserUIN);
            $stmt->execute();
            $result = $stmt->get_result();
            // Fetch and return the documents
            $documents = [];
            while ($row = $result->fetch_assoc()) {
                $documents[] = $row;
            }
            // Echo the results for debugging
            // echo "<pre>Documents: " . print_r($documents, true) . "</pre>";
            return $documents;
        } else {
            echo "No user found or no documents associated with the user.";
            return []; // Return an empty array if no user or no documents are found
        }
    }
    
    function displayDocsTable() {
        include "../connection.php"; // Adjust the path as necessary
        $docs = get_Documents();
    
        $html = '<div>
                    <h2>Current Documents</h2>
                    <table border="1">';
        
        $html .= '<thead>
                    <tr>
                        <th>Doc Number</th>
                        <th>App Number</th>
                        <th>Link</th>
                        <th>Doc Type</th>
                    </tr>
                  </thead>
                  <tbody>';
        
        if (!empty($docs)) {
            foreach ($docs as $row) {
                $html .= "<tr>
                            <td>" . htmlspecialchars($row['Doc_Num']) . "</td>
                            <td>" . htmlspecialchars($row['App_Num']) . "</td>
                            <td>" . htmlspecialchars($row['Link']) . "</td>
                            <td>" . htmlspecialchars($row['Doc_Type']) . "</td>
                          </tr>";
            }
        } else {
            $html .= "<tr><td colspan='4'>No current documents found.</td></tr>";
        }
    
        $html .= '</tbody></table></div>';
    
        return $html;
    }
    

    function get_UIN() {
        include "../connection.php";
        // session_start();
        $currentUserUsername = $_SESSION['username']; // Get the current user's username
        
        // Prepare the SQL statement to fetch UIN
        $sql = "SELECT UIN FROM user WHERE Username = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("s", $currentUserUsername);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($row = $result->fetch_assoc()) {
            return $row['UIN']; // Return the user's UIN
        } else {
            return null; // Return null if no user found
        }
    }

    function get_Apps() {
        include "../connection.php";
        session_start();
        $currentUserUsername = $_SESSION['username']; // Get the current user's username
        
        // Echo the current user's username for debugging
        // echo "Current User's Username: " . htmlspecialchars($currentUserUsername) . "<br>";
        
        // Prepare the SQL statement to fetch UIN
        $sql = "SELECT UIN FROM user WHERE Username = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("s", $currentUserUsername);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($row = $result->fetch_assoc()) {
            $currentUserUIN = $row['UIN'];
            // echo "User's UIN: " . htmlspecialchars($currentUserUIN) . "<br>";
    
            // Now use this UIN to get the applications from the application table
            $sql = "SELECT App_Num FROM application WHERE UIN = ?";
            $stmt = $db_conn->prepare($sql);
            $stmt->bind_param("s", $currentUserUIN);
            $stmt->execute();
            $appResult = $stmt->get_result();
    
            // Create a dropdown menu with the results
            echo '<select name="application_number">';
            while ($appRow = $appResult->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($appRow['App_Num']) . '">' . htmlspecialchars($appRow['App_Num']) . '</option>';
            }
            echo '</select>';
    
        } else {
            echo "No user found with that username.";
        }
    }
    

?>