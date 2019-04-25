<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

require_once(SYSTEM . DS . 'core' . DS .'Autoload.php');
require_once(SYSTEM . DS . 'core' . DS . 'Functions.php');

System\Core\Autoload::initialize();

error_reporting(0);
set_error_handler('System\\Core\\error_handler');
set_exception_handler('System\\Core\\exception_handler');
register_shutdown_function('System\\Core\\shutdown_handler');

System\Core\Config::initialize();
System\Core\DB::initialize();
System\Core\Plugin::initialize();
System\Core\Minify::initialize();
System\Core\Router::run();