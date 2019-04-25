<?php declare(strict_types=1);

namespace System\Library;

defined('BASEPATH') OR exit('Direct access is forbidden');

class Sanitize
{

    public function email($var):string
    {
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    public function encoded($var):string
    {
        return filter_var($var, FILTER_SANITIZE_ENCODED);
    }

    public function magicQuotes($var):string
    {
        return filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
    }

    public function numberFloat($var):float
    {
        return filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    public function numberInt($var):int
    {
        return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    }

    public function specialChars($var):string
    {
        return filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function fullSpecialChars($var):string
    {
        return filter_var($var, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function string($var):string
    {
        return filter_var($var, FILTER_SANITIZE_STRING);
    }

    public function stripped($var):string
    {
        return filter_var($var, FILTER_SANITIZE_STRIPPED);
    }

    public function url($var):string
    {
        return filter_var($var, FILTER_SANITIZE_URL);
    }

    public function unsafeRaw($var):string
    {
        return filter_var($var, FILTER_UNSAFE_RAW);
    }

}