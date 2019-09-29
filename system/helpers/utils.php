<?php declare(strict_types = 1);

namespace System\Helpers;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Helpers\IP;

class Utils{

    private $bad_chars = array(
        '&', '&amp;', '<', '&lt;',
        'lt;', '>', '&gt;', 'gt;', '"',
        '&quot;', 'quot;', "'", '&#x27;',
        '#x27;', '/', '&#x2F;', '#x2F;'
    );

    private $bad_names = array(
        'script', 'javascript', 'expression',
        'vbscript', 'jscript', 'wscript',
        'vbs', 'base64', 'applet', 'alert', 'document',
        'write', 'cookie', 'window', 'confirm',
        'prompt', 'eval', 'exec'
    );

    private static $instance = null;

    public function __construct(){
        self::$instance = $this;
    }

    public static function utils(){
        return self::$instance;
    }

    final protected function ip_address(){
        return (new IP())->generate_new();
    }

	/**
	 * 
     * @param string $str
     * 
     * @return string
     */
    final protected function remove_bad_strings($str = ''){

        foreach($this->bad_chars as $bad){
            $str = str_replace($bad,'',$str);
        }

        foreach($this->bad_names as $bad){
            $str = str_replace($bad,'',$str);
        }

        return $str;

    }

	/**
	 * 
     * @param string $str
     * 
     * @return string
     */
    final protected function remove_invisible_chars($str = ''){

        $invisibles = array(
            '/%0[0-8bcef]/i',
            '/%1[0-9a-f]/i',
            '/%7f/i',
            '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S'
        );

        do{
            $str = preg_replace($invisibles, '', $str, -1, $ctr);
        }while($ctr);

        return $str;
        
    }

	/**
	 * 
     * @param int $length
     * 
     * @return string
     */
    final protected function random_string($length = 5){

        $str = '';
        $code_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code_alphabet.= 'abcdefghijklmnopqrstuvwxyz';
        $code_alphabet.= '0123456789';
        $max = strlen($code_alphabet);
    
        for($i = 0; $i < $length; $i++){
            $str .= $code_alphabet[$this->crypto_random(0, $max-1)];
        }
    
        return $str;
    }

	/**
	 * 
     * @param string $min
     * @param mixed $max
     * 
     * @return int
     */
    private function crypto_random($min = 5, $max = 10){

        $range = $max - $min;

        if($range < 1){
            return $min;
        }

        $log = ceil(log($range, 2));
        $bytes = (int)($log / 8) + 1;
        $bits = (int)$log + 1;
        $filter = (int)(1 << $bits) - 1;

        do{

            $rand = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rand = $rand & $filter;

        }while($rand > $range);

        return $min + $rand;

    }

}