<?php

declare(strict_types = 1);

require_once(SYSTEM . DS . 'core' . DS .'Autoload.php');
require_once(SYSTEM . DS . 'core' . DS . 'Functions.php');

System\Core\Autoload::Initialize();

error_reporting(0);
set_error_handler('System\\Core\\error_handler');
set_exception_handler('System\\Core\\exception_handler');
register_shutdown_function('System\\Core\\shutdown_handler');

System\Core\Config::Initialize();
System\Core\DB::Initialize();
System\Core\Plugin::Initialize();
System\Core\Router::Run();