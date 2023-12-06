// Code Written By: Tyler Roosth

<?php
    function validUIN($uin){
        include "../connection.php";
    
        // Prepare the SQL query using placeholders
        $sql_query = "SELECT * FROM user WHERE UIN = ?";
        $stmt = $db_conn->prepare($sql_query);
    
        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }
    
        // Bind the parameter as a string
        $stmt->bind_param("i", $uin);
    
        // Execute the query
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
    
        // Get the result
        $result = $stmt->get_result();
    
        // Check if there are any rows (i.e., if the uin exists)
        return $result->num_rows > 0;
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

    function validProgramName($program_name) {
        include "../connection.php";
    
        // Prepare the SQL query using placeholders
        $sql_query = "SELECT * FROM programs WHERE Name = ?";
        $stmt = $db_conn->prepare($sql_query);
    
        if (!$stmt) {
            die("Error preparing statement: " . $db_conn->error);
        }
    
        // Bind the parameter as a string
        $stmt->bind_param("s", $program_name);
    
        // Execute the query
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
    
        // Get the result
        $result = $stmt->get_result();
    
        // Check if there are any rows (i.e., if the program name exists)
        return $result->num_rows > 0;
    }
    
    function INSERT_Event($event_id, $uin, $program_name, $start_date, $event_time, $location, $end_date, $event_type, $num_attend) {
        include "../connection.php";
        
        // SQL query to select the Program_Num
        $sql_num_query = "SELECT Program_Num FROM programs WHERE Name = '$program_name'";
        
        $result = $db_conn->query($sql_num_query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $program_num = $row['Program_Num'];
    
            // SQL query to insert the event into the event table
            $sql_query_insert_event = "INSERT INTO event 
                                       (Event_ID, UIN, Program_Num, Start_Date, Time, Location, End_Date, Event_Type) 
                                       VALUES 
                                       ('$event_id', '$uin', '$program_num', '$start_date', '$event_time', '$location', '$end_date', '$event_type')";
    
            $result_insert_event = $db_conn->query($sql_query_insert_event);
    
            if ($result_insert_event) {
                // Get the last inserted ID if Event_ID is auto-incremented
                $last_inserted_id = $db_conn->insert_id;
                INSERT_tracking($uin, $num_attend, $last_inserted_id);
            } else {
                die("Error inserting event: " . $db_conn->error);
            }
        } else {
            echo "No program found with the name: $program_name";
        }
    }
    
    function INSERT_tracking($uin, $num_attend, $event_id) {
        include "../connection.php";
        $sql_query_insert_update_attendance = "INSERT INTO event_tracking 
            (Event_ID, UIN, ET_Num) 
            VALUES 
            ('$event_id', '$uin', '$num_attend')
            ON DUPLICATE KEY UPDATE 
            UIN = VALUES(UIN), ET_Num = VALUES(ET_Num)";

        $result_insert_update_attendance = $db_conn->query($sql_query_insert_update_attendance);

        if (!$result_insert_update_attendance) {
            die("Error inserting or updating attendance information: " . $db_conn->error);
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

    function UPDATE_Event($event_id, $uin, $program_name, $start_date, $event_time, $location, $end_date, $event_type, $num_attend) {
        include "../connection.php"; // Adjust the path as necessary
        
        // SQL query to get the Program_Num
        $sql_num_query = "SELECT Program_Num FROM programs WHERE Name = '$program_name'";
        $result = $db_conn->query($sql_num_query);

        // Initialize $program_num
        $program_num = 0;

        // Check if the query was successful and if it returned a row
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $program_num = $row['Program_Num'];
        } else {
            die("Program not found: " . $db_conn->error);
        }

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
        UPDATE_tracking($uin, $event_id, $num_attend);

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

        $sql_view = "CREATE OR REPLACE VIEW all_events_view AS
        SELECT event.*, event_tracking.ET_Num, programs.Name AS Name
        FROM event
        LEFT JOIN event_tracking ON event.Event_ID = event_tracking.Event_ID
        LEFT JOIN programs ON event.Program_Num = programs.Program_Num";
        
        // $result = $db_conn->query($sql_view);
        if ($db_conn->query($sql_view) === TRUE) {
            // echo $result;
        } else {
            echo "Error creating view: " . $db_conn->error;
        }

        // Modify the query to retrieve events from the view
        $sql_query = "SELECT * FROM all_events_view";
    
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
                        <th>Program Name</th> <!-- Updated header -->
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
                            <td>" . htmlspecialchars($row['Event_ID']) . "</td>
                            <td>" . htmlspecialchars($row['UIN']) . "</td>
                            <td>" . htmlspecialchars($row['Name']) . "</td> <!-- Use the unique alias -->
                            <td>" . htmlspecialchars($row['ET_Num']) . "</td>
                            <td>" . htmlspecialchars($row['Start_Date']) . "</td>
                            <td>" . htmlspecialchars($row['Time']) . "</td>
                            <td>" . htmlspecialchars($row['Location']) . "</td>
                            <td>" . htmlspecialchars($row['End_Date']) . "</td>
                            <td>" . htmlspecialchars($row['Event_Type']) . "</td>
                          </tr>";
            }
        } else {
            $html .= "<tr><td colspan='9'>No current events found.</td></tr>";
        }
    
        $html .= '</tbody></table></div>';
    
        return $html;
    }
    
?>
