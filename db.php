<?php

class Db {
    /* singleton */
    private static $db;
    
    /* @var $conn PDO */
    private $conn=null;
    private $stmt;
    private static $queries = array();
    private static $config = array();

    private function __construct(){   
        try {
            if(empty(self::$config))
            {
                echo 'Database configuration error (config via Db::config(dbName,user,password,host)';
                die();
            }
            $this->conn = new PDO("mysql:host=".self::$config['host'], self::$config['user'], self::$config['password']);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db_name = "`".str_replace("`","``",self::$config['dbName'])."`";
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS $db_name");
            $this->conn->exec("use $db_name");
        } 
        catch(PDOException $e) 
        {
            $this->conn = null;
            echo 'ERROR: ' . $e->getMessage();
            die();
        }
    }
    
    function query($prepare,$execute=null){
        if($this->conn==null) return;
        self::$queries[]=array($prepare,$execute);
        $this->stmt = $this->conn->prepare($prepare);
        if ($execute == null)$this->stmt->execute();
        else $this->stmt->execute($execute);
        return $this->stmt;
    }
    
    function queryAndReturnId($prepare,$execute=null)
    {
        $this->query($prepare, $execute);
        return $this->conn->lastInsertId();
    }
    
    static function config($dbName,$user,$password,$host='localhost')
    {
        self::$config = array(
          'dbName' => $dbName,
          'user' => $user,
          'password' => $password,
          'host' => $host
        );
    }

    static function getDb()
    {
        if(empty(self::$db))
            self::$db = new Db();
        
        return self::$db;
    }
    
    static function getQueries()
    {
        return self::$queries;
    }
    
}