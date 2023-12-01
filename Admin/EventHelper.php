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

    function INSERT_Event($event_id, $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type, $num_attend) {
        include "../connection.php";
    
        // SQL query to insert the event into the event table
        $sql_query_insert_event = "INSERT INTO event 
                                   (Event_ID, UIN, Program_Num, Start_Date, Time, Location, End_Date, Event_Type) 
                                   VALUES 
                                   ('$event_id', '$uin', '$program_num', '$start_date', '$event_time', '$location', '$end_date', '$event_type')";
    
        $result_insert_event = $db_conn->query($sql_query_insert_event);
    
        if (!$result_insert_event) {
            die("Error inserting event: " . $db_conn->error);
        }
    }

    function INSERT_tracking($uin, $num_attend) {
        include "../connection.php";
    
        // SQL query to search for the Event_ID associated with the given UIN
        $sql_query_search_event_id = "SELECT Event_ID FROM event WHERE UIN = '$uin'";
        $result_search_event_id = $db_conn->query($sql_query_search_event_id);
    
        if (!$result_search_event_id) {
            die("Error searching for Event_ID: " . $db_conn->error);
        }
    
        if ($result_search_event_id->num_rows > 0) {
            $row = $result_search_event_id->fetch_assoc();
            $event_id = $row['Event_ID'];
    
            // Now that you have the Event_ID, insert attendance information
            $sql_query_insert_attendance = "INSERT INTO event_tracking 
                (Event_ID, UIN, ET_Num) 
                VALUES 
                ('$event_id', '$uin', '$num_attend')";
    
            $result_insert_attendance = $db_conn->query($sql_query_insert_attendance);
    
            if (!$result_insert_attendance) {
                die("Error inserting attendance information: " . $db_conn->error);
            }
        } else {
            echo "No associated Event_ID found for UIN $uin";
        }
    }
    
    function DELETE_Event($event_id) {
        include "../connection.php";
    
        // Delete event tracking records associated with the event
        $sql_query_delete_tracking = "DELETE FROM event_tracking WHERE Event_ID = '$event_id'";
        $result_delete_tracking = $db_conn->query($sql_query_delete_tracking);
    
        if (!$result_delete_tracking) {
            die("Error deleting event tracking records: " . $db_conn->error);
        }
    
        // Now, delete the event
        $sql_query_delete_event = "DELETE FROM event WHERE Event_ID = '$event_id'";
        $result_delete_event = $db_conn->query($sql_query_delete_event);
    
        if (!$result_delete_event) {
            die("Error deleting event: " . $db_conn->error);
        }
    }
    
    function DELETE_tracking($uin, $event_id) {
        include "../connection.php";
        // delete attendence portion  
        $sql_query = "DELETE FROM event_tracking WHERE Event_ID = '$event_id' AND UIN = '$uin'";

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
        
        // Prepare the statement
        $stmt = $db_conn->prepare($sql_query);
    
        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }
    
        // Bind the parameters to the placeholders
        $stmt->bind_param("sissssss", $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type, $event_id);
    
        // Execute the statement
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
    
        // Close the statement
        $stmt->close();
    }
    
    function UPDATE_tracking($uin, $event_id, $num_attend) {
        include "../connection.php";
        // Update attendance portion
        $sql_query = "UPDATE event_tracking SET ET_Num = ? WHERE Event_ID = ? AND UIN = ?";

        // Prepare the statement
        $stmt = $db_conn->prepare($sql_query);
    
        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }
    
        // Bind the parameters to the placeholders
        $stmt->bind_param("iis", $num_attend, $event_id, $uin);
    
        // Execute the statement
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
    
        // Close the statement
        $stmt->close();
    }

    function GET_All_Events() {
        include "../connection.php"; // Adjust the path as necessary
    
        // Modify the query to retrieve events along with event tracking information
        $sql_query = "SELECT event.*, event_tracking.ET_Num
                      FROM event
                      LEFT JOIN event_tracking ON event.Event_ID = event_tracking.Event_ID";
    
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
                        <th>Attendees</th>
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
                            <td>" . $row['ET_Num'] . "</td>
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
    
        return $html;
    }
    
?>