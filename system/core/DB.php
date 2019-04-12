<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

class DB{

    private static $db_groups = [];

    public static function initialize(){
        load_config('database');
    }

    public static function createGroup(String $name, Array $group){
        self::$db_groups[$name] = $group;
    }

    public static function fetchGroup(String $name):array{
    
        if(!array_key_exists($name, self::$db_groups)){
            throw new Exception('Undefined database group selected!');
        }
        
        return self::$db_groups[$name];
    }

}