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
 * @since	Version 1.0.0
 *
 */
namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use Exception;

class Autoload
{

    /** 
     * Directories loaded by default
     */
    private static $directories = [
        'system/core',
        'system/library'
    ];

    private static $directory;

    /** 
     * Add directory to be loaded
     */
    public static function addDirectory(String $directory):void
    {

        if(strpos($directory, 'system') !== false)
        {
            throw new Exception('Unable to load restricted directory ' . $directory . '!');
        }

        array_push(self::$directories, $directory);
    
    }

    /** 
     * Run autoloader
     */
    public static function initialize():void
    {

        /** 
         * Load folders set at /application/config/autoload.php
         */
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