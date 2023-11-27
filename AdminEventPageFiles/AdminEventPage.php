<?php
    $uin = "";
    $event_id = "";
    $program_num = "";
    $start_date = "";
    $end_date = "";
    $location = "";
    $event_type = "";
    $event_time = "";
    $events = "";
    $num_rows = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="AdminEventPage.css?v=<?php echo time(); ?>" >
</head>
<body>
    <div class="surface">
        <div class="maroonBar">
            <img src="https://cybersecurity.tamu.edu/wp-content/uploads/2022/09/cropped-720x140_TEES_CyberCenter_white_horiz.png"/>
        </div>
        <div class="greyBack"> 
            <div class="regBox">
                <a href="../AdminHomePageFiles/AdminHomePage.php">< Back</a>
                <p class="regWord">EVENT PAGE </p>
                <div class="maroonDivider"></div>
                <form class="regForm" action="AdminEventPage.php" method="POST">
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Start Date</label>
                        <input class="textField" type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" >
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>End Date</label>
                        <input class="textField" type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" >
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Time</label>
                        <input class="textField" type="time" name="event_time" value="<?php echo htmlspecialchars($event_time); ?>" >
                    </div> 
                    <div class="thirdInputBox">
                        <?php
                            // require_once "adminEventHelper.php";
                            // if (isset($_POST['uin'])) {
                            //     if (!validUIN($_POST['uin'])){
                            //         echo '<div class="withError">
                            //                 <div class="errorMessage">UIN already taken or invalid</div>
                            //             </div>';
                            //     }
                            //     else {
                            //         echo '<div class="noError"></div>';
                            //     }
                            // }

                            // else {
                            //     echo '<div class="noError"></div>';
                            // }
                        ?>
                        <label>UIN</label>
                        <input class="textField" type="number" name="uin" step="1" value="<?php echo htmlspecialchars($uin); ?>" >
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Location</label>
                        <input class="textField" type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" >
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Event Type</label>
                        <input class="textField" type="text" name="event_type" value="<?php echo htmlspecialchars($event_type); ?>" >
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Program Number</label>
                        <input class="textField" type="text" name="program_num" value="<?php echo htmlspecialchars($program_num); ?>" >
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Event ID (blank unless updating) </label>
                        <input class="textField" type="number" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>" >
                    </div>
                    <div class="greyDivider"></div>

                    <!-- <div class="halfInputBox">
                        <?php
                            // require_once "adminEventHelper.php";
                            // if (isset($_POST['username'])) {
                            //     if (!validUsername($_POST['username'])){
                            //         echo '<div class="withError">
                            //                 <div class="errorMessage">Username already taken</div>
                            //             </div>';
                            //     }
                            //     else {
                            //         echo '<div class="noError"></div>';
                            //     }
                            // }

                            // else {
                            //     echo '<div class="noError"></div>';
                            // }
                        ?>
                        <label>Username</label>
                        <input class="textField" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" >
                    </div>
                    <div class="halfInputBox">
                        <div class="noError"></div>
                        <label>Password</label>
                        <input class="textField" type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" >
                    </div>-->
                    <input class="submitBtn" type="submit" name="create_event" value="Create"> 
                    <input class="submitBtn" type="submit" name="update_event"value="Update">
                    <input class="submitBtn" type="submit" name="search_event" value="Search"> 
                
                </form>
                <?php
                    require_once "adminEventHelper.php";
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $uin = $_POST['uin'];
                        $start_date = $_POST['start_date'];
                        $end_date = $_POST['end_date'];
                        $location = $_POST['location'];
                        $event_type = $_POST['event_type'];
                        $event_time = $_POST['event_time'];
                        $program_num = $_POST['program_num'];
                        $event_id = $_POST['event_id'];
                        //$uin = (validUIN($_POST['uin'])) ? $_POST['uin'] : "";
                        //$username = (validUsername($_POST['username'])) ? $_POST['username'] : "";
                        
                        if (isset($_POST['create_event'])){
                            INSERT_Event($event_id, $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type);
                            echo displayEventsTable();
                        }
                        else if (isset($_POST['update_event'])){
                            if (validEventID($_POST['event_id'])){
                                UPDATE_Event($event_id, $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type);
                            }
                            else{
                                echo '<div class="withError">
                                        <div class="errorMessage">Current Event ID is invalid</div>
                                    </div>';
                            }
                            echo displayEventsTable();
                        }
                        else if (isset($_POST['search_event'])){
                            echo displayEventsTable();
                        }

                        //header("Location: ../AdminHomePageFiles/AdminHomePage.php");
                        //exit();

                        // if (validUIN($_POST['uin']) && validUsername($_POST['username'])){

                        //     INSERT_User($uin, $first_name, $m_initial, $last_name, $username, $password, "Admin", $email, $discord_name);

                        //     header("Location: ../LoginPageFiles/LoginPage.php");
                        //     exit();
                        // }
                    }
                ?>

            </div>
        </div>
    </div>
</body>
</html>