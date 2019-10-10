<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') || exit('Direct access is forbidden');

use Exception;

if(!function_exists('exception_class'))
{
    function exception_class()
    {
        require_once(DIR_CORE . '/exceptions.php');
        return new \System\Core\Exceptions();
    }
}

if(!function_exists('error_handler'))
{

	/**
	 * 
     * @param int $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * 
     */
    function error_handler($severity = '', $message = '', $file = '', $line = '')
    {
        (exception_class())->error_handler($severity, $message, $file, $line);
    }

}

if(!function_exists('exception_handler'))
{

	/**
	 * 
     * @param object $error
     * 
     */
    function exception_handler($error = '')
    {
        (exception_class())->error_handler(E_ERROR, $error->getMessage(), $error->getFile(), $error->getLine());
    }

}

if(!function_exists('shutdown_handler'))
{

    function shutdown_handler()
    {

        $error = error_get_last();

        if(isset($error) && ($error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING)))
        {
            (exception_class())->error_handler($error['type'], $error['message'], $error['file'], $error['line']);
        }

    }

}

if(!function_exists('third_party'))
{

	/**
	 * 
     * @param string $dir
     * 
     */
    function third_party($dir = '')
    {

        if(is_empty($dir))
        {
            throw new UnexpectedValueException();
        }

        $file = DIR_THIRD_PARTY . '/' . $dir . '/' . 'index.php';

        if(!file_exists($file))
        {
            throw new UnexpectedValueException();
        }

        require_once($file);

    }

}