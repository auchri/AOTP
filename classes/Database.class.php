<?php

namespace AOTP;

class Database
{
    private static $connection;

    /**
     * Returns the database connection
     *
     * @return \PDO
     */
    public static function getConnection() {
        if (self::$connection == null) {
            $pdo              = self::connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            self::$connection = $pdo;
        }

        return self::$connection;
    }

    /**
     * Connects to the database with the give parameters
     *
     * @param $host     string
     * @param $username string
     * @param $password string
     * @param $database string
     *
     * @return \PDO
     */
    public static function connect($host, $username, $password, $database) {
        $dsn = 'mysql:dbname=' . $database . ';host=' . $host;

        $pdo = @new \PDO($dsn, $username, $password, array(\PDO::ATTR_PERSISTENT => true, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

        return $pdo;
    }
}