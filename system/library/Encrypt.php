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

class Encrypt
{

    private $username;
    private $password;
    private $method = 'AES-256-CBC';
    private $options = 0;

    public function setUsername(String $username)
    {
        $this->username = $username;
    }

    public function setPassword(String $password)
    {
        $this->password = $password;
    }

    public function setMethod(String $method)
    {
        $this->method = $method;
    }

    public function encrypt()
    {

        if(!$this->validateData())
        {
            throw new Exception('Invalid data parameter!');
        }

        return trim(openssl_encrypt($this->password, $this->method, $this->username, $this->options, $this->getIV()));

    }

    public function decrypt()
    {

        if(!$this->validateData())
        {
            throw new Exception('Invalid data parameter!');
        }

        return trim(openssl_decrypt($this->password, $this->method, $this->username, $this->options, $this->getIV()));

    }

    private function validateData()
    {
        return $this->password !== null ? true:false;
    }

    private function getIV()
    {
        return chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    }

    private function cryptoRandSecure($min, $max)
    {

        $range = $max - $min;

        if($range < 1)
        {
            return $min;
        }

        $log = ceil(log($range, 2));
        $bytes = (int)($log / 8) + 1;
        $bits = (int)$log + 1;
        $filter = (int)(1 << $bits) - 1;

        do
        {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        }
        while($rnd > $range);

        return $min + $rnd;

    }
    
    public function randomString($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);
    
        for($i=0; $i < $length; $i++)
        {
            $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max-1)];
        }
    
        return $token;
    }

}