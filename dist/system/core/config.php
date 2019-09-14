<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

class Config{

    private static $instance = null;
    private $data = array();
    protected $config = null;

    public function __construct(){
        self::$instance = $this;
        self::config()->load('functions');
    }

	public static function config(){
		return self::$instance;
	}

	/**
	 * 
	 * @param string $filename
     * 
     */
    final public function load($filename = ''){

        if(is_empty($filename)){
            return false;
        }

        $file = DIR_CONFIG . '/' . $filename . '.php';

        if(!file_exists($file)){
            display_log('Error: Unable to load config file ' . $filename . '!');
        }

        require_once($file);

        //Set config variable if variable is available
        if(isset($config[$filename])){
            $this->set($filename, $config[$filename]);
        }

    }

	/**
	 * 
     * @param string $key
     * 
     */
    final public function get($key = ''){

        if(is_empty($key)){
            return false;
        }

        return $this->data[$key];
    }

	/**
	 * 
     * @param string $key
     * @param mixed $value
     * 
     */
     private function set($key = '', $value = ''){

        if(is_empty($key) || is_empty($value)){
            return false;
        }

        $this->data[$key] = $value;
    }

}