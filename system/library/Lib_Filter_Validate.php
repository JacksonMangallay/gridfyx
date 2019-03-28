<?php

declare(strict_types=1);

namespace System\Library;

class Lib_Filter_Validate{

    public function validate_boolean($var){
        return filter_var($var, FILTER_VALIDATE_BOOLEAN);
    }

    public function validate_domain($var){
        return filter_var($var, FILTER_VALIDATE_DOMAIN);
    }

    public function validate_email($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    public function validate_float($var){
        return filter_var($var, FILTER_VALIDATE_FLOAT);
    }

    public function validate_int($var){
        return filter_var($var, FILTER_VALIDATE_INT);
    }
    
    public function validate_ip($var){
        return filter_var($var, FILTER_VALIDATE_IP);
    }

    public function validate_mac($var){
        return filter_var($var, FILTER_VALIDATE_MAC);
    }

    public function validate_regexp($var){
        return filter_var($var, FILTER_VALIDATE_REGEXP);
    }

    public function validate_url($var){
        return filter_var($var, FILTER_VALIDATE_URL);
    }

}