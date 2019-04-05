<?php

declare(strict_types=1);

namespace System\Library;

class Sanitize{

    public function Email($var){
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    public function Encoded($var){
        return filter_var($var, FILTER_SANITIZE_ENCODED);
    }

    public function MagicQuotes($var){
        return filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
    }

    public function NumberFloat($var){
        return filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    public function NumberInt($var){
        return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    }

    public function SpecialChars($var){
        return filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function FullSpecialChars($var){
        return filter_var($var, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function String($var){
        return filter_var($var, FILTER_SANITIZE_STRING);
    }

    public function Stripped($var){
        return filter_var($var, FILTER_SANITIZE_STRIPPED);
    }

    public function Url($var){
        return filter_var($var, FILTER_SANITIZE_URL);
    }

    public function UnsafeRaw($var){
        return filter_var($var, FILTER_UNSAFE_RAW);
    }

}