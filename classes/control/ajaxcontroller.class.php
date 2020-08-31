<?php

class Ajax
{
    private $userModel;
    private $blogModel;

    public function __construct($user, $blog)
    {
        $this->userModel = $user;
        $this->blogModel = $blog;
    }

    public function isAdmin()
    {
        if ($_SESSION['admin'] == 1)
            echo "You are an admin!";
        else
            echo "You are not an admin..";
    }

    public function changeInfo()
    {
        $user = $_SESSION['user'];
        $first = $_POST['firstName'];
        $last = $_POST['lastName'];
        $email = $_POST['email'];
        $csrf = $_POST['csrf'];

        if ($csrf != $_SESSION['csrf'])
        {
            echo "CSRFerror";
            return;
        }

        if ($this->userModel->updateUserInfo($user, $first, $last, $email) == true)
            echo true;
        else
            echo false;
    }

    public function uploadImage()   // Uploading a temporary image.
    {
        //var_dump($_POST);
        //echo $_POST['filterName'];
        $filterName = $_POST['filterName'];
        $filterx = substr($_POST['filterPosX'], 0, -2);
        $filtery = substr($_POST['filterPosY'], 0, -2);
        $imageData = $_POST['imageData'];

        $filterx /= $_POST['kerroin'];
        $filtery /= $_POST['kerroin'];
    
        $img = $_POST['imgData'];

        $imageData = str_replace("data:image/png;base64,", "", $imageData);
        $imageData = str_replace(" ", "+", $imageData);

        $data = base64_decode($imageData);

        $file = './images/uploadsTemp/'. $_SESSION['user'] . mktime() .'.png';

        $src = imagecreatefrompng('./images/filters/'. $filterName .'.png');
        $src = imagescale($src, 200, 200);
        $dest = imagecreatefromstring($data);
        imagesavealpha($src, true);
        
        $mitenmeni = imagecopy($dest, $src, $filterx, $filtery, 0, 0, 200, 200);

        echo $filterx;
        header('Content-Type: image/png');

        
        $status = imagepng($dest, $file);

        $this->blogModel->uploadImage($file, $_SESSION['userid']);

        //$success = file_put_contents($file, $data);
        // TULEE TAhan NIIN ERIKOKOSINA, ET MENEE SEKASIN. PITAA SUURENTAA WEBCAMIA SIIHEN, MITA TULEE OLEMAAN
        
    }

    public function removeImage()
    {
        $id = $_POST['postId'];

        $this->blogModel->removeImage($id);
    }

    public function getComments()
    {
        $postId = $_POST['postId'];

        $ret = $this->blogModel->getComments($postId);
        $ret = json_encode($ret);

        echo $ret;
    }

    public function getLikes()
    {
        $postId = $_POST['postId'];

        $ret = $this->blogModel->getLikes($postId);
        $ret = json_encode($ret);
        echo $ret;
    }

    public function sendNotification($postId)
    {
        $email = $this->userModel->getEmailByPostId($postId);

        if ($email)
            mail($email, "Camagru notification", "Someone has commented your picture!");
    }

    public function comment()
    {
        if ($_POST['csrf'] != $_SESSION['csrf'])
        {
            echo "csrf";
            return;
        }
        if (!$_SESSION['user'])
        {
            echo "notLogged";
            return;
        }
        $comment = $_POST['comment'];
        $postId = $_POST['postId'];
        $userId = $_SESSION['userid'];

        $ret = $this->blogModel->comment($postId, $comment, $userId);
        $ret = json_encode($ret);

        echo $ret;
        $this->sendNotification($postId);
    }

    public function like()
    {
        if (!$_SESSION['user'])
        {
            echo "notLogged";
            return;
        }
        $postId = $_POST['postId'];

        $ret = $this->blogModel->addLike($postId);

        echo $ret;
    }

    public function changePassword()
    {
        $oldpw = $_POST['oldPW'];
        $newpw = $_POST['newPW'];
        $newpw2 = $_POST['newPW2'];
        $csrf = $_POST['csrf'];

        if ($csrf != $_SESSION['csrf'])
        {
            echo "CSRFerror";
            return;
        }

        if ($newpw !== $newpw2)
        {
            echo "New passwords don't match";
            return "asd";
        }
        if (!$newpw || !$newpw2 || !$oldpw)
        {
            echo "Fill all boxes";
            return;
        }

        $response = $this->userModel->changePassword($oldpw, $newpw, $newpw2);

        echo $response;
    }

    public function removeAccount()
    {
        $response = $this->userModel->removeAccount();

        if ($response == true)
        {
            session_destroy();
            echo true;
        }
    }

    public function forgot()
    {
        $email = $_POST['email'];

        $response = $this->userModel->checkIfExistsByEmail($email);

        if ($response)
        {
            $newPW = $this->userModel->replaceForgottenPassword($email);

            if ($newPW)
            {
                mail($email, "Camagru, new password", "Your new password is " .$newPW. ". Change it to a private one.");
                echo true;
            }
            else
                echo "strange error";
        }
        else
        echo false;
    }

    public function changeNotif()
    {
        $value = $_POST['conf'];

        if ($value == "on")
            $value = 1;
        if ($value == "off")
            $value = 0;
        

        $user = $_SESSION['user'];

        $result = $this->userModel->changeNotif($value, $user);

        echo $result;
    }
    
}