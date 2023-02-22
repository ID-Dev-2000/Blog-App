<?php
    $sessionStatus = session_status();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css"></link>
    <link rel="icon" href="image/favicon-32x32.png"></link>
</head>
<body>
    <div class="mainHeader">
        <div class="headerContent">
            <a href="index.php" class="headerLinks">Home</a>
            <a href="addPostAuth.php" class="headerLinks">Add Post</a>
            <a href="dashboardAuth.php" class="headerLinks">Dashboard</a>
            <?php
            if($sessionStatus == PHP_SESSION_NONE || $sessionStatus == PHP_SESSION_DISABLED || $_SESSION == false) {
                echo '<a href="login.php" class="headerLinks">Login</a>';
            } elseif ($sessionStatus == PHP_SESSION_ACTIVE) {
                echo '<a href="logout.php" class="headerLinks">Logout</a>';
            }
            ?>
        </div>
    </div>
</body>
</html>
