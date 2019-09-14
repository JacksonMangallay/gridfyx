<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\Config;

final class Autoload extends Config{

    private $directories = array(
        'system/core',
        'system/helpers',
        'system/library',
        'system/third_party'
    );

    public function __construct(){

        parent::__construct();
        self::config()->load('autoload');

        foreach(self::config()->get('autoload') as $key){

            $dir = BASEPATH . '/' . $key;

            if(!is_dir($dir)){
                display_log('Directory ' . $dir . ' does not exist!');
            }

            if(strpos($key, 'system') !== false){
                display_log('Unable to load files from restricted directory ' . $key . '!');
            }

            array_push($this->directories, $key);
            
        }

        $this->initialize();

    }

    public function initialize(){

        spl_autoload_register(function($class){

            foreach($this->directories as $key){

                $dir = BASEPATH . '/' . $key;
                $class = str_replace('\\', '/', $class);
                $filename = $this->real_path($dir, $class) . '.php';

                //Check and load class file
                if(file_exists($filename)){
                    require_once($filename);
                }

            }

        });

    }

	/**
	 * 
     * @param string $dir
     * @param string $class
     * 
     * @return string
     */
    private function real_path($dir = '', $class = ''){

        if(is_empty($dir) || is_empty($class)){
            return false;
        }

        //Convert path to an array
        $array_path = explode('/', $dir);

        //Convert class with namespace to an array
        $array_class = explode('/', $class);

        //Merge path and class arrays and remove duplicate values to get relative class path
        $filepath = array_merge($array_path, $array_class);
        $filepath = array_unique($filepath);

        //Get relative class name (without its namespace)
        $relative_classname = end($filepath);

        //Transform filepath string to lower cases to match folder naming convention
        $filepath = array_map('strtolower', $filepath);

        //Remove last array value from path and push the relative class name
        array_pop($filepath);
        array_push($filepath, $relative_classname);
        $filepath = array_unique($filepath);
        $filepath = implode('/', $filepath);

        //Transform class array into string and return value
        return strtolower($filepath);

    }

}