<?php

class Database
{
    private static $dbHost = 'localhost';
    private static $dbName = 'DamirDB';
    private static $dbUsername = 'root';
    private static $dbUserpassword = 'root';
    private static $pdo = null;

    public static function connect()
    {
        if (self::$pdo == null) {
                try {
                    self::$pdo = new PDO('mysql:host=' . self::$dbHost . ';dbname=' . self::$dbName, self::$dbUsername, self::$dbUserpassword);
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
        return self::$pdo;
    }

    public static function disconnect()
    {
        self::$pdo = null;
    }
    /**
     * Methode pour prepare et execute
     *
     * @param [type] $sql
     * @param array $data
     * @return void
     */
    public static function query($sql, $data = array())
    {
        $req = self::$pdo->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ); //resultat de la requete sous forme d'objet
    }
}
