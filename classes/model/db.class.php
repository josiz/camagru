<?php

class Database
{
    private $servername;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    protected $pdo;

    protected function connect()
    {
        $this->servername = "127.0.0.1";
        $this->dbname = "camagru";
        $this->username = "root";
        $this->password = "123123";
        $this->charset = "utf8mb4";

        try
        {
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
        }   
        catch (PDOException $e)
        {
            echo "Connection failed: ".$e->getMessage();
        }
        $this->pdo = $pdo;
    }
}