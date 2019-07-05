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
namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

load_third_party('Minify');

use Exception;

class Minify
{

    private static $enabled = TRUE;

    public static function initialize()
    {
        load_config('minify');
    }

    public static function enable(Bool $minify = TRUE)
    {
        self::$enabled = $minify;
    }

    public static function css(Array $styles, String $minified_filename)
    {

        if(!is_array($styles))
        {
            throw new Exception('Stylesheets must be in array.');
        }

        /*Disable minify*/
        if(self::$enabled === FALSE)
        {
            return FALSE;
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

    public static function js(Array $scripts, String $minified_filename)
    {

        if(!is_array($scripts))
        {
            throw new Exception('Scripts must be in array.');
        }

        /*Disable minify*/
        if(self::$enabled === FALSE)
        {
            return FALSE;
        }

        $js = '';

        /*Compress all css files */
        foreach($scripts as $file)
        {
            $file = file_get_contents(PUB . $file);
            $js .= $file;
        }

        /*Minify all loaded JS*/
        $minifier = new \MatthiasMullie\Minify\JS($js);

        /*JS file absolute path where minified JS will be saved.*/
        $minified_filename_abspath = PUB . $minified_filename;
        
        /*Save minified JS into a single file*/
        $minifier->minify($minified_filename_abspath);

        return TRUE;

    }

}