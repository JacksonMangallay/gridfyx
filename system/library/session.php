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
 * @since	Version 2.0.0
 *
 */
namespace System\Library;

defined('BASEPATH') OR exit('Direct access is forbidden');

use Exception;

final class Session{

	/**
	 * 
     * @param string $key
     * @param mixed $value
	 * 
     */
    public function set_data($key = '', $value = ''){

        if(session_status() == PHP_SESSION_NONE){
            return false;
        }

        if(is_empty($key) && is_empty($value)){
            return false;
        }

        $_SESSION[$key] = $value;
    }

	/**
	 * 
     * @param string $key
     *
     * @return mixed
     */
    public function get_data($key = ''){
        
        if(session_status() == PHP_SESSION_NONE){
            return false;
        }

        if(!$this->check_data($key)){
            return false;
        }

        return $_SESSION[$key];

    }

	/**
	 * 
     * @param string $key
     * 
     * @return bool
     */
    public function unset_data($key = ''){

        if(session_status() == PHP_SESSION_NONE){
            return false;
        }

        if(!$this->check_data($key)){
            return false;
        }

        $_SESSION[$key] = null;
        unset($_SESSION[$key]);

    }

	/**
	 * 
	 * @return bool
     */
    public function destroy_session(){

        if(session_status() == PHP_SESSION_NONE){
            return false;
        }

        $_SESSION = null;

        if(ini_get('session.use_cookies')){

            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        
        }
        
        unset($_SESSION);
        session_destroy();

    }

	/**
     * 
     * @param string $key
     *
	 * @return bool
     */
    private function check_data($key = ''){

        if(is_empty($key)){
            return false;
        }

        return true;

    }

}