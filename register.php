<?php
    include('db/dbConnection.php');
    include('header.php');
    include('accountClass.php');
    include('md5salt.php');

    $accountObject = new accountHandler($connection);
    
    if(isset($_POST['buttonSubmit'])) {
        $username = $_POST['username'];
        $password = md5($salt . ($_POST['password']));

        if($accountObject->checkIfAccountExists($username)) {
            echo '<div class="centeredColumn"><p><b>WARNING:</b> Account already exists with username: ' . $username . '</p></div>';
        } else {
            $accountObject->createAccount($username, $password);

            header('location: login.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
</head>
<body>
    <div class="centeredColumn">
        <h1>Register</h1>
        <form class="addPostForm" method="POST">
            <div class="inputForm">
                <label for="username">Username</label>
                <input type="text" name="username" maxlength="25" required>
                <br>
            </div>
            <div class="inputForm">
                <label for="password">Password</label>
                <input type="password" name="password" maxlength="50" required>
            </div>
            <button type="submit" name="buttonSubmit" style="margin-top: 10px;">REGISTER</button>
        </form>
    </div>
</body>
</html>
