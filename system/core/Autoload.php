<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use Exception;

class Autoload
{

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

    public static function addDirectory(String $directory):void
    {

        if(strpos($directory, 'system') !== false)
        {
            throw new Exception('Unable to load restricted directory ' . $directory . '!');
        }

        array_push(self::$directories, $directory);
    
    }

    /*
    *---------------------------------------------------------------
    * Load autoload.php and load classes inside set folders
    *---------------------------------------------------------------
    */
    public static function initialize():void
    {

        load_config('autoload');

        spl_autoload_register(function(String $class)
        {

            foreach(self::$directories as $directory)
            {

                $file = BASEPATH . DS . $directory;
                $class = str_replace('\\', '/', $class);
                $class_file = self::getRealPath($file, $class) . '.php';

                if(file_exists($class_file))
                {
                    require_once($class_file);
                }

            }

        });

    } 

    private static function getRealPath(String $path, String $class):string
    {        
        
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