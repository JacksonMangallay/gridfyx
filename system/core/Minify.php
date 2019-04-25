<?php declare(strict_types = 1);
/*
*---------------------------------------------------------------
* ACKNOWLEDGEMENT
*---------------------------------------------------------------
* This core file uses Matthias Mullie's Minify
*
* @ https://www.minifier.org/
* @ https://github.com/matthiasmullie/minify
*
* Downloaded at:
* @ https://php-download.com/package/matthiasmullie/minify
*
*/

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

load_third_party('Minify');

use Exception;

class Minify
{

    protected static $minify;

    public static function initialize():void
    {
        load_config('minify');
    }

    public static function run($run = FALSE):void
    {
        self::$minify = $run;
    }

    public static function css(Array $styles, String $minified_filename):bool
    {

        if(!is_array($styles))
        {
            throw new Exception('Stylesheets must be in array.');
        }

        /*Disable minify*/
        if(self::$minify === FALSE)
        {
            return true;
        }

        $css = '';

        /*Compress all css files */
        foreach($styles as $file)
        {
    
            $file = file_get_contents(PUB . $file);
            $css .= $file;
    
        }

        /*Minify all loaded CSS*/
        $minifier = new \MatthiasMullie\Minify\CSS($css);

        /*CSS file absolute path where minified CSS will be saved.*/
        $minified_filename_abspath = PUB . $minified_filename;
        
        /*Save minified CSS into a single file*/
        $minified = $minifier->minify($minified_filename_abspath);

        return TRUE;

    } 

    public static function js(Array $scripts, String $minified_filename):bool
    {

        if(!is_array($scripts))
        {
            throw new Exception('Scripts must be in array.');
        }

        /*Disable minify*/
        if(self::$minify === FALSE)
        {
            return true;
        }

        $js = '';

        /*Compress all css files */
        foreach($scripts as $file)
        {
    
            $file = file_get_contents(PUB . $file);
            $js .= $file;
    
        }

        /*Remove comments*/
        $js = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $js);

        /*Minify all loaded JS*/
        $minifier = new \MatthiasMullie\Minify\JS($js);

        /*JS file absolute path where minified JS will be saved.*/
        $minified_filename_abspath = PUB . $minified_filename;
        
        /*Save minified JS into a single file*/
        $minifier->minify($minified_filename_abspath);

        return TRUE;

    }

}