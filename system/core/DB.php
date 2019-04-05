<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

class DB{

    private static $db_groups = [];

    public static function Initialize(){
        load_config('database');
    }

    public static function CreateGroup(String $name, Array $group){
        self::$db_groups[$name] = $group;
    }

    public static function FetchGroup(String $name):array{
    
        if(!array_key_exists($name, self::$db_groups)){
            throw new Exception('Undefined database group selected!');
        }
        
        return self::$db_groups[$name];
    }

}