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
    function INSERT_Event($event_id, $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type){
        include "../connection.php";
        // $sql_query = "SELECT * FROM 'programs' WHERE 'Program_Num' = '$program_num'";
        // $result = $db_conn->query($sql_query);

        $sql_query = "INSERT INTO event 
        (Event_ID, UIN, Program_Num, Start_Date, Time, Location, End_Date, Event_Type) 
        VALUES 
        ('$event_id', '$uin','$program_num', '$start_date','$event_time', '$location', '$end_date', '$event_type')";

        $result = $db_conn->query($sql_query);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }
    }

    function UPDATE_Event($event_id, $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type) {
        include "../connection.php"; // Adjust the path as necessary
    
        // SQL query to update the event
        $sql_query = "UPDATE event SET 
                        UIN = ?, 
                        Program_Num = ?, 
                        Start_Date = ?, 
                        Time = ?, 
                        Location = ?, 
                        End_Date = ?, 
                        Event_Type = ? 
                      WHERE Event_ID = ?";
                      
        // echo "Executing query: $sql_query <br>";
        // echo "With parameters: $event_id, $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type <br>";

        // Prepare the statement
        $stmt = $db_conn->prepare($sql_query);
    
        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }
    
        // Bind the parameters to the placeholders
        // echo "Binding values: $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type, $event_id <br>";
        $stmt->bind_param("sissssss", $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type, $event_id,);
    
        // Execute the statement
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
    
        // Close the statement
        $stmt->close();
    }

    function GET_All_Events() {
        include "../connection.php"; // Adjust the path as necessary
    
        $sql_query = "SELECT * FROM event"; // Modify if you have a different table name or structure
    
        $result = $db_conn->query($sql_query);
    
        if ($result) {
            return $result; // Return the result object
        } else {
            die("Error fetching events: " . $db_conn->error);
        }
    }

    function displayEventsTable() {
        include "../connection.php"; // Adjust the path as necessary
        $events = GET_All_Events();
    
        $html = '<div>
                    <h2>Current Events</h2>
                    <table border="1">';
    
        $html .= '<thead>
                    <tr>
                        <th>Event ID</th>
                        <th>UIN</th>
                        <th>Program Number</th>
                        <th>Start Date</th>
                        <th>Event Time</th>
                        <th>Location</th>
                        <th>End Date</th>
                        <th>Event Type</th>
                    </tr>
                </thead>
                <tbody>';
    
        if ($events && $events->num_rows > 0) {
            while ($row = $events->fetch_assoc()) {
                $html .= "<tr>
                            <td>" . $row['Event_ID'] . "</td>
                            <td>" . $row['UIN'] . "</td>
                            <td>" . $row['Program_Num'] . "</td>
                            <td>" . $row['Start_Date'] . "</td>
                            <td>" . $row['Time'] . "</td>
                            <td>" . $row['Location'] . "</td>
                            <td>" . $row['End_Date'] . "</td>
                            <td>" . $row['Event_Type'] . "</td>
                          </tr>";
            }
        } else {
            $html .= "<tr><td colspan='8'>No current events found.</td></tr>";
        }
    
        // $html .= '</tbody></table></div>';
    
        return $html;
    }
    
?>