<?php

namespace App;

use PDO;

class Connection
{
    /**
     * @return PDO
     */
    public static function getPDO() : PDO
    {
        return new PDO('mysql:dbname=blog;host=127.0.0.1', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

}