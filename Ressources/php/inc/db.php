<?php

    $pdo= new PDO('mysql:host=localhost;dbname=arborea','root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    // class Database
    // {
    //     private static $dbHost = 'localhost';
    //     private static $dbName = 'arborea';
    //     private static $dbUsername = 'root';
    //     private static $dbUserpassword = 'root';
        
    //     private static $pdo = null;
        
    //     public static function connect()
    //     {
    //         if(self::$pdo == null)
    //         {
    //             try
    //             {
    //             self::$pdo = new PDO('mysql:host=' . self::$dbHost . 'dbname=' . self::$dbName , self::$dbUsername, self::$dbUserpassword);
    //             self::$pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //             self::$pdo-> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    //             }
    //             catch(PDOException $e)
    //             {
    //                 die($e->getMessage());
    //             }
    //         }
    //         return self::$pdo;
    //     }
        
    //     public static function disconnect()
    //     {
    //         self::$pdo = null;
    //     }

    // }