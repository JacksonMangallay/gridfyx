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

}