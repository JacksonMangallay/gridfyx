<?php declare(strict_types=1);
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
 * @since	Version 1.0.0
 *
 */
namespace System\Library;

defined('BASEPATH') OR exit('Direct access is forbidden');

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
            throw new Exception('Invalid data parameter!');
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
            throw new Exception('Invalid data parameter!');
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