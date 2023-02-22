<?php
    $hostName = 'localhost';
    $userName = 'root';
    $passWord = '';
    $dbName = 'blogcrudapp';

    $connection = mysqli_connect($hostName, $userName, $passWord, $dbName);
    if (!$connection) {
        echo "Error: " . mysqli_connect_error();
    }

?>
