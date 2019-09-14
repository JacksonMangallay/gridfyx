<?php declare(strict_types = 1);
/**
 *---------------------------------------------------------------------------------
 * GRIDFYX PHP FRAMEWORK
 *---------------------------------------------------------------------------------
 *
 * A progressive PHP framework for small to medium scale web applications
 *
 * MIT License
 *
 * Copyright (c) 2019 Jackson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 *
 * @package	Gridfyx PHP Framework
 * @author	Jackson Mangallay
 * @license	MIT License
 * @link	https://github.com/JacksonMangallay/gridfyx
 * @since	Version 2.0.0
 *
 */

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