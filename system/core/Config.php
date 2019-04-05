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

    public static function Initialize(){
        load_config('config');
        load_config('functions');
    }

    public static function SetDisplayError(Bool $display){
        self::$display_error = $display;
    }

    public static function GetDisplayError():bool{
        return self::$display_error;
    }

    public static function SetLogError(Bool $log){
        self::$log_error = $log;
    }

    public static function GetLogError():bool{
        return self::$log_error;
    }

    public static function SetTimezone(String $timezone){
        self::$timezone = $timezone;
    }

    public static function GetTimezone():string{
        return self::$timezone;
    }

    public static function SetDateFormat(String $date_format){
        self::$date_format = $date_format;
    }

    public static function GetDateFormat():string{
        return self::$date_format;
    }

    public static function SetErrorPagesPath(String $error_pages_path){
        self::$error_pages_path = $error_pages_path;
    }

    public static function GetErrorPagesPath():string{
        return self::$error_pages_path;
    }

}