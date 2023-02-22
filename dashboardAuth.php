<?php
    session_start();

    // directs user to admin dashboard if admin, or user dashboard otherwise
    // page only visibly displayed if user not logged in
    // page uses default CSS fonts + style tags to stay as lightweight as possible in case user has low internet speeds
    if(isset($_SESSION['username'])) {
        if($_SESSION['username'] == 'admin') {
            header('location: dashboardAdmin.php');
        } else {
            header('location: dashboardUser.php');
        }
    }
?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Auth</title>
    <link rel="icon" href="image/favicon-32x32.png"></link>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .centeredColumn {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

    </style>
 </head>
 <body>
    <div class="centeredColumn">
        <h1>Account Required</h1>
        <p>You need to <b>login</b> to an account in order to <b>view your dashboard!</b></p>
            <div>
                <a href="login.php"><button style="margin-right: 10px; width: 100px; height: 50px; cursor: pointer;">Login</button></a>
                <a href="register.php"><button style="margin-right: 10px; width: 100px; height: 50px; cursor: pointer;">Register</button></a>
                <a href="index.php"><button style="margin-right: 10px; width: 100px; height: 50px; cursor: pointer;">Return Home</button></a>
            </div>
        </div>
 </body>
 </html>
