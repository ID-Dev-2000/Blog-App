<?php
    session_start();

    if(isset($_POST['yesConfirm'])) {
        session_destroy();
        header('location: index.php');
    } elseif(isset($_POST['noConfirm'])) {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
    <link rel="icon" href="image/favicon-32x32.png"></link>
</head>
<body>
    <div class="centeredColumn">
        <h1>Confirm</h1>
        <p>Are you sure you want to log out?</p>
        <p style="margin-top: 0px;">Account name: <?php echo $_SESSION['username']; ?></p>
        <form class="logoutForm" method="POST">
            <div>
                <button type="submit" name="yesConfirm" style="margin-right: 10px; width: 50px; cursor: pointer;">Yes</button>
                <button type="submit" name="noConfirm" style="width: 50px; cursor: pointer;">No</button>
            </div>
        </form>
    </div>
</body>
</html>