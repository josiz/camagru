<?php

class View
{
    private $userData;
    public function __construct($user = null)
    {
        $this->userData = $user;
    }

    public function indexView($data)
    {
        include 'pages/main.php';
        
    }

    public function aboutView()
    {
        include 'pages/about.php';
    }

    public function signUp($error = "")
    {
        include 'pages/signup.php';
    }

    public function login($error = "")
    {
        include 'pages/login.php';
    }

    public function userPage($data)
    {
        include 'pages/user/userHome.php';
    }

    public function userInfo($data)
    {
        include 'pages/user/userInfo.php';
    }

    public function notLogged()
    {
        include 'pages/notLogged.php';
    }

    public function adminUsers($data)
    {
        include 'pages/user/adminUsers.php';
    }

    public function gallery($data, $pages)
    {
        include 'pages/gallery.php';
    }

    public function newPicture()
    {
        include 'pages/newPicture.php';
    }

    public function userImages($data, $pages)
    {
        include 'pages/user/userImages.php';
    }

    public function confirm()
    {
        include 'pages/confirm.php';
    }

    public function confirmed($result)
    {
        include 'pages/confirmed.php';
    }

    public function forgot()
    {
        include 'pages/forgot.php';
    }
}