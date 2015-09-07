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
            $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

            $db = null;
            $db = new \PDO($dsn, DB_USER, DB_PASSWORD, array(\PDO::ATTR_PERSISTENT => true, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            self::$connection = $db;
        }

        return self::$connection;
    }
}