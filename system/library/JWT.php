<?php declare(strict_types = 1);
/**
 * Gridfyx PHP Framework
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

use \DomainException;
use \InvalidArgumentException;
use \UnexpectedValueException;
use \DateTime;

class JWT
{

    public function decode($jwt, $key = null, $verify = true)
    {

        $tks = explode('.', $jwt);

        if(count($tks) !== 3)
        {
            throw new UnexpectedValueException('Wrong number of segments');
        }

        list($headb64, $payloadb64, $cryptob64) = $tks;

        if(null === ($header = $this->jsonDecode($this->urlSafeB64Decode($headb64))))
        {
            throw new UnexpectedValueException('Invalid segment encoding');
        }

        if(null === $payload = $this->jsonDecode($this->urlSafeB64Decode($payloadb64)))
        {
            throw new UnexpectedValueException('Invalid segment encoding');
        }

        $sig = $this->urlSafeB64Decode($cryptob64);

        if($verify)
        {

            if(empty($header->alg))
            {
                throw new DomainException('Empty algorithm');
            }

            if($sig !== $this->sign("$headb64.$payloadb64", $key, $header->alg))
            {
                throw new UnexpectedValueException('Signature verification failed');
            }
        }

        return $payload;

    }

    public function encode($payload, $key, $algo = 'HS256')
    {

        $header = array('typ' => 'JWT', 'alg' => $algo);
        $segments = array();
        $segments[] = $this->urlSafeB64Encode($this->jsonEncode($header));
        $segments[] = $this->urlSafeB64Encode($this->jsonEncode($payload));
        $signing_input = implode('.', $segments);

        $signature = $this->sign($signing_input, $key, $algo);
        $segments[] = $this->urlSafeB64Encode($signature);

        return implode('.', $segments);

    }

    public function sign($msg, $key, $method = 'HS256')
    {

        $methods = array(
            'HS256' => 'sha256',
            'HS384' => 'sha384',
            'HS512' => 'sha512',
        );

        if(empty($methods[$method]))
        {
            throw new DomainException('Algorithm not supported');
        }

        return hash_hmac($methods[$method], $msg, $key, true);

    }

    public function jsonDecode($input)
    {

        $obj = json_decode($input);

        if(function_exists('json_last_error') && $errno = json_last_error())
        {
            $this->handleJsonError($errno);
        }
        else if($obj === null && $input !== 'null')
        {
            throw new DomainException('Null result with non-null input');
        }

        return $obj;

    }

    public function jsonEncode($input)
    {

        $json = json_encode($input);

        if(function_exists('json_last_error') && $errno = json_last_error())
        {
            $this->handleJsonError($errno);
        }
        else if($json === 'null' && $input !== null)
        {
            throw new DomainException('Null result with non-null input');
        }

        return $json;

    }

    public function urlSafeB64Decode($input)
    {
        
        $remainder = strlen($input) % 4;

        if($remainder)
        {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }

        return base64_decode(strtr($input, '-_', '+/'));

    }

    public function urlSafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    private function handleJsonError($errno)
    {

        $messages = array(
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON'
        );

        throw new DomainException(isset($messages[$errno])
            ? $messages[$errno]
            : 'Unknown JSON error: ' . $errno
        );
    }

}
