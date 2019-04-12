<?php

declare(strict_types=1);

namespace System\Library;

use Exception;

class Encrypt{

    private $username;
    private $password;
    private $method = 'AES-256-CBC';
    private $options = 0;

    public function setUsername(String $username){
        $this->username = $username;
    }

    public function setPassword(String $password){
        $this->password = $password;
    }

    public function setMethod(String $method){
        $this->method = $method;
    }

    public function encrypt():string{

        if(!$this->validateData()){
            throw new Exception('Invalid data parameter!');
        }

        return trim(openssl_encrypt($this->password, $this->method, $this->username, $this->options, $this->getIV()));

    }

    public function decrypt(){

        if(!$this->validateData()){
            throw new Exception('Invalid data parameter!');
        }

        return trim(openssl_decrypt($this->password, $this->method, $this->username, $this->options, $this->getIV()));

    }

    private function validateData():bool{
        return $this->password !== null ? true:false;
    }

    private function getIV():string{
        return chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    }

    private function cryptoRandSecure($min, $max){

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
    
    public function randomString($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);
    
        for($i=0; $i < $length; $i++){
            $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max-1)];
        }
    
        return $token;
    }

}