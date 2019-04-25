<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

class Config
{

    //Exception settings
    protected static $display_error = false;
    protected static $log_error = true;
    protected static $timezone = 'Asia/Manila';
    protected static $date_format = 'Y-m-d H:i:s';

    //Error pages
    protected static $error_pages_path;

    public static function initialize():void
    {
        load_config('config');
        load_config('functions');
    }

    public static function setDisplayError(Bool $display):void
    {
        self::$display_error = $display;
    }

    public static function getDisplayError():bool
    {
        return self::$display_error;
    }

    public static function setLogError(Bool $log):void
    {
        self::$log_error = $log;
    }

    public static function getLogError():bool
    {
        return self::$log_error;
    }

    public static function setTimezone(String $timezone):void
    {
        self::$timezone = $timezone;
    }

    public static function getTimezone():string
    {
        return self::$timezone;
    }

    public static function setDateFormat(String $date_format):void
    {
        self::$date_format = $date_format;
    }

    public static function getDateFormat():string
    {
        return self::$date_format;
    }

    public static function setErrorPagesPath(String $error_pages_path = ''):void
    {
        self::$error_pages_path = $error_pages_path;
    }

    public static function getErrorPagesPath():string
    {
        return self::$error_pages_path;
    }

}