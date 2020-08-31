<?php

require 'db.class.php';

class Usermodel extends Database
{

    public function __construct()
    {
        
        try{
        $this->connect();  
        }
        catch (PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }

    }

    public function getUserDataByUname($uname)
    {
        try{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE userName=?");
        
        $stmt->execute([$uname]);
        } catch(PDOException $e)
        {
            echo $e->getMessage();
        }

        if ($stmt->rowCount())
            $ret = $stmt->fetch();
 
        return $ret;
    }

    public function signup()
    {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            return "invalid email";
        if (!$_POST['uname'] || !$_POST['pass'])
            return "fill all fields";
        
        try{
            $stmt = $this->pdo->prepare("SELECT userName, userEmail FROM users");
            $stmt->execute();
            while($row = $stmt->fetch())
            {
                if ($_POST['uname'] == $row['userName'] || $_POST['email'] == $row['userEmail'])
                    return "error";
                print_r($row);
            }
        }
        catch (PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }
        
        $pass = hash('sha256', $_POST['pass']);
        print($_POST['email']);
        $validationCode = strval(rand(200000000000000, 400000000000000));
        try
        {
            $stmt = $this->pdo->prepare("INSERT INTO users (userName, userPass, userEmail, userConfirmationCode) VALUES (?,?,?,?)");
            $stmt->execute([$_POST['uname'], $pass, $_POST['email'], $validationCode]);
        }   
        catch (PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }

        $email = $_POST['email'];
        $user = $_POST['uname'];

        $message = 
        "
        Hello,
        Verify your account by clicking the confirmation link below:
        http://localhost:8080/camagru/index.php/blog/confirmed?user=$user&conf=$validationCode
        ";

        mail($email, "Confirmation email", $message);

        return "success";


    }

    public function login()
    {
        
        $user = $_POST['uname'];
        $pass = hash('sha256', $_POST['pass']);
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE userName=?");
        $stmt->execute([$user]);
        
        $row = $stmt->fetch();

        if ($row['userConfirmed'] == false)
        {
            return "conf";
        }

        if ($row['userPass'] == $pass)
        {
            session_start();
            $_SESSION['user'] = $row['userName'];
            $_SESSION['userid'] = $row['id'];
            $_SESSION['admin'] = $row['userAdmin'];
            return;
        }
        else
            return "error";
    }

    public function updateProfilePicture($picture)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET userProfileImage=? WHERE userName=?");
        $stmt->execute([$picture, $_SESSION['user']]);
        header('Location: /camagru/index.php/user/userHome');
    }

    public function updateUserInfo($user, $first, $last, $email) // called from ajax
    {
        try
        {
        $stmt = $this->pdo->prepare("UPDATE users SET userFirstName=?, userLastName=?, userEmail=? WHERE userName=?");
        $stmt->execute([$first, $last, $email, $user]);
        }
        catch(PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
            return false;
        }
        return true;
    }

    public function changePassword($oldpw, $newpw, $newpw2)
    {
        $user = $_SESSION['user'];
        $oldHash = hash('sha256', $oldpw);
        $newHash = hash('sha256', $newpw);

        try
        {
            $stmt = $this->pdo->prepare("SELECT userPass FROM users WHERE userName=?");
            $stmt->execute([$user]);
            $result = $stmt->fetch();
        }
        catch(PDOException $e)
        {
            return "Connection failed: ".$e->getMessage();
            return false;
        }

        if ($oldHash != $result['userPass'])
            return "invalid password";
        else
        {
            try
            {
                $stmt = $this->pdo->prepare("UPDATE users SET userPass=? WHERE userName=?");
                $stmt->execute([$newHash, $user]);
            }
            catch(PDOException $e)
            {
                echo "Connection failed: ".$e->getMessage();
                return false;
            }
            return true;
        }
        

    }

    public function getAllUserData() // for admin page only
    {
        try
        {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }

        return $users;
    }

    public function userImagesFirstNine($userId)
    {
        try
        {
        $stmt = $this->pdo->prepare("SELECT * FROM post WHERE `user_id`=? AND `removed`=false ORDER BY date_time DESC LIMIT 9");
        $stmt->execute([$userId]);
        $posts = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }
        return $posts;
    }

    public function userImagePageCount($userId)
    {
        try
        {
        $stmt = $this->pdo->prepare("SELECT * FROM post WHERE `user_id`=? AND `removed`=false");
        $stmt->execute([$userId]);
        $rows = $stmt->rowCount();
        }
        catch(PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }
        if ($rows > 9)
            return (ceil($rows / 9));
        if ($rows < 10 && $rows > 0)
            return 1;
        else return 0;
    }

    public function userImagesByPage($userId, $page)
    {
        $page = (9 * $page) - 9;
        try
        {
        $stmt = $this->pdo->prepare("SELECT * FROM post WHERE `user_id`=? AND `removed`=false ORDER BY date_time DESC LIMIT 9 OFFSET ?");
        $stmt->execute([$userId, $page]);
        $posts = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }
        return $posts;
    }

    public function checkConf($user, $code)
    {
        try
        {
            $stmt = $this->pdo->prepare("SELECT userConfirmationCode FROM users WHERE userName=?");
            $stmt->execute([$user]);
            $row = $stmt->fetch();
        }
        catch(PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }

        if ($row['userConfirmationCode'] == $code)
        {
            try
            {
                $stmt = $this->pdo->prepare("UPDATE users SET userConfirmed=1 WHERE userName=?");
                $stmt->execute([$user]);
            }
            catch(PDOException $e)
            {
                echo "Connection failed: ".$e->getMessage();
            }

            return true;
        }
        else
            return false;
    }

    public function removeAccount()
    {
        $user = $_SESSION['user'];

        try
            {
                $stmt = $this->pdo->prepare("DELETE FROM users WHERE userName=?");
                $stmt->execute([$user]);
            }
            catch(PDOException $e)
            {
                echo "Connection failed: ".$e->getMessage();
                return;
            }
            return true;
    }

    public function getEmailByPostId($id)
    {
        try
            {
                $stmt = $this->pdo->prepare("SELECT post.post_id, users.userEmail, users.userGetNotif FROM post INNER JOIN users ON post.user_id = users.id WHERE post_id=? AND userGetNotif=1");
                $stmt->execute([$id]);
                $result = $stmt->fetch();

                if ($stmt->rowCount() == 0)
                    return false;
            }
            catch(PDOException $e)
            {
                echo "Connection failed: ".$e->getMessage();
                return;
            }
           return $result['userEmail'];
    }

    public function checkIfExistsByEmail($email)
    {
        try
            {
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE userEmail=?");
                $stmt->execute([$email]);
                $rows = $stmt->rowCount();
            }
            catch(PDOException $e)
            {
                echo "Connection failed: ".$e->getMessage();
                return;
            }
            if ($rows)
                return true;
            else
                return false;
    }

    public function replaceForgottenPassword($email)
    {
        $number = rand(60000, 90000);
        $newHash = hash('sha256', $number);

        try
            {
                $stmt = $this->pdo->prepare("UPDATE users SET userPass=? WHERE userEmail=?");
                $stmt->execute([$newHash, $email]);
            }
            catch(PDOException $e)
            {
                echo "Connection failed: ".$e->getMessage();
                return false;
            }
        return $number;
    }

    public function changeNotif($value, $user)
    {
        try
            {
                $stmt = $this->pdo->prepare("UPDATE users SET userGetNotif=? WHERE userName=?");
                $stmt->execute([$value, $user]);
            }
            catch(PDOException $e)
            {
                return "Connection failed: ".$e->getMessage();
            }
            return true;
    }
}



