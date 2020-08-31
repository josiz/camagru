<?php

include ('database.php');

if (!file_exists('../images'))
    mkdir('../images');
if (!file_exists('../images/users'))
    mkdir('../images/users');
if (!file_exists('../images/uploads'))
    mkdir('../images/uploads');
if (!file_exists('../images/uploadsTemp'))
    mkdir('../images/uploadsTemp');
try
{
    $pdo = new PDO("mysql:host=db-mysql-fra1-27688-do-user-7954996-0.a.db.ondigitalocean.com:25060", $DB_USER, $DB_PASSWORD);
    $pdo->query("CREATE DATABASE IF NOT EXISTS camagru");
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e)
{
    echo $e->getMessage();
}

try
{
    $pdo->query("CREATE TABLE IF NOT EXISTS users (
        id int(11) not null PRIMARY KEY AUTO_INCREMENT,
        userName varchar(200),
        userPass varchar(255),
        userFirstName varchar(100),
        userLastName varchar(100),
        userEmail varchar(200),
        userAdmin boolean DEFAULT false,
        userRegisterTime datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        userProfileImage varchar(250),
        userConfirmed int(11) DEFAULT 0,
        userConfirmationCode varchar(255),
        userGetNotif boolean DEFAULT true)
        ");

    $stmt = $pdo->query("SELECT * FROM users");
    $rowCount = $stmt->rowCount();

    if ($rowCount == 0)
    {
        $adminPass = hash('sha256', "admin");
        $pdo->query("INSERT INTO users (`userName`, `userPass`, `userAdmin`, `userConfirmed`) VALUES ('admin', '". $adminPass ."', 1, 1)");
    }

    $pdo->query("CREATE TABLE IF NOT EXISTS post (
        post_id int(11) AUTO_INCREMENT PRIMARY KEY,
        user_id int(11),
        `picture` varchar(255),
        picture_header varchar(255),
        likes int(11) DEFAULT 0,
        removed boolean DEFAULT false,
        date_time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE 
        )");
// ON DELETE CASCADE LISATTY, JOTTA VOIDAAN POISTAA CHILD RIVIT, JOS PARENT ID POISTETAANs
    $pdo->query("CREATE TABLE IF NOT EXISTS comment (
        comment_id int(11) AUTO_INCREMENT PRIMARY KEY,
        post_id int(11),
        user_id int(11),
        date_time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        comment TEXT,
        FOREIGN KEY (post_id) REFERENCES post(post_id)
        ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        );");

    $pdo->query("CREATE TABLE IF NOT EXISTS likes (
        like_id int(11) AUTO_INCREMENT PRIMARY KEY,
        post_id int(11),
        user_id int(11),
        FOREIGN KEY (post_id) REFERENCES post(post_id)
        ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        );");


} catch(PDOException $e)
{
    echo $e->getMessage();
}