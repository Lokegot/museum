<?php
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "Museum";

    $link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
    mysqli_query($link, "SET NAMES utf8");
?>