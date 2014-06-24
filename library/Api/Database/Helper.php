<?php

namespace Api\Database;

use Api\Database;


class Helper
{
    public static function getConnection ($env)
    {
        $config   = new \Zend_Config_Ini(APPLICATION_PATH . '/configs/database.ini', $env);
        $database = $config->database;
        $host     = $config->host;
        $dsn      = sprintf('mysql:dbname=%s;host=%s', $database, $host);

        $user     = $config->username;
        $password = $config->password;

        $conn = new Database($dsn, $user, $password);
        $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
