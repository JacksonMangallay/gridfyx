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

use Exception;

if(!function_exists('error_handler')){

	/**
	 * 
     * @param int $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * 
     */
    function error_handler($severity = '', $message = '', $file = '', $line = ''){
        
        require_once(DIR_CORE . '/exceptions.php');
        (new \System\Core\Exceptions())->error_handler($severity, $message, $file, $line);

    }

}

if(!function_exists('exception_handler')){

	/**
	 * 
     * @param object $error
     * 
     */
    function exception_handler($error = ''){

        require_once(DIR_CORE . '/exceptions.php');
        (new \System\Core\Exceptions())->error_handler(E_ERROR, $error->getMessage(), $error->getFile(), $error->getLine());

    }

}

if(!function_exists('shutdown_handler')){

    function shutdown_handler(){

        require_once(DIR_CORE . '/exceptions.php');
        $error = error_get_last();

        if(isset($error) && ($error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING))){
            (new \System\Core\Exceptions())->error_handler($error['type'], $error['message'], $error['file'], $error['line']);
        }

    }

}

if(!function_exists('third_party')){

	/**
	 * 
     * @param string $dir
     * 
     */
    function third_party($dir = ''){

        if(is_empty($dir)){
            throw new Exception('Unable to load third party ' . $dir);
        }

        $file = DIR_THIRD_PARTY . '/' . $dir . '/' . 'index.php';

        if(!file_exists($file)){
            throw new Exception('Third party file does not exist!');
        }

        require_once($file);

    }

}