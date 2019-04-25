<?php declare(strict_types=1);

namespace System\Library;

defined('BASEPATH') OR exit('Direct access is forbidden');

class Validate
{

    public function boolean($var)
    {
        return filter_var($var, FILTER_VALIDATE_BOOLEAN);
    }

    public function domain($var)
    {
        return filter_var($var, FILTER_VALIDATE_DOMAIN);
    }

    public function email($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    public function float($var)
    {
        return filter_var($var, FILTER_VALIDATE_FLOAT);
    }

    public function int($var)
    {
        return filter_var($var, FILTER_VALIDATE_INT);
    }
    
    public function ip($var)
    {
        return filter_var($var, FILTER_VALIDATE_IP);
    }

    public function mac($var)
    {
        return filter_var($var, FILTER_VALIDATE_MAC);
    }

    public function regexp($var)
    {
        return filter_var($var, FILTER_VALIDATE_REGEXP);
    }

    public function url($var)
    {
        return filter_var($var, FILTER_VALIDATE_URL);
    }

}