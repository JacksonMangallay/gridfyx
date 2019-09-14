<?php declare(strict_types = 1);
/**
 *---------------------------------------------------------------------------------
 * GRIDFYX PHP FRAMEWORK
 *---------------------------------------------------------------------------------
 *
 * A progressive PHP framework for small to medium scale web applications
 *
 * MIT License
 *
 * Copyright (c) 2019 Jackson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 *
 * @package	Gridfyx PHP Framework
 * @author	Jackson Mangallay
 * @license	MIT License
 * @link	https://github.com/JacksonMangallay/gridfyx
 * @since	Version 1.0.0
 *
 */

defined('BASEPATH') OR exit('Direct access is forbidden');

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
            throw new Exception('Minify: Stylesheets must be in array.');
        }

        if((int)count($styles) < 1){
            throw new Exception('Minify: At least one stylesheet is needed for minification!');
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
            throw new Exception('Minify: Scripts must be in array.');
        }

        if((int)count($scripts) < 1){
            throw new Exception('Minify: At least one script is needed for minification!');
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