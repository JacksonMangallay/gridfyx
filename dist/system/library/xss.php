<?php declare(strict_types=1);

namespace System\Library;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Helpers\Utils;
use Exception;

final class XSS extends Utils{

	/**
	 * 
	 * @param mixed $str
     *
     * @return mixed
     */
    public function clean($str = ''){

        if(empty($str)){
            return false;
        }

        if(is_array($str)){

            foreach(array_keys($str) as $key){
                $str[$key] = self::utils()->remove_bad_strings($str[$key]);
                $str[$key] = self::utils()->remove_invisible_chars($str[$key]);
                $str[$key] = htmlspecialchars($str[$key], ENT_QUOTES, 'UTF-8', true);
            }

            return $str;

        }else{

            $str = self::utils()->remove_bad_strings($str);
            $str = self::utils()->remove_invisible_chars($str);
            $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8', true);
            return $str;
            
        }

    }

}