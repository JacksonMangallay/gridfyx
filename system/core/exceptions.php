<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') || exit('Direct access is forbidden');

use System\Core\Config;

final class Exceptions extends Config{

    private $settings = null;
    private $display_error = null;
    private $log_error = null;
    private $timezone = null;
    private $date_format = null;

    private $severity = array(
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parsing Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Runtime Notice'
    );

    public function __construct(){

        parent::__construct();

        self::config()->load('app');
        $this->settings = self::config()->get('app');

        $this->display_error = $this->settings['development_environment'] ? true : false;
        $this->log_error = true;
        $this->timezone = $this->settings['timezone'];
        $this->date_format = $this->settings['date_format'];

    }

	/**
	 * 
     * @param string $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * 
     */
    public function error_handler($severity = '', $message = '', $file = '', $line = ''){

        date_default_timezone_set($this->timezone);

        $date = date($this->date_format);
        $severity = $this->severity[$severity];
        $message = '[' .$date. '] [' . $severity . '] ' . $message . ' - ' . $file . ' --> Line ' . $line;
        
        write_log($message, 'error');

        if($this->display_error){
            display_log($message);
        }

    }

}