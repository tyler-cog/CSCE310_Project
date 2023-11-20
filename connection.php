<?php
    include "env.php"; // includes everything from env.php

    // CREATE CONNECTION 
    $db_conn = new mysqli($db_servername, 
    $db_username, $db_password, $db_database); 

    // GET CONNECTION ERRORS 
    if ($db_conn->connect_error) { 
        die("Connection failed: " . $db_conn->connect_error); 
    }

    /*
    HOW TO IMPORT THE DATABASE LOCALLY
    1. Login to databases.000webhost.com
    2. Click on the database
    3. On the top, click on export (Export Method: Quick, Format: SQL)
    4. Click on the Export button on the lower part of the page
    5. It will then download a .sql file.
    6. Open up XAMPP and turn on your MySQL by pressing "Start" (not sure if Apache needs to be turn on)
    7. Click on "Admin"
    8. On your local phpMyAdmin, create a new database named "id21516113_cybersecurityclub_db"
    9. Click on the newly made database and on the top bar, click on Import
    10. Select the downloaded sql file and press Go below
    */
?>