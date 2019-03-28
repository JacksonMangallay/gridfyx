<?php

declare(strict_types=1);

namespace System\Library;

class Lib_Filter_Sanitize{

    public function sanitize_email($var){
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    public function sanitize_encoded($var){
        return filter_var($var, FILTER_SANITIZE_ENCODED);
    }

    public function sanitize_magic_quotes($var){
        return filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
    }

    public function sanitize_number_float($var){
        return filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    public function sanitize_number_int($var){
        return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    }

    public function sanitize_special_chars($var){
        return filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function sanitize_full_special_chars($var){
        return filter_var($var, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function sanitize_string($var){
        return filter_var($var, FILTER_SANITIZE_STRING);
    }

    public function sanitize_stripped($var){
        return filter_var($var, FILTER_SANITIZE_STRIPPED);
    }

    public function sanitize_url($var){
        return filter_var($var, FILTER_SANITIZE_URL);
    }

    public function sanitize_unsafe_raw($var){
        return filter_var($var, FILTER_UNSAFE_RAW);
    }

}