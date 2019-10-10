<?php declare(strict_types=1);

namespace System\Library;

defined('BASEPATH') || exit('Direct access is forbidden');

use Exception;

final class Encryption{

    private $key = null;
    private $data = null;
    private $method = 'AES-256-CBC';
    private $options = 0;

	/**
	 * 
     * @param string $key
     * @param string $data
     * 
     * @return mixed
     */
    public function encrypt($key = '', $data = ''){

        if(is_empty($key) && is_empty($data)){
            return false;
        }

        $this->key = $key;
        $this->data = $data;

        if(!$this->validate_data()){
            throw new UnexpectedValueException();
        }

        $str = openssl_encrypt($this->data, $this->method, $this->key, $this->options, $this->getIV());

        if(is_bool($str)){
            return false;
        }

        return trim($str);

    }

	/**
	 * 
     * @param string $key
     * @param string $data
     * 
     * @return mixed
     */
    public function decrypt($key = '', $data = ''){

        if(is_empty($key) && is_empty($data)){
            return false;
        }

        $this->key = $key;
        $this->data = $data;

        if(!$this->validate_data()){
            throw new UnexpectedValueException();
        }

        $str = openssl_decrypt($this->data, $this->method, $this->key, $this->options, $this->getIV());

        if(is_bool($str)){
            return false;
        }

        return trim($str);

    }

	/**
	 * 
     * @return bool
     */
    private function validate_data(){
        return $this->data !== null ? true : false;
    }

	/**
	 * 
     * @return string
     */
    private function getIV(){
        return chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    }

}