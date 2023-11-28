<?php
    // $uin = "";
    // $event_id = "";
    // $program_num = "";
    // $start_date = "";
    // $end_date = "";
    // $location = "";
    // $event_type = "";
    // $event_time = "";
    // $events = "";
    // $num_rows = "";

    $doc_num = "";
    $app_num = "";
    $doc_link = "";
    $doc_type = "";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Style/SidePages.css?v=<?php echo time(); ?>" >
</head>
<body>
    <div class="surface">
        <div class="maroonBar">
            <img src="https://cybersecurity.tamu.edu/wp-content/uploads/2022/09/cropped-720x140_TEES_CyberCenter_white_horiz.png"/>
        </div>
        <div class="greyBack"> 
            <div class="regBox">
                <a href="../Student/StudentHome.php">< Back</a>
                <p class="regWord">DOCUMENT MANAGEMENT</p>
                <div class="maroonDivider"></div>
                <form class="regForm" action="DocManagement.php" method="POST">
                    <!-- <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Start Date</label>
                        <input class="textField" type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" >
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>End Date</label>
                        <input class="textField" type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" >
                    </div> -->
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Application Number</label>
                        <input class="textField" type="number" name="app_num" value="<?php echo htmlspecialchars($app_num); ?>" >
                    </div> 
                    <!-- <div class="thirdInputBox">
                        <?php
                            // require_once "DocHelper.php";
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
                    </div> -->
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Document Link</label>
                        <input class="textField" type="text" name="doc_link" value="<?php echo htmlspecialchars($doc_link); ?>" >
                    </div>
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Document Type</label>
                        <input class="textField" type="text" name="doc_type" value="<?php echo htmlspecialchars($doc_type); ?>" >
                    </div>
                    <!-- <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Program Number</label>
                        <input class="textField" type="text" name="program_num" value="<?php echo htmlspecialchars($program_num); ?>" >
                    </div> -->
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Doc Number (blank unless updating) </label>
                        <input class="textField" type="number" name="doc_num" value="<?php echo htmlspecialchars($doc_num); ?>" >
                    </div>
                    <div class="greyDivider"></div>

                    <!-- <div class="halfInputBox">
                        <?php
                            // require_once "DocHelper.php";
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
                    <input class="submitBtn" type="submit" name="create_doc" value="Create"> 
                    <input class="submitBtn" type="submit" name="update_doc"value="Update">
                    <input class="submitBtn" type="submit" name="search_doc" value="Search"> 
                
                </form>
                <?php
                    require_once "DocHelper.php";
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                        // $uin = $_POST['uin'];
                        // $start_date = $_POST['start_date'];
                        // $end_date = $_POST['end_date'];
                        // $location = $_POST['location'];
                        // $event_type = $_POST['event_type'];
                        // $event_time = $_POST['event_time'];
                        // $program_num = $_POST['program_num'];
                        // $event_id = $_POST['event_id'];
                        
                        $doc_num = $_POST['doc_num'];
                        $app_num = $_POST['app_num'];
                        $doc_link = $_POST['doc_link'];
                        $doc_type = $_POST['doc_type'];
                    
                        
                        if (isset($_POST['create_doc'])){
                            INSERT_Doc($doc_num, $app_num, $doc_link, $doc_type);
                            echo displayDocsTable();
                        }
                        else if (isset($_POST['update_doc'])){
                            UPDATE_Doc($doc_num, $app_num, $doc_link, $doc_type);
                            // if (validEventID($_POST['event_id'])){
                            //     update_doc($event_id, $uin, $program_num, $start_date, $event_time, $location, $end_date, $event_type);
                            // }
                            // else{
                            //     echo '<div class="withError">
                            //             <div class="errorMessage">Current Event ID is invalid</div>
                            //         </div>';
                            // }
                            echo displayDocsTable();
                        }
                        else if (isset($_POST['search_doc'])){
                            echo displayDocsTable();
                        }

                        //header("Location: ../Admin/AdminHome.php");
                        //exit();

                        // if (validUIN($_POST['uin']) && validUsername($_POST['username'])){

                        //     INSERT_User($uin, $first_name, $m_initial, $last_name, $username, $password, "Admin", $email, $discord_name);

                        //     header("Location: ../LoginPage/LoginPage.php");
                        //     exit();
                        // }
                    }
                ?>

            </div>
        </div>
    </div>
</body>
</html>