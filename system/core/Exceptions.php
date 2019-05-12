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

class Exceptions
{

    private $display_error;
    private $log_error;
    private $timezone;
    private $date_format;

    private $severity = array(
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parsing Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Runtime Notice'
    );

    public function __construct()
    {
        $this->display_error = Config::getDisplayError();
        $this->log_error = Config::getLogError();
        $this->timezone = Config::getTimezone();
        $this->date_format = Config::getDateFormat();
    }

    public function errorHandler(Int $severity, String $message, String $file, Int $line)
    {
        $this->handle($severity,$message,$file,$line);
    }

    private function handle(Int $severity, String $message, String $file, Int $line)
    {
        date_default_timezone_set($this->timezone);

        $date = date($this->date_format);
        $severity = $this->severity[$severity];
        $message = '[' .$date. '] [' . $severity . '] ' . $message . ' - ' . $file . ' --> Line ' . $line;

        if($this->display_error)
        {
            $this->displayLog($message);
        }

        if($this->log_error)
        {
            $this->writeLog($message);
        }
    }

    private function writeLog(String $message)
    {
        $error_log_file = DATA . DS . 'logs' . DS . 'errors.txt';

        $fp = fopen($error_log_file, 'ab');

        if(flock($fp, LOCK_EX))
        {
            fwrite($fp, $message . "\n");
            fflush($fp);
            flock($fp, LOCK_UN);
        }
        else
        {
            $this->displayLog('Unable to write error log file.');
        }

        fclose($fp);
    }

    private function displayLog(String $message)
    {
        $error = '<div style="position: relative; z-index: 999; font-family: Helvetica, Arial, sans-serif; font-size: .9rem; display: block; clear: both; background-color: #fcf8e3; border: 1px solid #843534; color: #8a6d3b; box-sizing: border-box; padding: 20px; margin-bottom: 10px;">';
        $error .= $message;
        $error .= '</div>';
        echo $error;
    }
    
}