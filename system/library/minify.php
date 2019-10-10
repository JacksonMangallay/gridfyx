<?php declare(strict_types = 1);

defined('BASEPATH') || exit('Direct access is forbidden');

\System\Core\third_party('Minify');

use System\Core\Config;

class Minify extends Config{

    private static $enabled = false;

	/**
     * 
     * @return void
     */
    public static function initialize(){
        self::config()->load('minify');
    }

	/**
	 * 
     * @param bool $minify
     *
     * @return void 
     */
    public static function enable($minify = false){
        self::$enabled = $minify;
    }

	/**
	 * 
     * @param array $styles
     * @param string $minified_filename
     *
     * @return mixed
     */
    public static function css($styles = array(), $minified_filename = ''){

        //Check if minification is enabled
        if(self::$enabled === false){
            return false;
        }

        if(!is_array($styles)){
            throw new InvalidArgumentException('Minify: Stylesheets must be in array!');
        }

        if((int)count($styles) < 1){
            throw new InvalidArgumentException('Minify: At least one stylesheet is needed for minification!');
        }

        $css = '';

        //Compress files
        foreach($styles as $file){
            $file = file_get_contents(DIR_PUBLIC . $file);
            $css .= $file;
        }

        //Minify stylesheets
        $minifier = new \MatthiasMullie\Minify\CSS($css);

        //CSS output file
        $minified_filename_abspath = DIR_PUBLIC . $minified_filename;
        
        //Save CSS output file
        $minified = $minifier->minify($minified_filename_abspath);

    } 

	/**
	 * 
     * @param array $scripts
     * @param string $minified_filename
     *
     * @return mixed
     */
    public static function js($scripts = array(), $minified_filename = ''){

        //Check if minification is enabled
        if(self::$enabled === false){
            return false;
        }

        if(!is_array($scripts)){
            throw new InvalidArgumentException('Minify: Scripts must be in array!');
        }

        if((int)count($scripts) < 1){
            throw new InvalidArgumentException('Minify: At least one script is needed for minification!');
        }
        
        $js = '';

        //Compress files
        foreach($scripts as $file){
            $file = file_get_contents(DIR_PUBLIC . $file);
            $js .= $file;
        }

        //Minify scripts
        $minifier = new \MatthiasMullie\Minify\JS($js);

        //JS output file
        $minified_filename_abspath = DIR_PUBLIC . $minified_filename;
        
        //Save CSS output file
        $minifier->minify($minified_filename_abspath);

    }

}