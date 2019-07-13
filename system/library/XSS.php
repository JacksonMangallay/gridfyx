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

class XSS
{

    private $bad_chars = array(
        '&', '&amp;', '<', '&lt;',
        'lt;', '>', '&gt;', 'gt;', '"',
        '&quot;', 'quot;', "'", '&#x27;',
        '#x27;', '/', '&#x2F;', '#x2F;'
    );

    private $bad_names = array(
        'script', 'javascript', 'expression',
        'vbscript', 'jscript', 'wscript',
        'vbs', 'base64', 'applet', 'alert', 'document',
        'write', 'cookie', 'window', 'confirm',
        'prompt', 'eval', 'exec'
    );

    public function clean($str = '')
    {

        if(empty($str))
        {
            return false;
        }

        if(is_array($str))
        {

            foreach(array_keys($str) as $key)
            {
                $str[$key] = $this->removeBadStrings($str[$key]);
                $str[$key] = $this->removeInvisibleChars($str[$key]);
                $str[$key] = htmlspecialchars($str[$key], ENT_QUOTES, 'UTF-8', true);
            }

            return $str;

        }
        else
        {

            $str = $this->removeBadStrings($str);
            $str = $this->removeInvisibleChars($str);
            $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8', true);
            return $str;
            
        }

    }

    private function removeBadStrings(String $str)
    {

        foreach($this->bad_chars as $bad)
        {
            $str = str_replace($bad,'',$str);
        }

        foreach($this->bad_names as $bad)
        {
            $str = str_replace($bad,'',$str);
        }

        return $str;

    }

    private function removeInvisibleChars(String $str)
    {

        $invisibles = array(
            '/%0[0-8bcef]/i',
            '/%1[0-9a-f]/i',
            '/%7f/i',
            '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S'
        );

        do
        {
            $str = preg_replace($invisibles, '', $str, -1, $ctr);
        }
        while($ctr);

        return $str;
        
    }

}