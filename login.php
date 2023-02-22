<?php
    session_start();
    
    // include('db/dbConnection.php');
    include('header.php');
    include('accountClass.php');
    include('md5salt.php');

    $accountObject = new accountHandler($connection);

    // guest account login, guest account exists in db
    if(isset($_GET['guestLogin'])) {
        $_SESSION['username'] = 'guest';
        header('location: index.php');
    }

    if(isset($_POST['buttonSubmit'])) {
        $accountAuthenticate = $accountObject->authenticateAccount($_POST['username'], md5($salt . ($_POST['password'])));

        if($accountAuthenticate == true) {
            // set session values then redirect
            $loginData = $accountObject->loginToAccount($_POST['username'], md5($salt . ($_POST['password'])));

            $_SESSION['username'] = $loginData['accountname'];
            header('location: index.php');

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
</head>
<body>
    <div class="centeredColumn">
        <h1>Login</h1>
        <form class="addPostForm" method="POST">
            <div class="inputForm">
                <label for="username">Username</label>
                <input type="text" name="username" maxlength="25" required>
                <br>
            </div>
            <div class="inputForm">
                <label for="password">Password</label>
                <input type="password" name="password" maxlength="100" required>
            </div>
            <button type="submit" name="buttonSubmit" style="margin-top: 10px; margin-bottom: 10px;">LOGIN</button>
        </form>
        <?php
        if(isset($_POST['buttonSubmit'])) {
            if($accountAuthenticate == false) {
                echo '<div style="padding: 15px; border: 3px solid red; background-color: whitesmoke;"><b>Login failed! Please check credentials.</b></div>';
            }
        }
        ?>
        <div class="centeredColumn">
            <p>Don't have an account? Register <a href="register.php">HERE</a></p>
            <p style="margin: 0px;">OR</p>
            <p>Click <a href="login.php?guestLogin=true">HERE</a> to use a guest account</p>
        </div>
    </div>
</body>
</html>
