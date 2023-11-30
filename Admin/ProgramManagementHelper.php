<!-- Code written by Sydney Beeler -->

<?php
    include "../connection.php";

    function selectActivePrograms(){
        include "../connection.php";
        
        $sql_query = "SELECT Name, Description, Status FROM programs WHERE Status='Active'"; 
    
        $result = $db_conn->query($sql_query);
    
        if ($result) {
            return $result; 
        } else {
            die("Error fetching programs: " . $db_conn->error);
        }
    }

    function selectAllPrograms(){
        include "../connection.php";

        $sql_query = "SELECT Name, Description, Status FROM programs"; 
    
        $result = $db_conn->query($sql_query);
    
        if ($result) {
            return $result; 
        } else {
            die("Error fetching programs: " . $db_conn->error);
        }
    }

    function displayProgramsTable($active) {
        if ($active) {
            $programs = selectActivePrograms();
        }
        else {
            $programs = selectAllPrograms();
        }
        
        $html = '<div>
                    <table border="1">';
    
        $html .= '<thead>
                    <tr>
                        <th>Program Name</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';
    
        if ($programs && $programs->num_rows > 0) {
            while ($row = $programs->fetch_assoc()) {
                $html .= "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Description'] . "</td>
                            <td>" . $row['Status'] . "</td>
                          </tr>";
            }
        } else {
            $html .= "<tr><td colspan='8'>No active programs found.</td></tr>";
        }

        return $html;
    }

?>