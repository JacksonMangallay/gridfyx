<?php declare(strict_types=1);

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

        if(is_empty($_SESSION[$key])){
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