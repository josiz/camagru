<?php

class Blogmodel extends Database
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

    public function getAllPosts()
    {
        
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM post");

            $stmt->execute();
            $ret = $stmt->fetchAll();
            } catch(PDOException $e)
            {
                echo $e->getMessage();
            }
            return $ret;
    }

    public function getAllLikes()
    {
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM likes");

            $stmt->execute();
            $ret = $stmt->fetchAll();
            } catch(PDOException $e)
            {
                echo $e->getMessage();
            }
            return $ret;
    }

    public function uploadImage($file, $uid)
    {
        $file = preg_replace('/\./', '/camagru', $file, 1);
        try{
            $stmt = $this->pdo->prepare("INSERT INTO post (`user_id`, picture) VALUES (?, ?)");

            $stmt->execute([$uid, $file]);

            } catch(PDOException $e)
            {
                echo $e->getMessage();
            }
    }

    public function removeImage($id)
    {
        
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM post WHERE `post_id`=?");

            $stmt->execute([$id]);
            $ret = $stmt->fetch();
            } catch(PDOException $e)
            {
                echo $e->getMessage();
            }
            if ($ret['user_id'] == $_SESSION['userid'])
            {
                echo $id;
                try
                {
                $stmt = $this->pdo->prepare("UPDATE post SET `removed`=true WHERE `post_id`=?");
                $stmt->execute([$id]);
                } catch(PDOException $e)
                {
                    echo $e->getMessage();
                }
            }
    }

    public  function getLastPostId()
    {
        try{
            $stmt = $this->pdo->prepare("SELECT MAX(post_id) as `max` FROM post");

            $stmt->execute();
            $ret = $stmt->fetch();
            } catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        return $ret['max'];   
    }

    public function getGalleryFirstPosts()
    {
        try{
            $stmt = $this->pdo->prepare("SELECT post.*, users.userName FROM post INNER JOIN users ON post.user_id = users.id WHERE `removed`=false ORDER BY post_id DESC LIMIT 10");

            $stmt->execute();
            $ret = $stmt->fetchAll();
            } catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        return $ret;
    }

    public function getGalleryPostsByPage($page)
    {
        $offset = ($page * 9) - 9;
        try
        {
            $stmt = $this->pdo->prepare("SELECT post.*, users.userName FROM post INNER JOIN users ON post.user_id = users.id WHERE `removed`=false ORDER BY post_id DESC LIMIT 10 OFFSET ?");
            $stmt->execute([$offset]);
            $ret = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $ret;
    }

    public function getLike($data)
    {
        if (!$_SESSION['user'])
            return $data;
        $uid = $_SESSION['userid'];
        foreach($data as $k => $v)
        {
            try
            {
            $stmt = $this->pdo->prepare("SELECT * FROM likes WHERE post_id=".$data[$k]['post_id']." AND `user_id`=?");
            $stmt->execute([$uid]);
            $result = $stmt->rowCount();
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
            if ($result == 0)
                $data[$k]['liked'] = false;
            else
                $data[$k]['liked'] = true;
        }
        return $data;
    }

    public function getComments($postId)
    {
        try
        {
        $stmt = $this->pdo->prepare("SELECT comment.*, users.userName FROM comment INNER JOIN users ON comment.user_id = users.id WHERE post_id=? ORDER BY date_time DESC");
        $stmt->execute([$postId]);
        $comments = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        foreach ($comments as $k => $v)
            $comments[$k]['comment'] = htmlentities($comments[$k]['comment'], ENT_QUOTES, "UTF-8");

        return $comments;
    }

    public function comment($postId, $comment, $userId)
    {
        try
        {
            $stmt = $this->pdo->prepare("INSERT INTO comment (post_id, `user_id`, comment) VALUES (?, ?, ?)");
            $stmt->execute([$postId, $userId, $comment]);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        $id = $this->pdo->lastInsertId();

        try
        {
            $stmt = $this->pdo->prepare("SELECT comment.*, users.userName FROM comment INNER JOIN users ON comment.user_id = users.id WHERE comment_id=?");
            $stmt->execute([$id]);
            $ret = $stmt->fetch();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        $ret['comment'] = htmlentities($ret['comment'], ENT_QUOTES, "UTF-8");
        return $ret;
    }

    public function addLike($postId)
    {
        $user = $_SESSION['userid'];

        try
        {
            $stmt = $this->pdo->prepare("SELECT * FROM likes WHERE post_id=? AND `user_id`=?");
            $stmt->execute([$postId, $user]);
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
        if ($stmt->rowCount() > 0)
            return "alreadyLiked";
        try
        {
            $stmt = $this->pdo->prepare("INSERT INTO likes (post_id, `user_id`) VALUES (?, ?)");
            $stmt->execute([$postId, $user]);
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
        try
        {
            $stmt = $this->pdo->prepare("UPDATE post SET likes=likes+1 WHERE post_id=?");
            $stmt->execute([$postId]);
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
        return "success";
    }

    public function getLikes($postId)
    {
        try
        {
        $stmt = $this->pdo->prepare("SELECT likes.*, users.userName FROM likes INNER JOIN users ON likes.user_id = users.id WHERE post_id=? ORDER BY like_id DESC");
        $stmt->execute([$postId]);
        $likes = $stmt->fetchAll();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        foreach ($likes as $k => $v)
            $likes[$k]['comment'] = htmlentities($likes[$k]['comment'], ENT_QUOTES, "UTF-8");

        return $likes;
    }

    public function getGalleryPages()
    {
        try
        {
            $stmt = $this->pdo->prepare("SELECT * FROM post WHERE `removed`=false");
            $stmt->execute();
            $rows = $stmt->rowCount();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        $ret = ceil($rows / 10);
        return $ret;
    }

/*
    public function getGalleryFirstComments($lastId)
    {
        $firstId = $lastId - 10;
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM comment ORDER BY post_id DESC, date_time DESC");

            $stmt->execute();
            $ret = $stmt->fetchAll();
            } catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        return $ret;
    }
*/
}