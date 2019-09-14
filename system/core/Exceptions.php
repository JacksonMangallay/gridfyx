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

use System\Core\Config;

final class Exceptions extends Config{

    private $settings = null;
    private $display_error = null;
    private $log_error = null;
    private $timezone = null;
    private $date_format = null;

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

    public function __construct(){

        parent::__construct();

        self::config()->load('app');
        $this->settings = self::config()->get('app');

        $this->display_error = $this->settings['development_environment'] ? true : false;
        $this->log_error = true;
        $this->timezone = $this->settings['timezone'];
        $this->date_format = $this->settings['date_format'];

    }

	/**
	 * 
     * @param string $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * 
     */
    public function error_handler($severity = '', $message = '', $file = '', $line = ''){

        date_default_timezone_set($this->timezone);

        $date = date($this->date_format);
        $severity = $this->severity[$severity];
        $message = '[' .$date. '] [' . $severity . '] ' . $message . ' - ' . $file . ' --> Line ' . $line;
        
        write_log($message, 'error');

        if($this->display_error){
            display_log($message);
        }

    }

}