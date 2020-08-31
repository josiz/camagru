<?php



class User
{
    private $userModel;
    private $blogModel;

    public function __construct($user)
    {
        $this->userModel = $user;
        $this->blogModel = $blog;
    }

    public function userHome()
    {
        if (!isset($_SESSION['user']))
            View::notLogged();
        else
        {
            $data = $this->userModel->getUserDataByUname($_SESSION['user']);
            View::userPage($data);
        }
    }

    public function userInfo()
    {
        if (!isset($_SESSION['user']))
            View::notLogged();
        else
        {
            $data = $this->userModel->getUserDataByUname($_SESSION['user']);
            View::userInfo($data);
        }
    }

    public function uploadProfilePicture()
    {
        $file = $_FILES['picture']['tmp_name'];
        if (!isset($_FILES['picture']['tmp_name']))
            echo "ERROR";
        else
        {
            $file = $_FILES['picture'];
            $fileName = $_FILES['picture']['name'];
            $fileTmpName = $_FILES['picture']['tmp_name'];
            $fileSize = $_FILES['picture']['size'];
            $fileError = $_FILES['picture']['error'];
            $fileType = $_FILES['picture']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png');

            if (in_array($fileActualExt, $allowed))
            {
                if ($fileError === 0)
                {
                    if ($fileSize < 1000000)
                    {
                        $fileNewName = $_SESSION['user'].".".$fileActualExt;
                        $fileDestination = 'images/profile/'.$fileNewName;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $this->profilePictureUploaded($fileNewName);
                    }
                    else
                        echo "File size too big! Max size 10Mb.";
                }
                else
                    echo "There was an error when trying to upload the image..";
            }
            else
                echo "Invalid file type!";
        }
    }

    public function profilePictureUploaded($fileName)
    {
        $this->userModel->updateProfilePicture($fileName);
    }

    public function images()
    {
        if (!isset($_GET['page']))
        {
            $pages = $this->userModel->userImagePageCount($_SESSION['userid']);
            $data = $this->userModel->userImagesFirstNine($_SESSION['userid']);
            View::userImages($data, $pages);
        }
        else
        {
            $pages = $this->userModel->userImagePageCount($_SESSION['userid']);
            $data = $this->userModel->userImagesByPage($_SESSION['userid'], $_GET['page']);
            View::userImages($data, $pages);
            echo "PAGE TWO";
        }

    }

    public function forgot()
    {
        View::forgot();
    }
}

