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
        <a class="logout" href="../LoginPage/LoginPage.php" title="Logout" color=#C8C8C8>↩Logout</a>
    </div>

   <div class="greyBack"> 
        <div class="regBox">
            <p class="regWord">STUDENT HOME</p>
            <div class="maroonDivider"></div>

            <a href="../Student/ApplicationManagement.php" color=black>Application Management</a>
            <a href="../Student/DocManagement.php" color=black>Document Management</a>
            <a href="../Student/Profile.php" color=black>User Profile Page</a>
        </div>
    </div>
</body>
</html>
