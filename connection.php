<?php
    include "env.php";

    // CREATE CONNECTION 
    $db_conn = new mysqli($db_servername, 
    $db_username, $db_password); 

    // GET CONNECTION ERRORS 
    if ($db_conn->connect_error) { 
        die("Connection failed: " . $db_conn->connect_error); 
    }
?>