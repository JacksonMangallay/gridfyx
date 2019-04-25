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
namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use Exception;

class Router
{
	/**
	 * Store all routes
	 */
    private static $routes = [];

	/**
	 * Controller specified by a route
	 */
    private static $controller;

	/**
	 * Method called by a route
	 */
    private static $method;

	/**
	 * Parameters passed when calling a method
	 */
    private static $params = [];

	/**
	 * Controllers namespace.
     * If set, all controllers must have this namespace
	 */
    private static $namespace = '';

	/**
     * URI variable types
     * :string - allow only string variables
     * :int - allow only integer variables
     * :any - allow any type of variables
	 */
    private static $wildcards = [':string', ':int', ':any'];

	/**
     * Check if a variable matches the desired type
     * as set in $wildcards
	 */
    private static $regex = ['^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$', '[1-9][0-9]*', '^[a-zA-Z0-9]*$'];

	/**
     * Check if a URI request matches
     * any available routes list
	 */
    private static $found_match = false;

	/**
     * Load a route file.
     * All route files must be loaded at /application/config/routes.php
	 */
    public static function load(String $route):void
    {

        /** 
         * Routes should be found at /application/routes 
         */
        $route_file = APPLICATION . DS . 'routes' . DS . $route . '.php';
        
        if(file_exists($route_file))
        {
            include($route_file);
        }
        
    }

	/**
     * Set default controller.
     * When setting a route, if there's no
     * specific controller set, this default
     * controller will be the method's controller.
	 */
    public static function setDefaultController(String $controller):void
    {

        /**
         * There must be a default controller set 
         */
        if(!isset($controller) || empty($controller))
        {
            throw new Exception('Default controller should neither be null nor empty.');
        }

        self::$controller = $controller;

    }

	/**
     * Set default method.
     * System will look for this default method
     * if a method is not set when setting up a router
	 */
    public static function setDefaultMethod(String $method):void
    {

        /** 
         * There must be a default method set 
         */
        if(!isset($method) || empty($method))
        {
            throw new Exception('Default method should neither be null nor empty.');
        }

        self::$method = $method;

    }

	/**
     * Set controllers namespace.
     * This is optional. But once you
     * set, all controllers must use this namespace.
	 */
    public static function setNamespace(String $namespace):void
    {

        if(!isset($namespace) || empty($namespace))
        {
            throw new Exception('Namespace should neither be null nor empty.');
        }

        self::$namespace = $namespace;

    }

	/**
     * Set a route with GET method
	 */
    public static function get(String $url, Array $args = []):void
    {

        if(!isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'GET')
        {
            throw new Exception('Invalid request.');
        }

        if(!isset($url) || empty($url))
        {
            throw new Exception('URL request is not set.');
        }

        /**
         * Replace all wildcards in a route
         * with the regex array
         * Ex: /requested/url/:string => /requested/url/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$
         */
        $url = self::filterWildcard($url);

        /** 
         * Save a route to routes array with GET method as index 
         */
        self::$routes['GET'][$url] = [];

        /**
         * Check if a controller is set on a route.
         * If no controller is specified, the default
         * controller will be called.
         */
        self::$routes['GET'][$url]['controller'] = isset($args['controller']) || !empty($args['controller']) ? $args['controller'] : self::$controller;

        /**
         * Check if a method is set on a route.
         * If no method is specified, the default
         * method will be called.
         */
        self::$routes['GET'][$url]['method'] = isset($args['method']) || !empty($args['method']) ? $args['method'] : self::$method;

        /**
         * Check if parameters are present.
         */
        self::$routes['GET'][$url]['params'] = isset($args['params']) || !empty($args['params']) ? $args['params'] : '';

    }

	/**
     * Set a route with POST method
	 */
    public static function post(String $url, Array $args = []):void
    {

        if(!isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            throw new Exception('Invalid request.');
        }

        if(!isset($url) || empty($url))
        {
            throw new Exception('URL request is not set.');
        }

        /**
         * Replace all wildcards in a route
         * with the regex array
         * Ex: /requested/url/:string => /requested/url/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$
         */
        $url = self::filterWildcard($url);

        /** 
         * Save a route to routes array with GET method as index 
         */
        self::$routes['POST'][$url] = [];

        /**
         * Check if a controller is set on a route.
         * If no controller is specified, the default
         * controller will be called.
         */        
        self::$routes['POST'][$url]['controller'] = isset($args['controller']) || !empty($args['controller']) ? $args['controller'] : '';
        
        /**
         * Check if a method is set on a route.
         * If no method is specified, the default
         * method will be called.
         */
        self::$routes['POST'][$url]['method'] = isset($args['method']) || !empty($args['method']) ? $args['method'] : '';
        
        /**
         * Check if parameters are present.
         */
        self::$routes['POST'][$url]['params'] = isset($args['params']) || !empty($args['params']) ? $args['params'] : '';

    }

	/**
     * Run the router. Initiated at Bootstrap.php
	 */
    public static function run():void
    {

        /**
         * Store all GET methods
         */
        self::$routes['GET'] = [];

        /**
         * Store all POST method routes
         */
        self::$routes['POST'] = [];

        /**
         * Load routes.php config file.
         * Located at /application/config/routes.php
         */
        load_config('routes');

        if(!self::isDefaultControllerSet())
        {
            throw new Exception('Default controller not set.');
        }

        if(!self::isDefaultMethodSet())
        {
            throw new Exception('Default method not set.');
        }

        /**
         * Fetch all routes depending on request method (GET or POST) 
         */
        $routes = self::$routes[$_SERVER['REQUEST_METHOD']];

        /** 
         * Get current uri 
         */
        $request = self::getUri();

        /** 
         * Check all routes with regards to the request method
         */
        foreach($routes as $route => $url)
        {

            /** 
             * If a route is set with a value of "/", automatically
             * call the default controller and method
             */
            if($request === '/')
            {
                /** 
                 * Check if request is indexed to routes array.
                 * If not, exit current loop process and continue
                 * checking
                 */
                if(!array_key_exists($request, $routes))
                {
                    continue;
                }

                /** 
                 * Set and manage controller, method, and parameters.
                 * If no controller/method/parameters are set,
                 * set everything to default controller, method, parameters
                 */
                self::manageRoute($url, $request);

                /** 
                 * If match is found, stop the loop 
                 * and serve the requested content
                 */
                self::$found_match = true;
                break;
            }

            /** 
             * Transform the route into an array
             */
            $route = self::parse($route);

            /** 
             * Transform the current uri into an array
             */
            $uri = self::parse($request);

            /** 
             * Check if current route and current uri length matches.
             * If length doesn't match, exit current loop
             * process and check the next route
             */
            if(count($route) !== count($uri))
            {
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
             * If parameters and and regex doesn't match,
             * exit current loop process and check the
             * next route
             */
            if(!self::matchRegex($uri, $params))
            {
                continue;
            }

            /** 
             * Replace regex in the route with the parameters.
             */
            $route_str = self::replaceRegex($route, $uri, $params);

            /** 
             * Transform route from array to a string
             */
            $route_str = implode('/', $route_str);

            /** 
             * Remove all dashes
             */
            $route_str = self::translateUrlDashes($route_str);

            /** 
             * Transform uri from array to a string
             */
            $uri_str = implode('/', $uri);

            /** 
             * Remove all dashes
             */
            $uri_str = self::translateUrlDashes($uri_str);

            /** 
             * Compare the route and uri.
             */
            if(strcmp($route_str, $uri_str) !== 0)
            {
                continue;
            }

            /** 
             * Set and manage controller, method, and parameters.
             * If no controller/method/parameters are set,
             * set everything to default controller, method, parameters
             */
            self::manageRoute($url, $route_str);

            /** 
             * If match is found, stop the loop 
             * and serve the requested content
             */            
            self::$found_match = true;
            break;

        }

        /** 
         * If requested uri is not found in the routes array,
         * display error 404
         */
        if(!self::$found_match)
        {
            http_response(404);
        }

        /** 
         * If requested uri is found in the routes array,
         * serve the requested content
         */
        self::dispatch();

    }

    /** 
     * Set and manage controller, method, and parameters.
     * If no controller/method/parameters are set,
     * set everything to default controller, method, parameters
     */
    private static function manageRoute(Array $route, String $route_str):void
    {
        /** 
         * Set controller to the route controller
         */
        if(!empty($route['controller']))
        {
            self::$controller = $route['controller'];
        }

        /** 
         * Set method to the route method
         */
        if(!empty($route['method']))
        {
            self::$method = $route['method'];
        }
        else
        {
            /** 
             * If no method is set, transform the route string
             * into an array and set the first index as the method
             */
            if($route_str !== '/')
            {
                self::$method = explode('/', $route_str);
                self::$method = self::$method[0];
            }

        }

        /** 
         * Set parameters if parameters on
         * the route is present
         */
        if(!empty($route['params']))
        {
            self::$params = $route['params'];
        }

    }


    /** 
     * Serve the requested content
     */
    private static function dispatch():void
    {
        /** 
         * Controller file found at /application/controllers
         */
        $file = APPLICATION . DS . 'controllers' . DS . self::$controller . '.php';

        if(!file_exists($file))
        {
            http_response(404);
        }

        require_once($file);

        self::$controller = self::$namespace . self::$controller;
        self::$controller = new self::$controller();

        if(!method_exists(self::$controller, self::$method))
        {
            http_response(404);
        }

        call_user_func_array([self::$controller, self::$method], self::$params);

    }

    private static function isDefaultControllerSet():bool
    {
            
        if(!isset(self::$controller) || empty(self::$controller))
        {
            return false;
        }

        return true;

    }

    private static function isDefaultMethodSet():bool
    {
            
        if(!isset(self::$method) || empty(self::$method))
        {
            return false;
        }

        return true;

    }

    /** 
     * Remove all dashes
     */
    private static function translateUrlDashes(String $uri):string
    {

        $uri = explode('-', $uri);
        $uri = array_map('ucfirst', $uri);
        $uri[0] = strtolower($uri[0]);
        $uri = implode('-', $uri);

        return str_replace('-','',$uri);
    }

    /** 
     * Replace regex in the route with the parameters set in the current uri
     */
    private static function replaceRegex(Array $route, Array $uri, Array $params):array
    {

        foreach($params as $key => $value)
        {
            $route[$key] = $uri[$key];
            array_push(self::$params, $route[$key]);
        }

        return $route;

    }

    /** 
     * Check if regex matches the parameters
     */ 
    private static function matchRegex(Array $uri, Array $params):bool
    {

        foreach($params as $key => $value)
        {
            
            if(!preg_match('#^' . $value . '$#', $uri[$key]))
            {
                return false;
            }

        }

        return true;

    }

    /**
     * Replace all wildcards in a route
     * with the regex array
     * Ex: /requested/url/:string => /requested/url/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$
     */
    private static function filterWildcard(String $url):string
    {
        return str_replace(self::$wildcards, self::$regex, $url);
    }

    /**
     * Fetch current request uri
     */
    private static function getUri():string
    {

        if(!isset($_GET['uri']))
        {
            return '/';
        }

        return '/' . rtrim($_GET['uri'], '/');

    }

    /**
     * Transform uri into an array
     */
    private static function parse(String $str):array
    {

        $str = explode('/',$str);
        $str = array_filter($str);
        $str = array_values($str);

        return $str;
    }

}