<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

class Util{

    public static function loadCSS(Array $stylesheets){

        if(!is_array($stylesheets)){
            throw new Exception('Stylesheets must be in array.');
        }

        $css_loaded = '';

        foreach($stylesheets as $file){
    
            $file = file_get_contents(PUB . $file);
            $css_loaded .= $file;
    
        }
    
        $css_loaded = self::removeAllSpaces($css_loaded);
        $css_loaded = self::removeComments($css_loaded);

        echo '<style type="text/css">' . $css_loaded . '</style>';

    }

    public static function removeAllSpaces(String $str){
        return preg_replace('/\s+/', '', $str);
    }

    public static function removeComments(String $str){

        $str = preg_replace('!/\*.*?\*/!s', '', $str);
        $str = preg_replace('/\n\s*\n/', "\n", $str);

        return $str;
        
    }

}