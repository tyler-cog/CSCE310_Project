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
   <div class="surface">
        <div class="maroonBar">
            <a href="../LoginPageFiles/LoginPage.php" title="Logout">↩</a>
            <a href="" title="Settings">⚙️</a>
        </div>
   </div>
</body>
</html>