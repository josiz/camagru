<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="/camagru/classes/view/constant/style.css">
    <title>Document</title>
    <style>
    .popup
    {
        display: block;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        position: fixed;
        top: 0;
        justify-content: center;
        align-items: center;
    }

    .popup-container
    {
        width: 40%;
        height: 60%;
        background-color: white;
        position: relative;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    </style>
</head>
<body>

<?php if ($result == true) : ?>

<div class="popup">
    <div class="popup-container">
        <img src="/camagru/images/other/main_logo.png" alt=""><br><br><br><br>
        <p>Email confirmed succesfully!</p><br>
        <p>Click the link below and login</p><br>
        <p> <a href="http://localhost:8080/camagru/index.php/blog/loginPage" style="font-size: 40px;"><button class="btn btn-success">here</button></a></p>
    </div>
</div>


<?php else : ?>

<h1>Something went wrong... Check the confirmation link</h1>

<?php endif; ?>

<?php include "classes/view/constant/footer.php";