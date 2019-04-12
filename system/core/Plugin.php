<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

class Plugin{
    
    private static $plugin = [];
    private static $plugin_path = BASEPATH . DS . 'system' . DS . 'plugin';

    public static function initialize(){

        load_config('plugins');

        foreach(self::$plugin as $plugin){
            require_once($plugin);
        }

    }

    public static function extend(String $plugin){

        $plugin_index = self::$plugin_path . DS . $plugin . DS . 'index.php';

        if(!file_exists($plugin_index)){
            throw new Exception('Plugin does not exist.');
        }

        array_push(self::$plugin, $plugin_index);

    }

}