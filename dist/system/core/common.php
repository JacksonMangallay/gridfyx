<?php declare(strict_types = 1);

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