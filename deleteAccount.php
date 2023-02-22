<?php
    session_start();
    include('accountClass.php');
    include('header.php');

    $username = $_SESSION['username'];

    if(isset($_POST['deleteDeny'])) {
        header('location: dashboardUser.php');
    } elseif(isset($_POST['deleteConfirm'])) {
    $accountClass = new accountHandler($connection);

    $accountClass->deleteAllPostsFromAccount($username);

    $accountClass->deleteAccount($username);

    session_destroy();

    header('location: index.php');
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Confirm</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
</head>
<body>
    <div class="centeredColumn">
        <h1>Delete Account - <?php echo $username ?></h1>
        <p>Are you sure you want to delete your account?</p>
        <form method="POST">
            <button type="submit" name="deleteConfirm" style="margin-right: 10px;">YES</button>
            <button type="submit" name="deleteDeny">NO</button>
        </form>
    </div>
</body>
</html>
