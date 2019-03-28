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

    public static function set_display_error(Bool $display){
        self::$display_error = $display;
    }

    public static function get_display_error():bool{
        return self::$display_error;
    }

    public static function set_log_error(Bool $log){
        self::$log_error = $log;
    }

    public static function get_log_error():bool{
        return self::$log_error;
    }

    public static function set_timezone(String $timezone){
        self::$timezone = $timezone;
    }

    public static function get_timezone():string{
        return self::$timezone;
    }

    public static function set_date_format(String $date_format){
        self::$date_format = $date_format;
    }

    public static function get_date_format():string{
        return self::$date_format;
    }

    public static function set_error_pages_path(String $error_pages_path){
        self::$error_pages_path = $error_pages_path;
    }

    public static function get_error_pages_path():string{
        return self::$error_pages_path;
    }

}