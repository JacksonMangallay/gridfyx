<?php

declare(strict_types = 1);

namespace System\Core;

class Config{

    //Exception settings
    protected static $display_error = false;
    protected static $log_error = true;
    protected static $timezone = 'Asia/Manila';
    protected static $date_format = 'Y-m-d H:i:s';

    //Error pages
    protected static $error_pages_path;

    public static function initialize(){
        load_config('config');
        load_config('functions');
    }

    public static function setDisplayError(Bool $display){
        self::$display_error = $display;
    }

    public static function getDisplayError():bool{
        return self::$display_error;
    }

    public static function setLogError(Bool $log){
        self::$log_error = $log;
    }

    public static function getLogError():bool{
        return self::$log_error;
    }

    public static function setTimezone(String $timezone){
        self::$timezone = $timezone;
    }

    public static function getTimezone():string{
        return self::$timezone;
    }

    public static function setDateFormat(String $date_format){
        self::$date_format = $date_format;
    }

    public static function getDateFormat():string{
        return self::$date_format;
    }

    public static function setErrorPagesPath(String $error_pages_path = ''){
        self::$error_pages_path = $error_pages_path;
    }

    public static function getErrorPagesPath():string{
        return self::$error_pages_path;
    }

}