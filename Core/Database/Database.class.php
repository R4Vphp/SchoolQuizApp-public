<?php

namespace Core\Database;

use PDO;

abstract class Database {

    const DB_SERVER = "127.0.0.1";
    const DB_NAME = "zs1quiz";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB_CHARSET = "utf8mb4";
    
    const HASH_METHOD = "crc32b";

    private static $connection;

    public static function connect(){

        if(self::$connection) return self::$connection;

        $dsn = "mysql:host=".self::DB_SERVER.";dbname=".self::DB_NAME.";charset=".self::DB_CHARSET;
        
        try{
            $conn = new PDO($dsn, self::DB_USER, self::DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$connection = $conn;
            return $conn;
        }catch(PDOException $e){
            echo "Connection failed: ".$e->getMessage();
            exit();
        }
    }

    public static function uniqueId(){
        
        return strtoupper(hash(self::HASH_METHOD, bin2hex(random_bytes(4)).time()));
    }
}