<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    public static function getDatabase()
    {
        $config = include_once __DIR__ . '/../app/database.php';

        if($config['driver'] == 'sqlite') {
            $sqlite = __DIR__ . '/../storage/database/' . $config['sqlite']['database'];
            $sqlite = "sqlite:" . $sqlite;

            try {
                $pdo = new PDO($sqlite);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                return $pdo;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else if ($config['driver'] == 'mysql') {
            $host = $config['mysql']['host'];
            $db = $config['mysql']['database'];
            $user = $config['mysql']['user'];
            $pass = $config['mysql']['pass'];
            $charset = $config['mysql']['charset'];
            $collation = $config['mysql']['collation'];

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAME '$charset' COLLATE '$collation'");
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                return $pdo;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}