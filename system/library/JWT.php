<?php

declare(strict_types = 1);

namespace System\Library;

use \DomainException;
use \InvalidArgumentException;
use \UnexpectedValueException;
use \DateTime;

class JWT{

    public function Decode($jwt, $key = null, $verify = true){

        $tks = explode('.', $jwt);

        if(count($tks) !== 3){
            throw new UnexpectedValueException('Wrong number of segments');
        }

        list($headb64, $payloadb64, $cryptob64) = $tks;

        if(null === ($header = $this->JsonDecode($this->UrlSafeB64Decode($headb64)))){
            throw new UnexpectedValueException('Invalid segment encoding');
        }

        if(null === $payload = $this->JsonDecode($this->UrlSafeB64Decode($payloadb64))){
            throw new UnexpectedValueException('Invalid segment encoding');
        }

        $sig = $this->UrlSafeB64Decode($cryptob64);

        if($verify){

            if(empty($header->alg)){
                throw new DomainException('Empty algorithm');
            }

            if($sig !== $this->Sign("$headb64.$payloadb64", $key, $header->alg)){
                throw new UnexpectedValueException('Signature verification failed');
            }
        }

        return $payload;

    }

    public function Encode($payload, $key, $algo = 'HS256'){

        $header = array('typ' => 'JWT', 'alg' => $algo);
        $segments = array();
        $segments[] = $this->UrlSafeB64Encode($this->JsonEncode($header));
        $segments[] = $this->UrlSafeB64Encode($this->JsonEncode($payload));
        $signing_input = implode('.', $segments);

        $signature = $this->Sign($signing_input, $key, $algo);
        $segments[] = $this->UrlSafeB64Encode($signature);

        return implode('.', $segments);

    }

    public function Sign($msg, $key, $method = 'HS256'){

        $methods = array(
            'HS256' => 'sha256',
            'HS384' => 'sha384',
            'HS512' => 'sha512',
        );

        if(empty($methods[$method])){
            throw new DomainException('Algorithm not supported');
        }

        return hash_hmac($methods[$method], $msg, $key, true);

    }

    public function JsonDecode($input){

        $obj = json_decode($input);

        if(function_exists('json_last_error') && $errno = json_last_error()){
            $this->HandleJsonError($errno);
        }else if($obj === null && $input !== 'null'){
            throw new DomainException('Null result with non-null input');
        }

        return $obj;

    }

    public function JsonEncode($input){

        $json = json_encode($input);

        if(function_exists('json_last_error') && $errno = json_last_error()){
            $this->HandleJsonError($errno);
        }else if($json === 'null' && $input !== null){
            throw new DomainException('Null result with non-null input');
        }

        return $json;

    }

    public function UrlSafeB64Decode($input){
        
        $remainder = strlen($input) % 4;

        if($remainder){
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }

        return base64_decode(strtr($input, '-_', '+/'));

    }

    public function UrlSafeB64Encode($input){
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    private function HandleJsonError($errno){

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
