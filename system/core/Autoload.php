<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

class Autoload{

    /*
    *---------------------------------------------------------------
    * Add directories to be loaded in default
    *---------------------------------------------------------------
    */
    private static $directories = [
        'system/core',
        'system/library'
    ];

    private static $directory;

    public static function AddDirectory(String $directory){

        if(strpos($directory, 'system') !== false){
            throw new Exception('Unable to load restricted directory ' . $directory . '!');
        }

        array_push(self::$directories, $directory);
    
    }

    /*
    *---------------------------------------------------------------
    * Load autoload.php and load classes inside set folders
    *---------------------------------------------------------------
    */
    public static function Initialize(){

        load_config('autoload');

        spl_autoload_register(function(String $class){

            foreach(self::$directories as $directory){

                $file = BASEPATH . DS . $directory;
                $class = str_replace('\\', '/', $class);
                $class_file = self::GetRealPath($file, $class) . '.php';

                if(file_exists($class_file)){
                    require_once($class_file);
                }

            }

        });

    } 

    private static function GetRealPath(String $path, String $class):string{        
        
        $arr_path = explode('/', $path);
        $arr_class = explode('/', $class);

        $file_path = array_merge($arr_path, $arr_class);
        $file_path = array_unique($file_path);

        $relative_class_name = end($file_path);
        
        $file_path = array_map('strtolower', $file_path);

        array_pop($file_path);
        array_push($file_path, $relative_class_name);
        $file_path = array_unique($file_path);

        return implode('/', $file_path);

    }

}