<?php
    // using built-in CSS fonts + style tags to keep this page as lightweight as possible
    // reason for this is, using a link to google fonts may cause the page to visibly load before redirecting on very slow connections if the user is logged in
    session_start();

    if(isset($_SESSION['username'])) {
        header('location: addPost.php');
    }

    // else if not logged in, reminds user that an account is required to add posts

?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Auth</title>
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
        <p>You need to <b>login</b> to an account in order to <b>add posts!</b></p>
            <div>
                <a href="login.php"><button style="margin-right: 10px; width: 100px; height: 50px; cursor: pointer;">Login</button></a>
                <a href="register.php"><button style="margin-right: 10px; width: 100px; height: 50px; cursor: pointer;">Register</button></a>
                <a href="index.php"><button style="margin-right: 10px; width: 100px; height: 50px; cursor: pointer;">Return Home</button></a>
            </div>
        </div>
 </body>
 </html>
