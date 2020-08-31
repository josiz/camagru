<?php

//
// setcookie('cookie', 'jees', [
//     'expires' => time() + 86400,
//     'path' => '/',
//     'domain' => 'domain.com',
//     'secure' => true,
//     'httponly' => true,
//     'samesite' => 'Strict',
// ]);
// header('Set-Cookie: PHPSESSID; SameSite=strict; Secure');
//
session_start();
//
require_once 'config/setup.php';

$url = $_SERVER['REQUEST_URI'];

$url = preg_split("/\.php/", $url);

$url = end($url);

$url = preg_split("/\?/", $url);
$url = $url[0];

$url = trim($url, '/');
$url = explode('/', $url);

$controllerName = $url[0];
$action = $url[1];
$value = $url[2];


require_once 'classes/model/usermodel.class.php';
require_once 'classes/model/blogmodel.class.php';
require_once 'classes/control/blogcontroller.class.php';
require_once 'classes/control/usercontroller.class.php';
require_once 'classes/control/ajaxcontroller.class.php';

$userManager = new Usermodel();
$blogManager = new Blogmodel();

if ($controllerName == "" && $action == "")
{
    $controllerName = "blog"; $action = "index";
}

$controller = new $controllerName($userManager, $blogManager);
$controller->{$action}($value);

$url = "";