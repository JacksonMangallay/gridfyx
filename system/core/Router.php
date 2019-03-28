<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

class Router{

    private static $routes = [];
    private static $controller;
    private static $method;
    private static $params = [];
    private static $namespace = '';
    private static $wildcards = [':string', ':int', ':any'];
    private static $regex = ['^[A-Za-z-]+$', '[1-9][0-9]*', '^[a-zA-Z0-9]*$'];
    private static $found_match = false;

    public static function load(String $route){

        $route_file = APPLICATION . '/routes/' . $route . '.php';
        
        if(file_exists($route_file)){
            include($route_file);
        }
        
    }

    public static function set_default_controller(String $controller){

        if(!isset($controller) || empty($controller)){
            throw new Exception('Default controller should neither be null nor empty.');
        }

        self::$controller = $controller;

    }

    public static function set_default_method(String $method){

        if(!isset($method) || empty($method)){
            throw new Exception('Default method should neither be null nor empty.');
        }

        self::$method = $method;

    }

    public static function set_namespace(String $namespace){

        if(!isset($namespace) || empty($namespace)){
            throw new Exception('Namespace should neither be null nor empty.');
        }

        self::$namespace = $namespace;

    }

    public static function get(String $url, Array $args = []){

        if(!isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'GET'){
            throw new Exception('Invalid request.');
        }

        if(!isset($url) || empty($url)){
            throw new Exception('URL request is not set.');
        }

        $url = self::filter_wildcard($url);

        self::$routes['GET'][$url] = [];
        self::$routes['GET'][$url]['controller'] = isset($args['controller']) || !empty($args['controller']) ? $args['controller'] : self::$controller;
        self::$routes['GET'][$url]['method'] = isset($args['method']) || !empty($args['method']) ? $args['method'] : self::$method;
        self::$routes['GET'][$url]['params'] = isset($args['params']) || !empty($args['params']) ? $args['params'] : '';

    }

    public static function post(String $url, Array $args = []){

        if(!isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST'){
            throw new Exception('Invalid request.');
        }

        if(!isset($url) || empty($url)){
            throw new Exception('URL request is not set.');
        }

        $url = self::filter_wildcard($url);

        self::$routes['POST'][$url] = [];
        self::$routes['POST'][$url]['controller'] = isset($args['controller']) || !empty($args['controller']) ? $args['controller'] : '';
        self::$routes['POST'][$url]['method'] = isset($args['method']) || !empty($args['method']) ? $args['method'] : '';
        self::$routes['POST'][$url]['params'] = isset($args['params']) || !empty($args['params']) ? $args['params'] : '';

    }

    public static function run(){

        self::$routes['GET'] = [];
        SELF::$routes['POST'] = [];
        load_config('routes');

        if(!self::is_default_controller_set()){
            throw new Exception('Default controller not set.');
        }

        if(!self::is_default_method_set()){
            throw new Exception('Default method not set.');
        }

        $routes = self::$routes[$_SERVER['REQUEST_METHOD']];
        $request = self::get_uri();

        foreach($routes as $route => $url){

            if($request === '/'){

                if(!array_key_exists($request, $routes)){
                    continue;
                }

                self::manage_route($url, $request);
                self::$found_match = true;
                break;
            }

            $route = self::parse($route);
            $uri = self::parse($request);

            if(count($route) !== count($uri)){
                continue;
            }

            $params = array_diff($route, $uri);

            if(!self::match_regex($uri, $params)){
                continue;
            }

            $route_str = self::replace_regex($route, $uri, $params);
            $route_str = implode('/', $route_str);
            $route_str = self::translate_url_dashes($route_str);
            $uri_str = implode('/', $uri);
            $uri_str = self::translate_url_dashes($uri_str);

            if(strcmp($route_str, $uri_str) !== 0){
                continue;
            }

            self::manage_route($url, $route_str);
            self::$found_match = true;
            break;

        }

        if(!self::$found_match){
            http_response(404);
        }

        self::dispatch();

    }

    private static function manage_route(Array $route, String $route_str){

        if(!empty($route['controller'])){
            self::$controller = $route['controller'];
        }

        if(!empty($route['method'])){
            self::$method = $route['method'];
        }else{

            if($route_str !== '/'){
                self::$method = explode('/', $route_str);
                self::$method = self::$method[0];
            }

        }

        if(!empty($route['params'])){
            self::$params = $route['params'];
        }

    }

    private static function dispatch(){

        $file = APPLICATION . DS . 'controllers' . DS . self::$controller . '.php';

        if(!file_exists($file)){
            http_response(404);
        }

        require_once($file);

        self::$controller = self::$namespace . self::$controller;
        self::$controller = new self::$controller();

        if(!method_exists(self::$controller, self::$method)){
            http_response(404);
        }

        call_user_func_array([self::$controller, self::$method], self::$params);

    }

    private static function is_default_controller_set():bool{
            
        if(!isset(self::$controller) || empty(self::$controller)){
            return false;
        }

        return true;

    }

    private static function is_default_method_set():bool{
            
        if(!isset(self::$method) || empty(self::$method)){
            return false;
        }

        return true;

    }

    private static function translate_url_dashes(String $uri):string{

        $uri = explode('-', $uri);
        $uri = array_map('ucfirst', $uri);
        $uri[0] = strtolower($uri[0]);
        $uri = implode('-', $uri);

        return str_replace('-','',$uri);
    }

    private static function replace_regex(Array $route, Array $uri, Array $params):array{

        foreach($params as $key => $value){
            $route[$key] = $uri[$key];
            array_push(self::$params, $route[$key]);
        }

        return $route;

    }

    private static function match_regex(Array $uri, Array $params):bool{

        foreach($params as $key => $value){
            
            if(!preg_match('#^' . $value . '$#', $uri[$key])){
                return false;
            }

        }

        return true;

    }

    private static function filter_wildcard(String $url):string{
        return str_replace(self::$wildcards, self::$regex, $url);
    }

    private static function get_uri():string{

        if(!isset($_GET['uri'])){
            return '/';
        }

        return '/' . rtrim($_GET['uri'], '/');

    }

    private static function parse(String $str):array{

        $str = explode('/',$str);
        $str = array_filter($str);
        $str = array_values($str);

        return $str;
    }

}