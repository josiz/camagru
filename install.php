<?php

$servername ="db-mysql-fra1-27688-do-user-7954996-0.a.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "1";

$conn = mysqli_connect($servername, $username, $password);
if (!$conn)
    die("Connection failed: ".mysqli_connect_error());

$sql = "CREATE DATABASE IF NOT EXISTS camagru";

mysqli_query($conn, $sql);
mysqli_close($conn);

$dbname = "camagru";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn)
    die("Connection failed: ".mysqli_connect_error());

$sql = "CREATE TABLE IF NOT EXISTS users (
            user_id int(11) AUTO_INCREMENT PRIMARY KEY,
            uname varchar(50),
            password varchar(255),
            email varchar(100)
            );";
mysqli_query($conn, $sql);

$sql = "CREATE TABLE IF NOT EXISTS post (
            post_id int(11) AUTO_INCREMENT PRIMARY KEY,
            user_id int(11),
            `picture` varchar(255),
            date_time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(user_id)
            );";
mysqli_query($conn, $sql);

$sql = "CREATE TABLE IF NOT EXISTS comment (
            comment_id int(11) AUTO_INCREMENT PRIMARY KEY,
            post_id int(11),
            user_id int(11),
            date_time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            comment TEXT,
            FOREIGN KEY (post_id) REFERENCES post(post_id),
            FOREIGN KEY (user_id) REFERENCES users(user_id)
            );";
mysqli_query($conn, $sql);

$sql = "SELECT * FROM users WHERE uname='admin';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == FALSE)
{
    $pass = hash('whirlpool', "admin");
    $sql = "INSERT INTO users (`uname`,`password`) VALUES
            ('admin', '$pass');";
    mysqli_query($conn, $sql);
}

mysqli_close($conn);

