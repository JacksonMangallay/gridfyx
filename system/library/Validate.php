<?php

declare(strict_types=1);

namespace System\Library;

class Validate{

    public function Boolean($var){
        return filter_var($var, FILTER_VALIDATE_BOOLEAN);
    }

    public function Domain($var){
        return filter_var($var, FILTER_VALIDATE_DOMAIN);
    }

    public function Email($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    public function Float($var){
        return filter_var($var, FILTER_VALIDATE_FLOAT);
    }

    public function Int($var){
        return filter_var($var, FILTER_VALIDATE_INT);
    }
    
    public function IP($var){
        return filter_var($var, FILTER_VALIDATE_IP);
    }

    public function Mac($var){
        return filter_var($var, FILTER_VALIDATE_MAC);
    }

    public function Regexp($var){
        return filter_var($var, FILTER_VALIDATE_REGEXP);
    }

    public function Url($var){
        return filter_var($var, FILTER_VALIDATE_URL);
    }

}