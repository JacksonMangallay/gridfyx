<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

function load_third_party(String $third_party){

    $third_party_index = SYSTEM . DS . 'core' . DS . 'third-party' . DS . $third_party . DS . 'index.php';

    if(!file_exists($third_party_index)){
        throw new Exception('Unable to load third-party plugin ' . $third_party . '!');
    }

    require_once($third_party_index);

}

function load_config(String $config){

    $config_file = APPLICATION . DS . 'config' . DS . $config . '.php';

    if(!file_exists($config_file)){
        throw new Exception('Unable to load configuration file ' . $config . '!');
    }

    require_once($config_file);

}

function error_handler(Int $severity,String $message,String $file,Int $line){
    $e = new Exceptions();
    $e->errorHandler($severity, $message, $file, $line);
}

function exception_handler($error){
    $e = new Exceptions();
    $e->errorHandler(E_ERROR, $error->getMessage(), $error->getFile(), $error->getLine());
}

function shutdown_handler(){

    $e = new Exceptions();
    $error = error_get_last();

    if(isset($error) && ($error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING))){
        $e->errorHandler($error['type'], $error['message'], $error['file'], $error['line']);
    }

}

function http_response(Int $code = 200){

    $file = APPLICATION . DS . 'views' . DS . Config::getErrorPagesPath() . DS . $code . '.php';

    $response = [
        100	=> 'Continue',
        101	=> 'Switching Protocols',
        200	=> 'OK',
        201	=> 'Created',
        202	=> 'Accepted',
        203	=> 'Non-Authoritative Information',
        204	=> 'No Content',
        205	=> 'Reset Content',
        206	=> 'Partial Content',
        300	=> 'Multiple Choices',
        301	=> 'Moved Permanently',
        302	=> 'Found',
        303	=> 'See Other',
        304	=> 'Not Modified',
        305	=> 'Use Proxy',
        307	=> 'Temporary Redirect',
        400	=> 'Bad Request',
        401	=> 'Unauthorized',
        402	=> 'Payment Required',
        403	=> 'Forbidden',
        404	=> 'Not Found',
        405	=> 'Method Not Allowed',
        406	=> 'Not Acceptable',
        407	=> 'Proxy Authentication Required',
        408	=> 'Request Timeout',
        409	=> 'Conflict',
        410	=> 'Gone',
        411	=> 'Length Required',
        412	=> 'Precondition Failed',
        413	=> 'Request Entity Too Large',
        414	=> 'Request-URI Too Long',
        415	=> 'Unsupported Media Type',
        416	=> 'Requested Range Not Satisfiable',
        417	=> 'Expectation Failed',
        422	=> 'Unprocessable Entity',
        426	=> 'Upgrade Required',
        428	=> 'Precondition Required',
        429	=> 'Too Many Requests',
        431	=> 'Request Header Fields Too Large',
        500	=> 'Internal Server Error',
        501	=> 'Not Implemented',
        502	=> 'Bad Gateway',
        503	=> 'Service Unavailable',
        504	=> 'Gateway Timeout',
        505	=> 'HTTP Version Not Supported',
        511	=> 'Network Authentication Required'
    ];

    header('HTTP/1.1 ' . $code . ' ' . $response[$code] . '.');

    if(!file_exists($file)){
        exit($code . ' ' . $response[$code]);
    }

    require($file);
    exit;
}

function base_url():string{

    if(isset($_SERVER['HTTP_HOST']) && preg_match('/^((\[[0-9a-f:]+\])|(\d{1,3}(\.\d{1,3}){3})|[a-z0-9\-\.]+)(:\d+)?$/i', $_SERVER['HTTP_HOST'])){
        $baseUrl = (is_https() ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] . substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
    }else{
        $baseUrl = 'http://127.0.0.1/';
    }

    return dirname($baseUrl);

}

function is_https():bool{

    if(!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off'){
        return true;
    }elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'){
        return true;
    }elseif(!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off'){
        return true;
    }

    return false;

}

function redirect($location = '/'){
    header('Location: ' . BASE_URL . $location);
}