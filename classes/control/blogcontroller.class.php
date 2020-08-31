<?php

require './classes/view/view.class.php';

class Blog
{
    private $userModel;
    private $blogModel;

    public function __construct($user, $blog)
    {
        $this->userModel = $user;
        $this->blogModel = $blog;
    }

    public function index($request)
    {
        
        $data = $this->userModel->getUserDataByUname($_SESSION['user']);
        
        $view = new View($this->userModel);
        $view->indexView($data);
    }

    public function aboutt()
    {
        View::aboutView();
    }

    public function signupPage($error = "")
    {
        View::signUp($error);
    }

    public function signup()
    {
        $result = $this->userModel->signup();
        if ($result == "error")
            header("Location: /camagru/index.php/blog/signupPage/error");
        else if ($result == "invalid email")
            header("Location: /camagru/index.php/blog/signupPage/email");
        else if ($result == "fill all fields")
            header("Location: /camagru/index.php/blog/signupPage/fields");
        else if ($result == "success")
            header("Location: /camagru/index.php/blog/confirm");
        else
            header("Location: /camagru/index.php");
    }

    public function loginPage($error = "")
    {
        View::login($error);
    }

    public function login()
    {
        
        $result = $this->userModel->login();
        if ($result == "conf")
            header("Location: /camagru/index.php/blog/loginPage/confError");
        else if ($result == "error")
             header("Location: /camagru/index.php/blog/loginPage/error");
         else
             header("Location: /camagru/index.php");
    }

    public function logout()
    {
        session_destroy();
        header("Location: /camagru/index.php");
    }

    public function adminUsers()
    {
        $data = $this->userModel->getAllUserData();
        View::adminUsers($data);
    }

    public function gallery()
    {
        //$lastPostId = $this->blogModel->getLastPostId();
        //$firstGalleryComments = $this->blogModel->getGalleryFirstComments($lastPostId);

        if ($_GET['page'])
        {
            $page = $_GET['page'];
            $pages = $this->blogModel->getGalleryPages();
            $galleryData = $this->blogModel->getGalleryPostsByPage($page);
            $galleryData = $this->blogModel->getLike($galleryData);
        }
        else
        {
            $pages = $this->blogModel->getGalleryPages();
            $galleryData = $this->blogModel->getGalleryFirstPosts();
            $galleryData = $this->blogModel->getLike($galleryData);
        }

        View::gallery($galleryData, $pages);
    }

    public function newPicture()
    {
        if (isset($_SESSION['user']))
            View::newPicture();
        else
            View::notLogged();
    }

    public function confirm()
    {
        View::confirm();
    }

    public function confirmed()
    {
        $user = $_GET['user'];
        $code = $_GET['conf'];

        $result = $this->userModel->checkConf($user, $code);

        View::confirmed($result);
    }

}