<?php


namespace App;


use Exception;

class URL
{
    public static function getInt(string $paramName, ?int $default = null) : ?int
    {
        if(!isset($_GET[$paramName])) return $default;
        if($_GET[$paramName] === '0') return 0;

        if(!filter_var($_GET[$paramName], FILTER_VALIDATE_INT))
        {
            throw new Exception("Le paramètre $paramName n'est pas un entier");
        }

        return (int)$_GET[$paramName];
    }

    public static function getPositiveInt(string $paramName, ?int $default = null) : ?int
    {
        $param = self::getInt($paramName, $default);
        if($param !== null && $param <= 0)
        {
            throw new Exception("Le paramètre $paramName n'est pas un entier positif");
        }
        return $param;
    }


}