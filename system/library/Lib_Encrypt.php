<?php

declare(strict_types=1);

namespace System\Library;

use Exception;

class Lib_Encrypt{

    private $username;
    private $password;
    private $method = 'AES-256-CBC';
    private $options = 0;

    public function set_username(String $username){
        $this->username = $username;
    }

    public function set_password(String $password){
        $this->password = $password;
    }

    public function set_method(String $method){
        $this->method = $method;
    }

    public function encrypt():string{

        if(!$this->validate_data()){
            throw new Exception('Invalid data parameter!');
        }

        return trim(openssl_encrypt($this->password, $this->method, $this->username, $this->options, $this->get_iv()));

    }

    public function decrypt(){

        if(!$this->validate_data()){
            throw new Exception('Invalid data parameter!');
        }

        return trim(openssl_decrypt($this->password, $this->method, $this->username, $this->options, $this->get_iv()));

    }

    private function validate_data():bool{
        return $this->password !== null ? true:false;
    }

    private function get_iv():string{
        return chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    }

}