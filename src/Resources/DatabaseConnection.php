<?php
namespace App\Resources;

use PDO;
use PDOException;

class DatabaseConnection {

    private static $pdo;

    public static function getPDO() {
        if (self::$pdo === null) {
    
            $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
    
            try {
                self::$pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], $options);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$pdo;
    }
    
}
