<?php declare(strict_types = 1);

namespace System\Library;

defined('BASEPATH') || exit('Direct access is forbidden');

use \DomainException;
use \InvalidArgumentException;
use \UnexpectedValueException;
use \DateTime;

final class JWT{

	/**
	 * 
	 * @param mixed $payload
     * @param string $key
     * @param string $algo
     *
     * @return string
     */
     public function encode($payload = '', $key = '', $algo = 'HS256'){

        $header = array('typ' => 'JWT', 'alg' => $algo);
        $segments = array();
        $segments[] = $this->url_safe_b64_encode($this->json_encode($header));
        $segments[] = $this->url_safe_b64_encode($this->json_encode($payload));
        $signing_input = implode('.', $segments);

        $signature = $this->sign($signing_input, $key, $algo);
        $segments[] = $this->url_safe_b64_encode($signature);

        return implode('.', $segments);

    }

	/**
	 * 
	 * @param string $jwt
     * @param string $key
     * @param bool $verify
     *
     * @return array
     */
    public function decode($jwt = '', $key = null, $verify = true){

        $tks = explode('.', $jwt);

        if(count($tks) !== 3){
            throw new UnexpectedValueException('Wrong number of segments');
        }

        list($headb64, $payloadb64, $cryptob64) = $tks;

        if(null === ($header = $this->json_decode($this->url_safe_b64_decode($headb64)))){
            throw new UnexpectedValueException('Invalid segment encoding');
        }

        if(null === $payload = $this->json_decode($this->url_safe_b64_decode($payloadb64))){
            throw new UnexpectedValueException('Invalid segment encoding');
        }

        $sig = $this->url_safe_b64_decode($cryptob64);

        if($verify){

            if(empty($header->alg)){
                throw new DomainException('Empty algorithm');
            }

            if($sig !== $this->sign("$headb64.$payloadb64", $key, $header->alg)){
                throw new UnexpectedValueException('Signature verification failed');
            }
        }

        return $payload;

    }

	/**
	 * 
	 * @param string $msg
     * @param string $key
     * @param string $method
     *
     * @return string
     */
    public function sign($msg = '', $key = '', $method = 'HS256'){

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

	/**
	 * 
	 * @param string $input
     *
     * @return object
     */
    public function json_decode($input = ''){

        $obj = json_decode($input);

        if(function_exists('json_last_error') && $errno = json_last_error()){
            $this->handle_json_error($errno);
        }else if($obj === null && $input !== 'null'){
            throw new DomainException('Null result with non-null input');
        }

        return $obj;

    }

	/**
	 * 
	 * @param mixed $input
     *
     * @return string
     */
    public function json_encode($input = ''){

        $json = json_encode($input);

        if(function_exists('json_last_error') && $errno = json_last_error()){
            $this->handle_json_error($errno);
        }else if($json === 'null' && $input !== null){
            throw new DomainException('Null result with non-null input');
        }

        return $json;

    }

    public function url_safe_b64_decode($input = ''){
        
        $remainder = strlen($input) % 4;

        if($remainder){
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }

        return base64_decode(strtr($input, '-_', '+/'));

    }

    public function url_safe_b64_encode($input){
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    private function handle_json_error($errno){

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
