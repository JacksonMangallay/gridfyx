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

use System\Helpers\Utils;
use Exception;

final class CSRF extends Utils{

	/**
     * 
     * @return void
     */
    public function initialize(){

        if(session_status() !== 1){
            $_SESSION['csrf_token'] = $this->generate_token();
            $_SESSION['csrf_ip'] = $this->generate_ip();
        }else{
            $_SESSION['csrf_token'] = null;
            $_SESSION['csrf_ip'] = null;
        }

    }

	/**
	 * 
     * @param string $token
     * 
     * @return bool
     */
    public function validate($token = ''){

        if(!$this->isset_csrf()){
            return false;
        }

        if(is_empty($token)){
            return false;
        }

        if($token !== $_SESSION['csrf_token']){
            return false;
        }else if($_SESSION['csrf_ip'] !== $this->generate_ip()){
            return false;
        }

        return true;

    }

	/**
     * 
     * @return bool
     */
    private function isset_csrf(){

        if(session_status() === 1){
            return false;
        }

        if(!isset($_SESSION['csrf_token'])){
            return false;
        }else if(!isset($_SESSION['csrf_ip'])){
            return false;
        }else if(is_empty($_SESSION['csrf_token'])){
            return false;
        }else if(is_empty($_SESSION['csrf_ip'])){
            return false;
        }else{
            return true;
        }

    }

	/**
	 * 
     * @return string
     */
    private function generate_token(){
        return self::utils()->random_string(25);
    }

	/**
	 * 
     * @return string
     */
    private function generate_ip(){
        return self::utils()->ip_address();
    }

}