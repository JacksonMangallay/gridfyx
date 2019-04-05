<?php

declare(strict_types=1);

namespace System\Library;

class CSRF{

    //Start CSRF validation
    public function Initialize(){
        $this->SetToken();
        $this->SetHost();
        $this->SetAgent();
    }

    //Validate CSRF Session token, host, and agent.
    public function Validate($token, $host, $agent){

        $valid = false;

        if($this->CheckToken($token) && $this->CheckHost($host) && $this->CheckAgent($agent)){
            $valid = true;
        }

        return $valid;

    }

    //Destroy CSRF data in session
    public function Destroy(){

        $_SESSION['csrf_token'] = null;
        $_SESSION['csrf_host'] = null;
        $_SESSION['csrf_agent'] = null;

        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_host']);
        unset($_SESSION['csrf_agent']);

    }

    //Stores token in session
    private function SetToken(){
        $_SESSION['csrf_token'] = $this->GetToken(15);
    }

    //Stores host in session
    private function SetHost(){
        $_SESSION['csrf_host'] = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);;
    }

    //Stores user agent in session
    private function SetAgent(){
        $_SESSION['csrf_agent'] = $_SERVER ['HTTP_USER_AGENT'];
    }

    private function CheckToken($token){

        if($this->IsEmpty($_SESSION['csrf_token']) || $this->IsEmpty($token)){
            return false;
        }

        return $_SESSION['csrf_token'] === $token ? true : false;

    }

    private function CheckHost($host){

        if($this->IsEmpty($_SESSION['csrf_host']) || $this->IsEmpty($host)){
            return false;
        }

        return $_SESSION['csrf_host'] === $host ? true : false;

    }

    private function CheckAgent($agent){

        if($this->IsEmpty($_SESSION['csrf_agent']) || $this->IsEmpty($agent)){
            return false;
        }

        return $_SESSION['csrf_agent'] === $agent ? true : false;

    }

    private function IsEmpty($var){

        if(!isset($var)){
            return true;
        }

        if(empty($var) || is_null($var)){
            return true;
        }

        return false;

    }


    private function CryptoRandSecure($min, $max){

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
    
    private function GetToken($length){
        $token = '';
        $code_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code_alphabet.= 'abcdefghijklmnopqrstuvwxyz';
        $code_alphabet.= '0123456789';
        $max = strlen($code_alphabet);
    
        for($i=0; $i < $length; $i++){
            $token .= $code_alphabet[$this->CryptoRandSecure(0, $max-1)];
        }
    
        return $token;
    }


}