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
        <a href="../Student/StudentHome.php" title="Back">←</a>
    </div>

   <div class="greyBack"> 
            <div class="regBox">
                <p class="regWord">APPLICATION MANAGEMENT</p>
                <div class="maroonDivider"></div>
            </div>
        </div>
    </div>
</body>
</html>