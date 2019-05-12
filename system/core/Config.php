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

class Config
{

    protected static $display_error = false;
    protected static $log_error = true;
    protected static $timezone = 'Asia/Manila';
    protected static $date_format = 'Y-m-d H:i:s';

    protected static $error_pages_path;

    public static function initialize()
    {
        load_config('config');
        load_config('functions');
    }

    public static function setDisplayError(Bool $display)
    {
        self::$display_error = $display;
    }

    public static function getDisplayError()
    {
        return self::$display_error;
    }

    public static function setLogError(Bool $log)
    {
        self::$log_error = $log;
    }

    public static function getLogError()
    {
        return self::$log_error;
    }

    public static function setTimezone(String $timezone)
    {
        self::$timezone = $timezone;
    }

    public static function getTimezone()
    {
        return self::$timezone;
    }

    public static function setDateFormat(String $date_format)
    {
        self::$date_format = $date_format;
    }

    public static function getDateFormat()
    {
        return self::$date_format;
    }

    public static function setErrorPagesPath(String $error_pages_path = '')
    {
        self::$error_pages_path = $error_pages_path;
    }

    public static function getErrorPagesPath()
    {
        return self::$error_pages_path;
    }

}