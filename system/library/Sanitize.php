<?php

declare(strict_types=1);

namespace System\Library;

class Sanitize{

    public function email($var){
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    public function encoded($var){
        return filter_var($var, FILTER_SANITIZE_ENCODED);
    }

    public function magicQuotes($var){
        return filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
    }

    public function numberFloat($var){
        return filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    public function numberInt($var){
        return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    }

    public function specialChars($var){
        return filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function fullSpecialChars($var){
        return filter_var($var, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function string($var){
        return filter_var($var, FILTER_SANITIZE_STRING);
    }

    public function stripped($var){
        return filter_var($var, FILTER_SANITIZE_STRIPPED);
    }

    public function url($var){
        return filter_var($var, FILTER_SANITIZE_URL);
    }

    public function unsafeRaw($var){
        return filter_var($var, FILTER_UNSAFE_RAW);
    }

}