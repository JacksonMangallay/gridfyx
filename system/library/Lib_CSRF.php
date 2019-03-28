<?php

declare(strict_types=1);

namespace System\Library;

class Lib_CSRF{

    //Start CSRF validation
    public function initialize_csrf(){
        $this->set_token();
        $this->set_host();
        $this->set_agent();
    }

    //Validate CSRF Session token, host, and agent.
    public function validate_csrf($token, $host, $agent){

        $valid = false;

        if($this->check_token($token) && $this->check_host($host) && $this->check_agent($agent)){
            $valid = true;
        }

        return $valid;

    }

    //Destroy CSRF data in session
    public function destroy_csrf(){

        $_SESSION['csrf_token'] = null;
        $_SESSION['csrf_host'] = null;
        $_SESSION['csrf_agent'] = null;

        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_host']);
        unset($_SESSION['csrf_agent']);

    }

    //Stores token in session
    private function set_token(){
        $_SESSION['csrf_token'] = $this->get_token(15);
    }

    //Stores host in session
    private function set_host(){
        $_SESSION['csrf_host'] = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);;
    }

    //Stores user agent in session
    private function set_agent(){
        $_SESSION['csrf_agent'] = $_SERVER ['HTTP_USER_AGENT'];
    }

    private function check_token($token){

        if($this->is_empty($_SESSION['csrf_token']) || $this->is_empty($token)){
            return false;
        }

        return $_SESSION['csrf_token'] === $token ? true : false;

    }

    private function check_host($host){

        if($this->is_empty($_SESSION['csrf_host']) || $this->is_empty($host)){
            return false;
        }

        return $_SESSION['csrf_host'] === $host ? true : false;

    }

    private function check_agent($agent){

        if($this->is_empty($_SESSION['csrf_agent']) || $this->is_empty($agent)){
            return false;
        }

        return $_SESSION['csrf_agent'] === $agent ? true : false;

    }

    private function is_empty($var){

        if(!isset($var)){
            return true;
        }

        if(empty($var) || is_null($var)){
            return true;
        }

        return false;

    }


    private function crypto_rand_secure($min, $max){

        $range = $max - $min;

        if($range < 1){
            return $min;
        }

        $log = ceil(log($range, 2));
        $bytes = (int)($log / 8) + 1;
        $bits = (int)$log + 1;
        $filter = (int)(1 << $bits) - 1;

        do{
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        }while($rnd > $range);

        return $min + $rnd;

    }
    
    private function get_token($length){
        $token = '';
        $code_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code_alphabet.= 'abcdefghijklmnopqrstuvwxyz';
        $code_alphabet.= '0123456789';
        $max = strlen($code_alphabet);
    
        for($i=0; $i < $length; $i++){
            $token .= $code_alphabet[$this->crypto_rand_secure(0, $max-1)];
        }
    
        return $token;
    }


}