<?php declare(strict_types = 1);

defined('BASEPATH') || exit('Direct access is forbidden');

use System\Core\Config;

class Router{

    private static $routes = array();
    private static $controller = 'App';
    private static $method = 'index';
    private static $params = array();
    private static $namespace = 'Application\\Controllers\\';
    private static $config = null;

    //URI parameter types
    private static $wildcards = array(
        ':string',
        ':int',
        ':any'
    );

    //URI parameter types equivalents
    private static $regex = array(
        '^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$',
        '[1-9][0-9]*',
        '^[a-zA-Z0-9][\s\S]*$'
    );

    //URL flag is match found in routes
    private static $match = false;

    public function __construct(){
        self::$config = new Config();
    }

	/**
	 * 
     * @param string $controller
     * 
     */
    public static function set_default_controller($controller = ''){

        if(is_empty($controller)){
            throw new InvalidArgumentException('Default controller should neither be null nor empty!');
        }

        self::$controller = $controller;

    }

	/**
	 * 
     * @param string $method
     * 
     */
    public static function set_default_method($method = ''){

        if(is_empty($method)){
            throw new InvalidArgumentException('Default method should neither be null nor empty!');
        }

        self::$method = $method;

    }

	/**
	 * 
     * @param string $namespace
     * 
     */
    public static function set_namespace($namespace = ''){

        if(is_empty($namespace)){
            throw new InvalidArgumentException('Controller namespace is required!');
        }

        self::$namespace = $namespace;

    }

	/**
	 * 
     * @param string $url
     * @param array $args
     * 
     */
    public static function get($url = '', $args = array()){
        self::store_routes('GET', $url, $args);
    }

	/**
	 * 
     * @param string $url
     * @param array $args
     * 
     */
    public static function post($url = '', $args = array()){
        self::store_routes('POST', $url, $args);
    }

    //Run router
    public static function run(){

        self::$routes['GET'] = array();
        self::$routes['POST'] = array();

        //Load all routes
        self::$config->load('routes');

        if(!self::has_default_controller()){
            throw new InvalidArgumentException('Default controller is not set!');
        }

        if(!self::has_default_method()){
            throw new InvalidArgumentException('Default method is not set!');
        }

        //Fetch all routes depending on request method (GET or POST) 
        $routes = self::$routes[$_SERVER['REQUEST_METHOD']];

        //Get current uri 
        $request = self::get_uri();

        //Check all routes with regards to the request method
        foreach($routes as $route => $url){

            /** 
             * If a route is set with a value of "/", automatically
             * call the default controller and method
             */
            if($request === '/'){
                /** 
                 * Check if request is indexed to routes array.
                 * If not, exit current loop process and continue
                 * checking
                 */
                if(!array_key_exists($request, $routes)){
                    continue;
                }

                /** 
                 * Set and manage controller, method, and parameters.
                 * If no controller/method/parameters are set,
                 * set everything to default controller, method, parameters
                 */
                self::manage_route($url, $request);

                /** 
                 * If match is found, stop the loop 
                 * and serve the requested content
                 */
                self::$match = true;
                break;
            }

            //Transform the route into an array
            $route = self::parse($route);

            //Transform the uri request into an array
            $uri = self::parse($request);

            /** 
             * Check if current route and current uri length matches.
             * If length doesn't match, exit current loop
             * process and check the next route
             */
            if(count($route) !== count($uri)){
                continue;
            }

            /** 
             * Compare the current route and uri.
             * If any value doesn't match, automatically
             * make this value a parameter/s
             */
            $params = array_diff($route, $uri);

            /** 
             * Check if parameters matches the regex.
             * Ex: If parameter is set as :string,
             * then the parameters must be strings
             * 
             * If parameters and regex doesn't match,
             * exit current loop process and check the
             * next route
             */
            if(!self::match_regex($uri, $params)){
                continue;
            }

            //Replace regex in the route with the parameters.
            $route_str = self::replace_regex($route, $uri, $params);

            //Transform route from array to a string
            $route_str = implode('/', $route_str);

            //Remove route dashes
            $route_str = self::translate_url_dashes($route_str);

            //Transform uri from array to a string
            $uri_str = implode('/', $uri);

            //Remove uri ashes
            $uri_str = self::translate_url_dashes($uri_str);

            //Compare the route and uri.
            if(strcmp($route_str, $uri_str) !== 0){
                continue;
            }

            /** 
             * Set and manage controller, method, and parameters.
             * If no controller/method/parameters are set,
             * set everything to default controller, method, parameters
             */
            self::manage_route($url, $route_str);

            /** 
             * If match is found, stop the loop 
             * and serve the requested content
             */            
            self::$match = true;
            break;

        }

        /** 
         * If requested uri is not found in the routes array,
         * display error 404
         */
        if(!self::$match){
            not_found();
        }

        /** 
         * If requested uri is found in the routes array,
         * serve the requested content
         */
        self::dispatch();

    }

    public static function load(String $route){

        /** 
         * Routes should be found at /application/routes 
         */
        $route_file = DIR_ROUTES . '/' . $route . '.php';
        
        if(file_exists($route_file)){
            include($route_file);
        }
        
    }

	/**
	 * 
     * @param string $request_method
     * @param string $url
     * @param array $args
     * 
     */
    private static function store_routes($request_method = 'GET', $url = '', $args = array()){

        if(!isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== $request_method){
            throw new InvalidArgumentException('Invalid HTTP request!');
        }

        if(!isset($url) || empty($url)){
            throw new InvalidArgumentException('URL request is not set!');
        }

        /**
         * Replace all wildcards in a route
         * with the regex array
         * Ex: /requested/url/:string => /requested/url/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$
         */
        $url = self::filter_wildcard($url);

        //Save a route to routes array with GET method as index 
        self::$routes[$request_method][$url] = array();

        /**
         * Check if a controller is set on a route.
         * If no controller is specified, the default
         * controller will be called.
         */
        if(isset($args['controller']) || !empty($args['controller'])){
            self::$routes[$request_method][$url]['controller'] = $args['controller'];
        }else{
            self::$routes[$request_method][$url]['controller'] = self::$controller;
        }

        /**
         * Check if a method is set on a route.
         * If no method is specified, the default
         * method will be called.
         */
        if(isset($args['method']) || !empty($args['method'])){
            self::$routes[$request_method][$url]['method'] = $args['method'];
        }else{
            self::$routes[$request_method][$url]['method'] = self::$method;
        }

        //Check if parameters are present.
        if(isset($args['params']) || !empty($args['params'])){
            self::$routes[$request_method][$url]['params'] = $args['params'];
        }else{
            self::$routes[$request_method][$url]['params'] = '';
        }

    }

    /** 
     * Set and manage controller, method, and parameters.
     * If no controller/method/parameters are set,
     * set everything to default controller, method, parameters
     */
    private static function manage_route(Array $route, String $route_str){

        //Set controller to the route controller
        if(!empty($route['controller'])){
            self::$controller = $route['controller'];
        }

        //Set method to the route method
        if(!empty($route['method'])){
            self::$method = $route['method'];
        }else{

            /** 
             * If no method is set, transform the route string
             * into an array and set the first index as the method
             */
            if($route_str !== '/'){
                self::$method = explode('/', $route_str);
                self::$method = self::$method[0];
            }

        }

        /** 
         * Set parameters if parameters on
         * the route is present
         */
        if(!empty($route['params'])){
            self::$params = $route['params'];
        }

    }


    //Serve the requested view
    private static function dispatch(){

        $file = DIR_CONTROLLERS . '/' . self::$controller . '.php';

        if(!file_exists($file)){
            not_found();
        }

        require_once($file);

        self::$controller = self::$namespace . self::$controller;
        self::$controller = new self::$controller();

        if(!method_exists(self::$controller, self::$method)){
            not_found();
        }

        call_user_func_array([self::$controller, self::$method], self::$params);

    }

    private static function has_default_controller(){
        return !isset(self::$controller) || empty(self::$controller) ? false : true;
    }

    private static function has_default_method(){
        return !isset(self::$method) || empty(self::$method) ? false : true; 
    }

	/**
	 * 
     * Remove dashes
     * 
     * @param string $uri
     * 
     * @return string
     */
    private static function translate_url_dashes($uri = ''){

        $uri = explode('-', $uri);
        $uri = array_map('ucfirst', $uri);
        $uri[0] = strtolower($uri[0]);
        $uri = implode('-', $uri);

        return str_replace('-','',$uri);
    }


	/**
	 * 
     * Replace regex in the route with the parameters set in the current uri
     * 
     * @param array $route
     * @param array $uri
     * @param array $params
     * 
     * @return array
     */
    private static function replace_regex($route = array(), $uri = array(), $params = array()){

        foreach($params as $key => $value){
            $route[$key] = $uri[$key];
            array_push(self::$params, $route[$key]);
        }

        return $route;

    }

	/**
	 * 
     * Check if regex matches the parameters
     * 
     * @param array $uri
     * @param array $params
     * 
     * @return bool
     */
    private static function match_regex($uri = array(), $params = array()){

        foreach($params as $key => $value){
            
            if(!preg_match('#^' . $value . '$#', $uri[$key])){
                return false;
            }

        }

        return true;

    }

	/**
	 * 
     * Replace all wildcards in a route
     * with the regex array
     * Ex: /requested/url/:string => /requested/url/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$
     * 
     * @param string $url
     * 
     * @return string
     */
    private static function filter_wildcard($url = ''){
        return str_replace(self::$wildcards, self::$regex, $url);
    }

	/**
	 * 
     * Fetch current request uri
     * 
     * @return string
     */
    private static function get_uri(){
        return !isset($_GET['uri']) ? '/' : '/' . rtrim($_GET['uri'], '/');
    }

	/**
	 * 
     * Transform uri into an array
     * 
     * @param string $uri
     * 
     * @return array
     */
    private static function parse($uri = ''){

        $uri = explode('/',$uri);
        $uri = array_filter($uri);
        $uri = array_values($uri);

        return $uri;
    }

}