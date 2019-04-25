<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use Exception;

class Plugin
{
    
    private static $plugin = [];
    private static $plugin_path = BASEPATH . DS . 'application' . DS . 'plugin';

    public static function initialize():void
    {

        load_config('plugins');

        foreach(self::$plugin as $plugin)
        {
            require_once($plugin);
        }

    }

    public static function extend(String $plugin):void
    {

        $plugin_index = self::$plugin_path . DS . $plugin . DS . 'index.php';

        if(!file_exists($plugin_index))
        {
            throw new Exception('Plugin does not exist.');
        }

        array_push(self::$plugin, $plugin_index);

    }

}