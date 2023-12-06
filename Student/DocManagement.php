// Code Written By: Tyler Roosth


<?php
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
                    
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Application Number</label>
                        <!-- <?php 
                            require_once "DocHelper.php";
                            get_Apps();
                            
                        ?> -->
                        <input class="textField" type="number" name="app_num" value="<?php echo htmlspecialchars($app_num); ?>" >
                    </div> 
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
                    <div class="thirdInputBox">
                        <div class="noError"></div>
                        <label>Doc Number (blank unless updating / deleting) </label>
                        <input class="textField" type="number" name="doc_num" value="<?php echo htmlspecialchars($doc_num); ?>" >
                    </div>
                    <div class="greyDivider"></div>
                    
                    <input class="submitBtn" type="submit" name="create_doc" value="Create"> 
                    <input class="submitBtn" type="submit" name="update_doc"value="Update">
                    <input class="submitBtn" type="submit" name="search_doc" value="Search"> 
                    <input class="submitBtn" type="submit" name="delete_doc" value="Delete"> 
                
                </form>
                <?php
                    require_once "DocHelper.php";
                    // get_UIN();
                    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $doc_num = $_POST['doc_num'];
                        $app_num = $_POST['app_num'];
                        $doc_link = $_POST['doc_link'];
                        $doc_type = $_POST['doc_type'];
                    
                        
                        if (isset($_POST['create_doc'])){
                            if (validAppNum($_POST['app_num'])){
                                INSERT_Doc($doc_num, $app_num, $doc_link, $doc_type);
                            }
                            else{
                                echo '<div class="withError">
                                        <div class="errorMessage">Current Application Number not valid </div>
                                    </div>';
                            }
                            echo displayDocsTable();
                        }
                        else if (isset($_POST['update_doc'])){
                            if (validDocID($_POST['doc_num'])){
                                UPDATE_Doc($doc_num, $app_num, $doc_link, $doc_type);
                            }
                            else{
                                echo '<div class="withError">
                                        <div class="errorMessage">Current Document Number is invalid</div>
                                    </div>';
                            }
                            echo displayDocsTable();
                        }
                        else if (isset($_POST['search_doc'])){
                            echo displayDocsTable();
                        }
                        else if (isset($_POST['delete_doc'])){
                            if (validDocID($_POST['doc_num'])){
                                Delete_Doc($doc_num, $app_num, $doc_link, $doc_type);
                            }
                            else{
                                echo '<div class="withError">
                                        <div class="errorMessage">Current Document Number is invalid</div>
                                    </div>';
                            }
                            echo displayDocsTable();
                        }
                    }
                ?>

            </div>
        </div>
    </div>
</body>
</html>
