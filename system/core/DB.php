<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use Exception;

class DB
{

    private static $db_groups = [];

    public static function initialize():void
    {
        load_config('database');
    }

    public static function createGroup(String $name, Array $group):void
    {
        self::$db_groups[$name] = $group;
    }

    public static function fetchGroup(String $name):array
    {
    
        if(!array_key_exists($name, self::$db_groups))
        {
            throw new Exception('Undefined database group selected!');
        }
        
        return self::$db_groups[$name];
    }

}