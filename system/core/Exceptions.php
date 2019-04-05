<?php

declare(strict_types = 1);

namespace System\Core;

class Exceptions{

    private $display_error;
    private $log_error;
    private $timezone;
    private $date_format;
    private $severity = [
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
    ];

    public function __construct(){
        $this->display_error = Config::GetDisplayError();
        $this->log_error = Config::GetLogError();
        $this->timezone = Config::GetTimezone();
        $this->date_format = Config::GetDateFormat();
    }

    public function ErrorHandler(Int $severity, String $message, String $file, Int $line){
        $this->Handle($severity,$message,$file,$line);
    }

    private function Handle(Int $severity, String $message, String $file, Int $line){

        date_default_timezone_set($this->timezone);

        $date = date($this->date_format);
        $severity = $this->severity[$severity];
        $message = '[' .$date. '] [' . $severity . '] ' . $message . ' - ' . $file . ' --> Line ' . $line;

        if($this->display_error){
            $this->DisplayLog($message);
        }

        if($this->log_error){
            $this->WriteLog($message);
        }

    }

    private function WriteLog(String $message){

        $error_log_file = DATA . DS . 'logs' . DS . 'errors.txt';

        $fp = fopen($error_log_file, 'ab');

        if(flock($fp, LOCK_EX)){
            fwrite($fp, $message . "\n");
            fflush($fp);
            flock($fp, LOCK_UN);
        }else{
            $this->DisplayLog('Unable to write error log file.');
        }

        fclose($fp);

    }

    private function DisplayLog(String $message){

        $error = '<div style="position: relative; z-index: 999; display: block; clear: both; background-color: #fcf8e3; border: 1px solid #843534; color: #8a6d3b; box-sizing: border-box; padding: 20px; margin-bottom: 10px;">';
        $error .= $message;
        $error .= '</div>';
        echo $error;

    }
    
}