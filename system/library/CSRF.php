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

class CSRF
{

    //Start CSRF validation
    public function initialize():void
    {
        $this->setToken();
        $this->setHost();
        $this->setAgent();
    }

    //Validate CSRF Session token, host, and agent.
    public function validate($token, $host, $agent):bool
    {

        $valid = false;

        if($this->checkToken($token) && $this->checkHost($host) && $this->checkAgent($agent))
        {
            $valid = true;
        }

        return $valid;

    }

    //Destroy CSRF data in session
    public function destroy():void
    {

        $_SESSION['csrf_token'] = null;
        $_SESSION['csrf_host'] = null;
        $_SESSION['csrf_agent'] = null;

        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_host']);
        unset($_SESSION['csrf_agent']);

    }

    //Stores token in session
    private function setToken():void
    {
        $_SESSION['csrf_token'] = $this->getToken(15);
    }

    //Stores host in session
    private function setHost():void
    {
        $_SESSION['csrf_host'] = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);;
    }

    //Stores user agent in session
    private function setAgent():void
    {
        $_SESSION['csrf_agent'] = $_SERVER ['HTTP_USER_AGENT'];
    }

    private function checkToken($token):bool
    {

        if($this->isEmpty($_SESSION['csrf_token']) || $this->isEmpty($token))
        {
            return false;
        }

        return $_SESSION['csrf_token'] === $token ? true : false;

    }

    private function checkHost($host):bool
    {

        if($this->isEmpty($_SESSION['csrf_host']) || $this->isEmpty($host))
        {
            return false;
        }

        return $_SESSION['csrf_host'] === $host ? true : false;

    }

    private function checkAgent($agent):bool
    {

        if($this->isEmpty($_SESSION['csrf_agent']) || $this->isEmpty($agent))
        {
            return false;
        }

        return $_SESSION['csrf_agent'] === $agent ? true : false;

    }

    private function isEmpty($var):bool
    {

        if(!isset($var))
        {
            return true;
        }

        if(empty($var) || is_null($var))
        {
            return true;
        }

        return false;

    }


    private function cryptoRandSecure($min, $max):string
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
    
    private function getToken($length):string
    {
        $token = '';
        $code_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code_alphabet.= 'abcdefghijklmnopqrstuvwxyz';
        $code_alphabet.= '0123456789';
        $max = strlen($code_alphabet);
    
        for($i=0; $i < $length; $i++)
        {
            $token .= $code_alphabet[$this->cryptoRandSecure(0, $max-1)];
        }
    
        return $token;
    }


}