<?php

namespace Core;

use PDO;
use PDOException;
use Core\Config;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $host = Config::get('DB_HOST');
            $dbname = Config::get('DB_NAME');
            $username = Config::get('DB_USERNAME');
            $password = Config::get('DB_PASSWORD');

            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
