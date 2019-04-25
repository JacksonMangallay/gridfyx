<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\Router;

Router::get('/',[
    'method' => 'index'
]);