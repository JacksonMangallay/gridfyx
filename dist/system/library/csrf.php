<?php declare(strict_types=1);

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