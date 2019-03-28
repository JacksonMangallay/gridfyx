<?php

declare(strict_types = 1);

namespace System\Library;

class Lib_Session{

    public function set_data($data, $value = NULL){

        if(is_array($data)){

            foreach($data as $key => $value){
                $_SESSION[$key] = $value;
            }

            return true;

        }

        $_SESSION[$data] = $value;
    }

    public function unset_data($data){

        if(is_array($data)){

            foreach($data as $key){
                unset($_SESSION[$key]);
            }

            return true;

        }

        unset($_SESSION[$data]);

    }

}