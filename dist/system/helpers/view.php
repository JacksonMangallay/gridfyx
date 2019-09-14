<?php declare(strict_types = 1);

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