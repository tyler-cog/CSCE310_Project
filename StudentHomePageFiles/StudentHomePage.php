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
    <link rel="stylesheet" href="StudentHomePage.css?v=<?php echo time(); ?>" >
</head>
<body>
    <div class="maroonBar">
        <a href="../LoginPageFiles/LoginPage.php" title="Logout" color=#C8C8C8>↩</a>
        <a href="" title="Settings" color=#C8C8C8>⚙️</a>
    </div>

   <div class="greyBack"> 
        <div class="regBox">
            <p class="regWord">STUDENT HOME</p>
            <div class="maroonDivider"></div>

            <a href="../StudentApplicationPageFiles/StudentApplicationPage.php" color=black>Application Management</a>
        </div>
    </div>
</body>
</html>