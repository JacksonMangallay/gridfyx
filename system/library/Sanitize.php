<?php declare(strict_types=1);
/**
 *---------------------------------------------------------------------------------
 * GRIDFYX PHP FRAMEWORK
 *---------------------------------------------------------------------------------
 *
 * A progressive PHP framework for small to medium scale web applications
 *
 * MIT License
 *
 * Copyright (c) 2019 Jackson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 *
 * @package	Gridfyx PHP Framework
 * @author	Jackson Mangallay
 * @license	MIT License
 * @link	https://github.com/JacksonMangallay/gridfyx
 * @since	Version 1.0.0
 *
 */
namespace System\Library;

defined('BASEPATH') OR exit('Direct access is forbidden');

class Sanitize
{

    public function email($var)
    {
        return filter_var($var, FILTER_SANITIZE_EMAIL);
    }

    public function encoded($var)
    {
        return filter_var($var, FILTER_SANITIZE_ENCODED);
    }

    public function magicQuotes($var)
    {
        return filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
    }

    public function numberFloat($var)
    {
        return filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    public function numberInt($var)
    {
        return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
    }

    public function specialChars($var)
    {
        return filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function fullSpecialChars($var)
    {
        return filter_var($var, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function string($var)
    {
        return filter_var($var, FILTER_SANITIZE_STRING);
    }

    public function stripped($var)
    {
        return filter_var($var, FILTER_SANITIZE_STRIPPED);
    }

    public function url($var)
    {
        return filter_var($var, FILTER_SANITIZE_URL);
    }

    public function unsafeRaw($var)
    {
        return filter_var($var, FILTER_UNSAFE_RAW);
    }

}