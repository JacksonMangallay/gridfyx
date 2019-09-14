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
 * @since	Version 2.0.0
 *
 */

namespace System\Helpers;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Library\CSRF;
use Exception;

class View{

    public $view = null;
    private $encoding = null;

    public function __construct(){
        (new CSRF())->initialize();
        $this->view = $this;
    }

	/**
	 * 
     * @param string $view
     * @param mixed $params
     * 
     */
    final public function render($view, $params = ''){

        if(is_empty($view)){
            throw new Exception('Unable to render undefined view file!');
        }

        $file = DIR_VIEWS . '/' . $view . '.php';

        if(!file_exists($file)){
            throw new Exception('Unable to render non-existing view file!');
        }

        ob_start();
        require_once($file);
        $output = ob_get_contents();
        $output = $this->minify_output($output);
        ob_end_clean();
        
        echo $this->output($output);

    }

	/**
	 * 
     * @param string $output
     * 
     * @return string
     */
    private function output($output = ''){

        $encoding = $this->set_encoding();

        if(is_empty($encoding)){
            return $output;
        }

		if(!extension_loaded('zlib') || ini_get('zlib.output_compression')){
            return $output;
        }

        header('Content-Encoding: ' . $encoding);
        return gzencode($output, 5);

    }

	/**
	 * 
     * @return string
     */
    private function set_encoding(){

        $encoding = '';

		if(isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)){
			$encoding = 'gzip';
		}

		if(isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)){
			$encoding = 'x-gzip';
        }

        return $encoding;
        
    }

	/**
	 * 
     * @param string $output
     * 
     * @return string
     */
    private function minify_output($output = ''){

        if(is_empty($output)){
            return false;
        }

        $search = array(
            '/(\n|^)(\x20+|\t)/',
            '/(\n|^)\/\/(.*?)(\n|$)/',
            '/\n/',
            '/\<\!--.*?-->/',
            '/(\x20+|\t)/',
            '/\>\s+\</',
            '/(\"|\')\s+\>/',
            '/=\s+(\"|\')/'
        );

        $replace = array(
            "\n","\n"," ",
            ""," ","><","$1>",
            "=$1"
        );
        
        return preg_replace($search, $replace, $output);

    }

}