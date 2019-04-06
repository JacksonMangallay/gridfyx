<?php

declare(strict_types=1);

namespace System\Library;

use Exception;

class Encrypt{

    private $username;
    private $password;
    private $method = 'AES-256-CBC';
    private $options = 0;

    public function SetUsername(String $username){
        $this->username = $username;
    }

    public function SetPassword(String $password){
        $this->password = $password;
    }

    public function SetMethod(String $method){
        $this->method = $method;
    }

    public function Encrypt():string{

        if(!$this->ValidateData()){
            throw new Exception('Invalid data parameter!');
        }

        return trim(openssl_encrypt($this->password, $this->method, $this->username, $this->options, $this->GetIV()));

    }

    public function Decrypt(){

        if(!$this->ValidateData()){
            throw new Exception('Invalid data parameter!');
        }

        return trim(openssl_decrypt($this->password, $this->method, $this->username, $this->options, $this->GetIV()));

    }

    private function ValidateData():bool{
        return $this->password !== null ? true:false;
    }

    private function GetIV():string{
        return chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
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
    
    public function RandomString($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);
    
        for($i=0; $i < $length; $i++){
            $token .= $codeAlphabet[$this->CryptoRandSecure(0, $max-1)];
        }
    
        return $token;
    }

}