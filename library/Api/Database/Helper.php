<?php

namespace Api\Database;

use Api\Database;


class Helper
{
    public static function getConnection ($env)
    {
        $config   = new \Zend_Config_Ini(APPLICATION_PATH . '/configs/database.ini', $env);
        $dsn      = $config->db->dsn;
        $user     = $config->db->username;
        $password = $config->db->password;

        $conn = new Database($dsn, $user, $password);
        $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
