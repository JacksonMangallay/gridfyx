<?php declare(strict_types = 1);

defined('BASEPATH') || exit('Direct access is forbidden');

ini_set('expose_php','off');

//Load startup files
require_once(DIR_CORE . '/common.php');
require_once(DIR_CORE . '/functions.php');
require_once(DIR_CORE . '/config.php');
require_once(DIR_CORE . '/autoload.php');

//Custom error handlers
error_reporting(0);
set_error_handler('System\\Core\\error_handler');
set_exception_handler('System\\Core\\exception_handler');
register_shutdown_function('System\\Core\\shutdown_handler');

//Check if system supports server's PHP version (requires PHP version 7.0 or newer)
check_version();

//Load all system and user-custom classes
(new System\Core\Autoload());

//Run application router
(new Router())->run();