<?php
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

declare(strict_types = 1);

namespace System\Core;

load_third_party('Minify');

use Exception;

class Minify{

    public static function css(Array $styles, String $minified_filename){

        if(!is_array($styles)){
            throw new Exception('Stylesheets must be in array.');
        }

        $css = '';

        /*Compress all css files */
        foreach($styles as $file){
    
            $file = file_get_contents(PUB . $file);
            $css .= $file;
    
        }

        /*Remove comments*/
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

        /*Minify all loaded CSS*/
        $minifier = new \MatthiasMullie\Minify\CSS($css);

        /*CSS file absolute path where minified CSS will be saved.*/
        $minified_filename_abspath = PUB . $minified_filename;
        
        /*Save minified CSS into a single file*/
        $minifier->minify($minified_filename_abspath);

    } 

    public static function js(Array $scripts, String $minified_filename){

        if(!is_array($scripts)){
            throw new Exception('Scripts must be in array.');
        }

        $js = '';

        /*Compress all css files */
        foreach($scripts as $file){
    
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

    }

}