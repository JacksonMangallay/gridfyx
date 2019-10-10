<?php declare(strict_types = 1);

defined('BASEPATH') || exit('Direct access is forbidden');

if(!function_exists('check_version')){

    //System requires PHP version 7.0 or newer
    function check_version(){
        if(version_compare(PHP_VERSION, '7.0') < 0){
            display_log('<b>Gridfyx PHP Framework</b> supports PHPv7.0 or newer. Please update your PHP version!');
        }
    }

}

if(!function_exists('display_log')){

	/**
	 * 
	 * @param string $filename
     * 
     */
    function display_log($message = ''){

        if(is_empty($message)){
            return false;
        }

        echo '<div style="position: relative; font-family: Helvetica, Arial, sans-serif; font-size: .9rem; z-index: 999; display: block; clear: both; background-color: #fcf8e3; border: 1px solid #843534; color: #8a6d3b; box-sizing: border-box; padding: 20px; margin-bottom: 10px;">' . $message . '</div>';
    }

}

if(!function_exists('write_log')){

	/**
	 * 
     * @param string $message
     * @param string $type
     * 
     */
    function write_log($message = '', $type = 'error'){

        if(is_empty($message)){
            return false;
        }

        if($type === 'system'){
            $message = '[' . date('Y-m-d') . '][System] ' . $message;
        }

        $logfile = DIR_LOGS . '/' . $type . '.log'; 
        $fp = fopen($logfile, 'ab');

        if(flock($fp, LOCK_EX)){
            fwrite($fp, $message . "\n");
            fflush($fp);
            flock($fp, LOCK_UN);
        }else{
            display_log('Unable to write at log file ' . $type . '!');
        }
        
        fclose($fp);

    }

}

if(!function_exists('is_empty')){

	/**
	 * 
     * @param string $var
     * 
     * @return bool
     */
    function is_empty($var = ''){

        if(!isset($var) || empty($var) || is_null($var)){
            return true;
        }
    
        return false;
    
    }

}

if(!function_exists('not_found')){

    function not_found($page = '404'){

        $file = DIR_VIEWS . '/' . $page . '.php';

        if(file_exists($file)){
            include($file);
            exit;
        }

        display_log('404 - Page not found!');
        exit;
    }

}

if(!function_exists('base_url')){

	/**
	 * 
     * @return string
     */
    function base_url(){
    
        if(isset($_SERVER['HTTP_HOST']) && preg_match('/^((\[[0-9a-f:]+\])|(\d{1,3}(\.\d{1,3}){3})|[a-z0-9\-\.]+)(:\d+)?$/i', $_SERVER['HTTP_HOST'])){
            $base_url = (is_https() ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] . substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
        }else{
            $base_url = 'http://localhost/';
        }
    
        return dirname($base_url);
    
    }

}

if(!function_exists('is_https')){

	/**
	 * 
     * @return bool
     */
    function is_https(){
    
        $is_https = false;

        if(!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off'){
            $is_https = true;
        }elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'){
            $is_https = true;
        }elseif(!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off'){
            $is_https = true;
        }
    
        return $is_https;
    
    }

}

if(!function_exists('redirect')){

    function redirect($to = '/'){
        header('Location: ' . base_url() . $to);
    }

}

if(!function_exists('url')){

	/**
	 * 
     * @return bool
     */
    function url($url = ''){

        if(is_empty($url)){
            return false;
        }

        echo base_url() . $url;

    }

}

if(!function_exists('is_url')){

	/**
	 * 
     * @param string $url
     * 
     * @return bool
     */
    function is_url($url = ''){

        if(is_empty($url)){
            return false;
        }

        $url = filter_var($url, FILTER_SANITIZE_STRING);
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $has_protocol = false;

        $allowed_protocols = array('http', 'https', 'sftp', 'ftp');

        //Check if a protocol is present in the string
        foreach($allowed_protocols as $key){
            if(strpos($url, $key) === 0){
                $has_protocol = true;
                break;
            }else{
                $has_protocol = false;
            }
        }

        /**
         * If string has protocol, check if protocol is not repeated.
         * Ex: http://http://www.website.com will return false
         * 
         * If no protocol found, add default protocol (http://)
         */
        if($has_protocol){

            $url_array = explode('://', $url);

            if(count($url_array) > 2){
                return false;
            }

        }else{
            $url = 'http://' . $url;
        }

        return filter_var($url, FILTER_VALIDATE_URL);

    }

}

if(!function_exists('is_equal')){

	/**
	 * 
     * @param string $var1
     * @param string $var2
     * 
     * @return bool
     */
    function is_equal($var1 = '', $var2 = ''){

        if(is_empty($var1) || is_empty($var2)){
            return false;
        }

        if(is_array($var1) || is_array($var2)){

            if(!is_array($var1) || !is_array($var2)){
                return false;
            }

            if(count($var1) !== count($var2)){
                return false;
            }

            $result = array_intersect($var1, $var2);

            return (int)count($result) === (int)count($var1) ? true : false;

        }

        return $var1 === $var2 ? true : false;

    }

}

if(!function_exists('plugin')){

	/**
	 * 
     * @param string $dir
     * 
     * @return void
     */
    function plugin($dir = ''){

        $plugin = DIR_PLUGINS . '/' . $dir;

        if(!is_dir($plugin)){
            throw new Exception('Plugin ' . $dir . ' does not exist!');
        }

        $file = DIR_PLUGINS . '/' . $dir . '/index.php';

        if(!file_exists($file)){
            throw new Exception('Plugin unavailable!');
        }

        require_once($file);

    }

}