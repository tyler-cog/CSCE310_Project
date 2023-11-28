<?php
    session_start();
    $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Style/Home.css?v=<?php echo time(); ?>" >
</head>
<body>
    <div class="maroonBar">
        <a href="../LoginPage/LoginPage.php" title="Logout" color=#C8C8C8>↩</a>
        <a href="" title="Settings" color=#C8C8C8>⚙️</a>
    </div>

   <div class="greyBack"> 
        <div class="regBox">
            <p class="regWord">ADMIN HOME</p>
            <div class="maroonDivider"></div>

            <a href="../Admin/ProgramProgress.php" color=black>Program Progress Tracking</a>
            <a href="../Admin/ProgramManagement.php" color=black>Program Information Management</a>
            <a href="../Admin/Event.php" color=black>Event Management</a>
        </div>
    </div>
</body>
</html>
